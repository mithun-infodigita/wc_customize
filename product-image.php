
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
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;


$image_attribtes = $product->get_attribute('images');
if(!empty($image_attribtes)) {
	//Customizes code
	$images = explode("|", $image_attribtes);


	$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$post_thumbnail_id = $product->get_image_id();
	$wrapper_classes   = apply_filters(
		'woocommerce_single_product_image_gallery_classes',
		array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery-with-images',
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		)
	);
	
	?>

	<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
		<figure class="woocommerce-product-gallery__wrapper">
			<?php
			if ( count($images) ) {
				$first_image_url = $images[0];

				$html = sprintf('<div
				data-thumb="%s"
				data-thumb-alt="" class="woocommerce-product-gallery__image"
				style="position: relative; overflow: hidden;"
				>
				<a href="%s">
				  <img width="600" height="450"
					src="%s"
					class="wp-post-image" alt="" decoding="async" loading="lazy" title="208_result"
					data-caption=""
					data-src="%s"
					data-large_image="%s"
					data-large_image_width="960" data-large_image_height="720"
					srcset="
						%s 600w, 
						%s 300w, 
						%s 768w, 
						%s 960w
					"
					sizes="(max-width: 600px) 100vw, 600px">
				</a>
				  <img role="presentation" alt=""
					src="%s" class="zoomImg"
					style="position: absolute; top: -196.865px; left: -122.218px; opacity: 1; width: 960px; height: 720px; border: none; max-width: none; max-height: none;"
					>
				</div>',
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
					$first_image_url, 
				);
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

			do_action( 'woocommerce_product_thumbnails' );
			?>
		</figure>
	</div>

	


<?php 
	//Default code
} else {
	$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$post_thumbnail_id = $product->get_image_id();
	$wrapper_classes   = apply_filters(
		'woocommerce_single_product_image_gallery_classes',
		array(
			'woocommerce-product-gallery',
			'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
			'woocommerce-product-gallery--columns-' . absint( $columns ),
			'images',
		)
	);
	
	?>
	<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
		<figure class="woocommerce-product-gallery__wrapper">
			<?php
			if ( $post_thumbnail_id ) {
				$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
				$html .= '</div>';
			}

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

			do_action( 'woocommerce_product_thumbnails' );
			?>
		</figure>
	</div>

<?php } ?>
