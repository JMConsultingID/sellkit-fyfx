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
    add_menu_page('SellKit FX', 'SellKit FX', 'manage_options', 'sellkit-fyfx', 'sellkit_fyfx_settings_page', 'dashicons-beer', '58.5');
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
        <hr>
        <h3>Export Settings</h3>
        <p>
            <button type="button" class="button" id="sellkit-fyfx-export">Export Settings</button>
        </p>
        <h3>Import Settings</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="sellkit_fyfx_import_file" accept=".json">
            <button type="submit" class="button" name="sellkit_fyfx_import">Import Settings</button>
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
    register_setting('sellkit_fyfx_settings_group', 'sellkit_fyfx_custom_js');

    add_settings_section('sellkit_fyfx_general_settings', 'General Settings', null, 'sellkit-fyfx');

    add_settings_section('sellkit_fyfx_general_settings', 'General Settings', 'sellkit_fyfx_general_settings_callback', 'sellkit-fyfx');

    add_settings_field('sellkit_fyfx_enable_plugin', 'Enable Plugin', 'sellkit_fyfx_enable_plugin_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_enable_badges_payment', 'Enable Badges Payment', 'sellkit_fyfx_enable_badges_payment_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_enable_terms_conditions', 'Enable Terms and Conditions', 'sellkit_fyfx_enable_terms_conditions_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_enable_css_editor', 'Enable CSS/JS Editor', 'sellkit_fyfx_enable_css_editor_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_custom_css', 'Custom CSS', 'sellkit_fyfx_custom_css_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
    add_settings_field('sellkit_fyfx_custom_js', 'Custom JS', 'sellkit_fyfx_custom_js_callback', 'sellkit-fyfx', 'sellkit_fyfx_general_settings');
}
add_action('admin_init', 'sellkit_fyfx_register_settings');

// Callback function for the "General Settings" section
function sellkit_fyfx_general_settings_callback() {
    echo '<p>These are the general settings for the SellKit FX plugin. Please feel free to customize them according to your needs.</p>';
}

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
    echo '<textarea id="sellkit-fyfx-css-editor" name="sellkit_fyfx_custom_css" rows="10" cols="50">' . esc_textarea($value) . '</textarea>';
}

function sellkit_fyfx_custom_js_callback() {
    $value = get_option('sellkit_fyfx_custom_js', '');
    echo '<textarea id="sellkit-fyfx-js-editor" name="sellkit_fyfx_custom_js" rows="10" cols="50">' . esc_textarea($value) . '</textarea>';
}


function sellkit_fyfx_enqueue_scripts($hook) {
    if ($hook != 'toplevel_page_sellkit-fyfx') {
        return;
    }

    // Enqueue CodeMirror scripts and styles
    wp_enqueue_style('wp-codemirror');
    wp_enqueue_script('wp-codemirror');
    wp_enqueue_script('css-codemirror', plugins_url('../public/js/css-codemirror.js', __FILE__), array('wp-codemirror'), '1.0.0', true);

    // Enqueue the codemirror settings from WordPress
    wp_enqueue_code_editor(array('type' => 'text/css'));
    wp_enqueue_code_editor(array('type' => 'text/javascript'));
}
add_action('admin_enqueue_scripts', 'sellkit_fyfx_enqueue_scripts');


function sellkit_fyfx_export_settings() {
    if (!isset($_GET['sellkit_fyfx_export'])) {
        return;
    }

    $settings = array(
        'sellkit_fyfx_enable_plugin' => get_option('sellkit_fyfx_enable_plugin'),
        'sellkit_fyfx_enable_badges_payment' => get_option('sellkit_fyfx_enable_badges_payment'),
        'sellkit_fyfx_enable_terms_conditions' => get_option('sellkit_fyfx_enable_terms_conditions'),
        'sellkit_fyfx_enable_css_editor' => get_option('sellkit_fyfx_enable_css_editor'),
        'sellkit_fyfx_custom_css' => get_option('sellkit_fyfx_custom_css'),
        'sellkit_fyfx_custom_js'  => get_option('sellkit_fyfx_custom_js'),
        // Tambahkan pengaturan lainnya jika diperlukan
    );

    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="sellkit-fyfx-settings.json"');
    echo json_encode($settings);
    exit;
}
add_action('admin_init', 'sellkit_fyfx_export_settings');

function sellkit_fyfx_import_settings() {
    if (!isset($_FILES['sellkit_fyfx_import_file'])) {
        return;
    }

    $file = $_FILES['sellkit_fyfx_import_file'];
    if ($file['type'] !== 'application/json') {
        wp_die('Invalid file type.');
    }

    $settings = json_decode(file_get_contents($file['tmp_name']), true);
    if (!$settings) {
        wp_die('Invalid file content.');
    }

    foreach ($settings as $key => $value) {
        update_option($key, $value);
    }

    wp_redirect(add_query_arg('settings-imported', 'true', admin_url('admin.php?page=sellkit-fyfx')));
    exit;
}
add_action('admin_init', 'sellkit_fyfx_import_settings');


//------------------- Start Front End Functions --------------------------------

// Check if the plugin is enabled and if the current request URI matches the given pattern
function sellkit_fyfx_check_request_uri() {
    if (get_option('sellkit_fyfx_enable_plugin') == 'enable') {
        if (strpos($_SERVER['REQUEST_URI'], '/sellkit_step/') !== false) {
            add_action('init', 'replace_sellkit_action', 9999);
        }
    }
}
add_action('init', 'sellkit_fyfx_check_request_uri', 1); // Run this early on the 'init' hook

add_filter( 'woocommerce_default_address_fields', 'custom_override_default_checkout_fields', 10, 1 );
function custom_override_default_checkout_fields( $address_fields ) {
    $address_fields['address_1']['placeholder'] = __( 'Address *', 'woocommerce' );

    return $address_fields;
}
add_filter( 'woocommerce_ship_to_different_address_checked', '_return_true' );