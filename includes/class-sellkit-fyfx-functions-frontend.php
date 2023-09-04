<?php
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

function sellkit_fyfx_enqueue_frontend_scripts() {
    // Cek apakah plugin diaktifkan
    if (get_option('sellkit_fyfx_enable_plugin') !== 'enable') {
        return;
    }

    if (strpos($_SERVER['REQUEST_URI'], '/sellkit_step/') !== true) {
        return;
    }

    // Jika CSS Editor diaktifkan, tambahkan CSS ke frontend
    if (get_option('sellkit_fyfx_enable_css_editor') === 'enable') {
        $custom_css = get_option('sellkit_fyfx_custom_css');
        if (!empty($custom_css)) {
            wp_add_inline_style('wp-block-library', $custom_css); // 'wp-block-library' adalah handle untuk salah satu stylesheets inti WordPress. Anda bisa menggantinya dengan handle stylesheet lain jika diperlukan.
        }

        $custom_js = get_option('sellkit_fyfx_custom_js');
        if (!empty($custom_js)) {
            wp_add_inline_script('jquery-core', $custom_js); // 'jquery-core' adalah handle untuk jQuery, yang merupakan salah satu skrip inti WordPress. Anda bisa menggantinya dengan handle skrip lain jika diperlukan.
        }
    }

    // Jika Anda juga ingin menambahkan JS Editor di masa depan, Anda bisa menambahkannya di sini dengan cara yang serupa.
}
add_action('wp_enqueue_scripts', 'sellkit_fyfx_enqueue_frontend_scripts', 100); // Prioritas 100 untuk memastikan ini dijalankan setelah stylesheet lainnya.
