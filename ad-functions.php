<?php
	function show_form(){
		
		$follow=get_option('add_fees_follow');
		
		?>
		<div class="wrap">
			<h1>Add Fees</h1>
			<p>Set here the fees you want to add when PP is selected :</p><br>
			<form method="post" action="options.php">
				<?php 
					settings_fields( 'add_fees_options' ); 
					if($follow==1)
					{
						?>
						<table class="form-table">
					        <tr valign="top">
						        <th scope="row">Amount</th>
								<td><input type="text" id="add_fees_amount" name="add_fees_amount" value="<?php echo esc_attr( get_option('add_fees_montant') ); ?>" disabled/></td>
					        </tr>
					        <tr>
						        <th scope="row">Follow PP fees</th>
								<td><input id="add_fees_follow" name="add_fees_follow" value="1" type="checkbox" checked></td>
					        </tr>
					    </table>
			    		<?php
					}
					else
					{
						?>
						<table class="form-table">
					        <tr valign="top">
						        <th scope="row">Amount</th>
								<td><input type="text" id="add_fees_amount" name="add_fees_amount" value="<?php echo esc_attr( get_option('add_fees_montant') ); ?>" /></td>
					        </tr>
					        <tr>
						        <th scope="row">Follow PP fees</th>
								<td><input id="add_fees_follow" name="add_fees_follow" value="1" type="checkbox"></td>
					        </tr>
					    </table>
					    <?php
					}
					submit_button(); 
				?>
			</form>
		</div>
		<?php
	}
	
	function add_fees_register_settings(){
		add_option( 'add_fees_amount', '');
		register_setting( 'add_fees_options', 'add_fees_amount', '0' );
		add_option( 'add_fees_follow', '0');
		register_setting( 'add_fees_options', 'add_fees_follow', '0' );
	}
	
	function add_fees_add() {
		$total_order=WC()->cart->cart_contents_total;
		
		if(get_option('add_fees_follow')==1)
		{
			switch($total_order)
			{
				case $total_order <= 2500:
					$fees_paypal=($total_order*0.034)+0.25;
					break;
				
				case $total_order <= 10000:
					$fees_paypal=($total_order*0.02)+0.25;
					break;
				case $total_order <= 50000:
					$fees_paypal=($total_order*0.018)+0.25;
					break;
				case $total_order <= 100000:
					$fees_paypal=($total_order*0.016)+0.25;
					break;
				case $total_order > 100000:
					$fees_paypal=($total_order*0.014)+0.25;
					break;
			}
		}
		else
		{
			$fees_paypal=get_option('add_fees_amount');
		}
	    $chosen_gateway = WC()->session->get( 'chosen_payment_method' );
	    if ( $chosen_gateway == 'paypal' ) {
	    	WC()->cart->add_fee( 'PayPal', $fees_paypal );
	   }
	}

	function add_fees_change_method(){
	    ?>
	    <script type="text/javascript">
	        (function($){
	            $('form.checkout').on('change','input[name^="payment_method"]',function(){
	                $('body').trigger('update_checkout');
	            });
	        })(jQuery);
	    </script>
	    <?php
	}
?>