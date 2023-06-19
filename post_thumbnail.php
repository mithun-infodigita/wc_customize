<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;



$image_attribtes = $product->get_attribute('images');
if(!empty($image_attribtes)) {
	$images = explode("|", $image_attribtes);

	if ( count($images) ) {
		$html = '<ol class="flex-control-nav flex-control-thumbs">';

		$current = 1;
		foreach ( $images as $image ) {
			$html.= sprintf('<li><img onload="this.width = this.naturalWidth; this.height = this.naturalHeight" src="%s" draggable="false" width="100" height="100" class="%s"></li>', $image, $current == 1 ? 'flex-active': '');
			$current++;
		}


		$html.= '</ol>';

		echo $html;
	
	// printf('<ol class="flex-control-nav flex-control-thumbs">
	// 		<li><img onload="this.width = this.naturalWidth; this.height = this.naturalHeight" src="http://localhost:8080/wp-content/uploads/2022/10/13-100x100.png" draggable="false" width="100" height="100" class="flex-active"></li>
	// 		<li><img onload="this.width = this.naturalWidth; this.height = this.naturalHeight" src="http://localhost:8080/wp-content/uploads/2022/10/10-100x100.png" draggable="false" width="100" height="100" class=""></li>
	// 		<li><img onload="this.width = this.naturalWidth; this.height = this.naturalHeight" src="http://localhost:8080/wp-content/uploads/2022/10/14-100x100.png" draggable="false" width="100" height="100" class=""></li>
	// 		<li><img onload="this.width = this.naturalWidth; this.height = this.naturalHeight" src="http://localhost:8080/wp-content/uploads/2022/10/11-100x100.png" draggable="false" width="100" height="100" class=""></li>
	// 		<li><img onload="this.width = this.naturalWidth; this.height = this.naturalHeight" src="http://localhost:8080/wp-content/uploads/2022/10/12-100x100.png" draggable="false" width="100" height="100"></li>
	// 	</ol>'
	}

}else {
	$attachment_ids = $product->get_gallery_image_ids();

	if ( $attachment_ids && $product->get_image_id() ) {
		$html = '';
		foreach ( $attachment_ids as $attachment_id ) {
			$html.=  apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped


		}
		// var_dump($html);exit;

		file_put_contents('gallery.txt', $html);
		echo $html;
	}

}
