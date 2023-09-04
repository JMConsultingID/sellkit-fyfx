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