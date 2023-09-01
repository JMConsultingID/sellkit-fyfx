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
// Akses variabel global yang berisi instance dari class Multi_Step
global $global_multi_step_instance;

// Cek apakah instance tersebut valid
if (isset($global_multi_step_instance) && $global_multi_step_instance instanceof \Sellkit\Elementor\Modules\Checkout\Classes\Multi_Step) {
    // Sekarang Anda bisa berinteraksi dengan instance tersebut
    // Contoh: Menghapus action yang terkait dengan metode sidebar_starts
    remove_action('sellkit-checkout-multistep-sidebar-begins', [$global_multi_step_instance, 'sidebar_starts'], 10);

    // Menambahkan action baru Anda
    add_action('sellkit-checkout-multistep-sidebar-begins', 'my_new_sidebar_function', 10);
}

// Fungsi baru Anda untuk menggantikan sidebar_starts
function my_new_sidebar_function() {
    // Konten atau logika Anda di sini
    echo '<div>Your new sidebar content here</div>';
}