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
function replace_sellkit_action() {
    // Cek apakah class Multi_Step tersedia
    if ( class_exists( '\Sellkit\Elementor\Modules\Checkout\Classes\Multi_Step' ) ) {
        // Menghapus action asli
        $settings = array(
            // Anda perlu mengisi array ini dengan pengaturan yang sesuai
            // berdasarkan konstruktor class Multi_Step
            'show_preview_box' => 'no', // contoh pengaturan
            'show_breadcrumb' => 'no'    // contoh pengaturan lainnya
        );
        
        $multi_step_instance = new \Sellkit\Elementor\Modules\Checkout\Classes\Multi_Step( $settings );


        // Pastikan instance telah dibuat dan method 'first_step_begin' ada
        if ( isset( $multi_step_instance ) && method_exists( $multi_step_instance, 'first_step_begin' ) ) {
            // Menghapus action dengan method 'first_step_begin' dan prioritas 10
            remove_action( 'sellkit-checkout-step-a-begins', [ $multi_step_instance, 'first_step_begin' ], 20 );
            add_action( 'sellkit-checkout-step-a-begins', 'my_new_function_be', 20 );
            // Menambahkan JavaScript untuk menyembunyikan elemen dengan class .sellkit-multistep-checkout-first
   
        }

        // Remove the original action
        // Pastikan instance telah dibuat dan method 'first_step_begin' ada
        if ( isset( $multi_step_instance ) && method_exists( $multi_step_instance, 'sidebar_starts' ) ) {
            remove_action('sellkit-checkout-multistep-sidebar-begins', [$multi_step_instance, 'sidebar_starts'], 10);
            add_action( 'wp_footer', 'my_new_function' );
        }

        // Add your new action
        add_action('sellkit-checkout-multistep-sidebar-begins', 'my_new_sidebar_function', 10);

                
        
    }
}
add_action( 'init', 'replace_sellkit_action',100 );

// Your new function to replace sidebar_starts
function my_new_sidebar_function() {
    // Your content or logic here
    echo '<div>Your new sidebar content here</div>';
}

// Fungsi baru Anda yang akan menggantikan first_step_begin
function my_new_function_be() {
    echo '<div class="your-sellkitbe">Your new content herebe</div>';
}

// Fungsi baru Anda yang akan menggantikan first_step_begin
function my_new_function() {
    // Konten atau logika Anda di sini
    echo '<div class="your-sellkit">Your new content here</div>';
}