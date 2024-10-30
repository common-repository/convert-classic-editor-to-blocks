<?php

/**
 *
 * @link              https://www.thedotstore.com/
 * @since             1.0.0
 * @package           Convert Classic Editor to Gutenberg Blocks
 *
 * @wordpress-plugin
 * Plugin Name:       Convert Classic Editor to Gutenberg Blocks
 * Plugin URI:        https://www.thedotstore.com/
 * Description:       This plugin will useful for convert existing classic editor post to Gutenberg blocks post.
 * Version:           1.0.6
 * Author:            theDotstore
 * Author URI:        https://www.thedotstore.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       convert-classic-editor-to-gutenberg-blocks
 */
/**
 * Exit if accessed directly
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
register_activation_hook( __FILE__, array( 'CCETGB_Admin_Settings', 'ccetgb_plugin_activation' ) );

if ( function_exists( 'ccetb_fs' ) ) {
    ccetb_fs()->set_basename( false, __FILE__ );
    return;
}


if ( !function_exists( 'ccetb_fs' ) ) {
    // Create a helper function for easy SDK access.
    function ccetb_fs()
    {
        global  $ccetb_fs ;
        
        if ( !isset( $ccetb_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $ccetb_fs = fs_dynamic_init( array(
                'id'             => '4760',
                'slug'           => 'convert-classic-editor-to-blocks',
                'premium_slug'   => 'woocommerce-conditional-product-fees-for-checkout-premium',
                'type'           => 'plugin',
                'public_key'     => 'pk_499f9f03bece1899cac00ecc8110b',
                'is_premium'     => false,
                'premium_suffix' => 'Pro',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'    => 'ccetgb-classic-editor-to-gutenberg-blocks',
                'contact' => false,
                'support' => false,
                'parent'  => array(
                'slug' => 'options-general.php',
            ),
            ),
                'is_live'        => true,
            ) );
        }
        
        return $ccetb_fs;
    }
    
    // Init Freemius.
    ccetb_fs();
    // Signal that SDK was initiated.
    do_action( 'ccetb_fs_loaded' );
    ccetb_fs()->add_action( 'after_uninstall', 'ccetb_fs_uninstall_cleanup' );
}

require_once plugin_dir_path( __FILE__ ) . 'class.convert-classic-to-gb-blocks-admin.php';
add_action( 'init', array( 'CCETGB_Admin_Settings', 'ccetgb_init' ) );

if ( is_admin() ) {
    /**
     * Admin side user review block
     */
    require_once plugin_dir_path(__FILE__) . 'includes/class-convert-classic-editor-to-gb-blocks-user-feedback.php';
    require_once plugin_dir_path( __FILE__ ) . 'class.convert-classic-to-gb-blocks.php';
    $convert_to_block = new CCETGB_Convert_Classic_to_GB_Blocks();
}
