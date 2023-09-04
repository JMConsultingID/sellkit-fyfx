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