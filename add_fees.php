<?php
/*
Description: Add PP fees calculated on the order amount.
Plugin Name: Add PP Fees
Author: Sylvain DELPECH
Version: 0.1
Depends: Woocommerce
* License:      GPL-2.0+
* License URI:  http://www.gnu.org/licenses/gpl-2.0.html
*/
 
require_once plugin_dir_path(__FILE__) . 'ad-functions.php';
 
// Hook the 'admin_menu' action hook, run the function named 'mfp_Add_My_Admin_Link()'
add_action( 'admin_menu', 'ad_menu' );
 
// Add a new top level menu link to the ACP
function ad_menu()
{
      add_menu_page(
        'Add Fees', // Title of the page
        'Add Fees', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'admin.php?page=ad-functions', // The 'slug' - file to display when clicking the link
        'show_form'
    );
}

//Change le montant des frais à ajouter
add_action( 'woocommerce_cart_calculate_fees', 'add_fees_add' );

//Surveille les changements de méthode de paiement	  
add_action( 'woocommerce_review_order_before_payment', 'add_fees_change_method' );  

//Initiailisation des options
add_action( 'admin_init', 'add_fees_register_settings' );
?>