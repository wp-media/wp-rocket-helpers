<?php
/**
 * Plugin Name: WP Rocket | Clean Post Cache after WooCommerce Order
 * Description: Cleans the cache for each product ordered after a WooCommerce order has been completed.
 * Plugin URI:  https://github.com/wp-media/wp-rocket-helpers/tree/master/compatibility/wp-rocket-compat-wc-order-clean-cache/
 * Author:      WP Rocket Support Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Copyright SAS WP MEDIA 2018
 */

namespace WP_Rocket\Helpers\compat\wc_order;

// Standard plugin security, keep this line in place.
defined( 'ABSPATH' ) or die();

/**
 * Programmatically clears the cache for all products included in an order when
 * the payment has been completed.
 *
 * @author Caspar Hübinger
 * @link   https://docs.wp-rocket.me/article/881-update-products-on-stock-after-new-woocommerce-orders
 */
function clean_product_cache_after_order( $order_id ) {

	$order  = new \WC_Order( $order_id );
	$items  = $order->get_items();

	foreach ( $items as $item ) {
		$post_id = absint( $item['product_id'] );
		rocket_clean_post( $post_id );
	}
}
add_action( 'woocommerce_payment_complete', __NAMESPACE__ . '\clean_product_cache_after_order' );
