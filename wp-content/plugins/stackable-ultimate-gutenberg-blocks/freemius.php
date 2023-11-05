<?php

/**
 * Init Freemius.
 */
// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Create a helper function for easy SDK access.

if ( !function_exists( 'sugb_fs' ) ) {
    function sugb_fs()
    {
        global  $sugb_fs ;
        
        if ( !isset( $sugb_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $sugb_fs = fs_dynamic_init( array(
                'id'             => '1748',
                'slug'           => 'stackable-ultimate-gutenberg-blocks',
                'type'           => 'plugin',
                'public_key'     => 'pk_771ae29c5255d20a4880980729a17',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'navigation'     => 'tabs',
                'menu'           => array(
                'slug'        => 'stackable',
                'first-path'  => 'options-general.php?page=stackable-getting-started',
                'account'     => true,
                'pricing'     => true,
                'contact'     => true,
                'support'     => false,
                'affiliation' => false,
                'parent'      => array(
                'slug' => 'options-general.php',
            ),
            ),
                'is_live'        => true,
            ) );
        }
        
        return $sugb_fs;
    }
    
    // Init Freemius.
    sugb_fs();
    // Disable some Freemius features.
    sugb_fs()->add_filter( 'show_deactivation_feedback_form', '__return_false' );
    sugb_fs()->add_filter( 'hide_freemius_powered_by', '__return_true' );
    sugb_fs()->add_filter( 'permission_diagnostic_default', '__return_false' );
    // Disable opt-in option by default
    sugb_fs()->add_filter( 'permission_extensions_default', '__return_false' );
    // Disable opt-in option by default
    // Hide Freemius notices that can easily annoy users.
    sugb_fs()->add_filter(
        'show_admin_notice',
        function ( $show, $message ) {
        if ( in_array( $message['id'], array( 'license_activated', 'premium_activated', 'connect_account' ) ) ) {
            return false;
        }
        return $show;
    },
        10,
        2
    );
    // Signal that SDK was initiated.
    do_action( 'sugb_fs_loaded' );
}
