<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
global $product;

$attachment_ids = $product->get_gallery_image_ids();
$out = '';
if ( $attachment_ids && $product->get_image_id() ) {
	foreach ( $attachment_ids as $attachment_id ) {
		$url = wp_get_attachment_image_url( $attachment_id, 'large');
		$out .= '<p data-zoomimg="'.$url.'">'.wp_get_attachment_image( $attachment_id, 'malina-masonry').'</p>';
	}
}
?>
<div class="woocommerce-images">
	<figure class="woocommerce-product-images">
		<?php
		if ( $product->get_image_id() ) {
			$url = wp_get_attachment_image_url( $post_thumbnail_id, 'large');
			$html = wp_get_attachment_image( $post_thumbnail_id, 'malina-masonry', true );
			$html = '<p data-zoomimg="'.$url.'">'.$html.'<p>';
		} else {
			$html  = '<div class="woocommerce-product-images--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'malina' ) );
			$html .= '</div>';
		}

		echo ''.$html; // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
		echo ''.$out;
		?>
	</figure>
</div>
