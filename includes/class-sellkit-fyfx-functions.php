<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://fundyourfx.com
 * @since      1.0.0
 *
 * @package    Sellkit_Fyfx
 * @subpackage Sellkit_Fyfx/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sellkit_Fyfx
 * @subpackage Sellkit_Fyfx/includes
 * @author     Ardika JM Consulting <ardi@jm-consulting.id>
 */

// Add menu item
function sellkit_fyfx_add_admin_menu() {
    add_menu_page('SellKit FX', 'SellKit FX', 'manage_options', 'sellkit-fyfx', 'sellkit_fyfx_settings_page', 'dashicons-cart', 59);
}
add_action('admin_menu', 'sellkit_fyfx_add_admin_menu');

// Settings page
function sellkit_fyfx_settings_page() {
    ?>
    <div class="wrap">
        <h2>SellKit FX Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('sellkit_fyfx_settings_group'); ?>
            <?php do_settings_sections('sellkit-fyfx'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register settings
function sellkit_fyfx_register_settings() {
    register_setting('sellkit_fyfx_settings_group', 'sellkit_fyfx_enable_plugin');
    register_setting('sellkit_fyfx_settings_group', 'sellkit_fyfx_enable_badges_payment');
    register_setting('sellkit_fyfx_settings_group', 'sellkit_fyfx_enable_terms_conditions');
    register_setting('sellkit_fyfx_settings_group', 'sellkit_fyfx_enable_css_editor');
    register_setting('sellkit_fyfx_settings_group', 'sellkit_fyfx_custom_css');

    add_settings_section('sellkit_fyfx_general_settings', 'General Settings', null, 'sellkit-fyfx');

    add_settings_field('sellkit_fyfx_enable_plugin', 'Enable Plugin', 'sellkit_fyfx_enable_plugin_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_enable_badges_payment', 'Enable Badges Payment', 'sellkit_fyfx_enable_badges_payment_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_enable_terms_conditions', 'Enable Terms and Conditions', 'sellkit_fyfx_enable_terms_conditions_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_enable_css_editor', 'Enable CSS Editor', 'sellkit_fyfx_enable_css_editor_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_custom_css', 'Custom CSS', 'sellkit_fyfx_custom_css_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
}
add_action('admin_init', 'sellkit_fyfx_register_settings');

// Callback functions for settings fields
function sellkit_fyfx_enable_plugin_callback() {
    $value = get_option('sellkit_fyfx_enable_plugin', 'disable');
    echo '<select name="sellkit_fyfx_enable_plugin"><option value="enable"' . selected($value, 'enable', false) . '>Enable</option><option value="disable"' . selected($value, 'disable', false) . '>Disable</option></select>';
}

function sellkit_fyfx_enable_badges_payment_callback() {
    $value = get_option('sellkit_fyfx_enable_badges_payment', 'disable');
    echo '<select name="sellkit_fyfx_enable_badges_payment"><option value="enable"' . selected($value, 'enable', false) . '>Enable</option><option value="disable"' . selected($value, 'disable', false) . '>Disable</option></select>';
}

function sellkit_fyfx_enable_terms_conditions_callback() {
    $value = get_option('sellkit_fyfx_enable_terms_conditions', 'disable');
    echo '<select name="sellkit_fyfx_enable_terms_conditions"><option value="enable"' . selected($value, 'enable', false) . '>Enable</option><option value="disable"' . selected($value, 'disable', false) . '>Disable</option></select>';
}

function sellkit_fyfx_enable_css_editor_callback() {
    $value = get_option('sellkit_fyfx_enable_css_editor', 'disable');
    echo '<select name="sellkit_fyfx_enable_css_editor"><option value="enable"' . selected($value, 'enable', false) . '>Enable</option><option value="disable"' . selected($value, 'disable', false) . '>Disable</option></select>';
}

function sellkit_fyfx_custom_css_callback() {
    $value = get_option('sellkit_fyfx_custom_css', '');
    echo '<textarea name="sellkit_fyfx_custom_css" rows="10" cols="50">' . esc_textarea($value) . '</textarea>';
}

if ( strpos($_SERVER['REQUEST_URI'], '/sellkit_step/') !== false ) {
    add_action( 'init', 'replace_sellkit_action',9999 );
}

function replace_sellkit_action() {
    // Cek apakah class Multi_Step tersedia
    if ( class_exists( '\Sellkit\Elementor\Modules\Checkout\Classes\Multi_Step' ) ) {
        // Menghapus action asli
        $settings = array(
            'show_preview_box' => 'no', // contoh pengaturan
            'show_breadcrumb' => 'no',   // contoh pengaturan lainnya,
            'show_shipping_method' => 'no',
            'show_sticky_cart_details' => 'no'
        );        
        $multi_step_instance = new \Sellkit\Elementor\Modules\Checkout\Classes\Multi_Step( $settings );

        // Pastikan instance telah dibuat dan method 'first_step_begin' ada
        if ( isset( $multi_step_instance ) && method_exists( $multi_step_instance, 'first_step_begin' ) ) {
            // Menghapus action dengan method 'first_step_begin' dan prioritas 10
            remove_action( 'sellkit-checkout-multistep-sidebar-begins', [$multi_step_instance,'sidebar_starts'], 40);
            remove_action('sellkit-checkout-multistep-sidebar-begins', ['\Sellkit\Elementor\Modules\Checkout\Classes\Multi_Step', 'sidebar_starts'], 10);
            remove_all_actions('sellkit-checkout-multistep-sidebar-begins');
            add_action( 'wp_footer', 'my_new_function' );
   
        } 
    }
}

// Fungsi baru Anda yang akan menggantikan first_step_begin
function my_new_function() {
    ?>
    <script type="text/javascript">
        let buttonOrder = document.querySelector('.sellkit-one-page-checkout-place-order');
        let reviewOrder = document.querySelector('.sellkit-checkout-right-column .sellkit-multistep-checkout-sidebar .woocommerce-checkout-review-order .woocommerce-checkout-review-order-table');
        reviewOrder.parentNode.insertBefore(buttonOrder, reviewOrder.nextSibling);

        jQuery(document).ready(function($) {
            var heading = $('.sellkit-checkout-order-review-heading.header.heading');
            if (heading.length && heading.text().trim() === "Your order") {
                heading.text('Your Product');
            }
        });
    </script>
    <?php
}

add_filter( 'woocommerce_ship_to_different_address_checked', '_return_true' );

add_filter( 'woocommerce_default_address_fields', 'custom_override_default_checkout_fields', 10, 1 );
function custom_override_default_checkout_fields( $address_fields ) {
    $address_fields['address_1']['placeholder'] = __( 'Address *', 'woocommerce' );

    return $address_fields;
}