<?php
/**
 * Product with right sidebar.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.16.0
 */

?>
<div class="product-container">
<div class="product-main">
<div class="row mb-0 content-row">

	<div class="product-gallery large-<?php echo flatsome_option('product_image_width'); ?> col">
	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
	</div>

	<div class="product-info summary col-fit col-divided col entry-summary <?php flatsome_product_summary_classes();?>">
 <?php
            if ( have_rows("variations_product")) {
            ?>
            <div class="variations_form">

                    <?php
                    while( have_rows("variations_product" )){
                        the_row();
                        $lists_product = get_sub_field("lists_product");
                        $total_variations = count($lists_product);
                        $item_select = array_filter($lists_product,function($arr){
                            return count($arr["is_select"]) > 0;
                        });
                        $item_select = array_shift(array_values($item_select));
                    ?>


                            <label for="">
                                <?php printf("Có <strong>%s %s </strong>. Bạn đang chọn <strong>%s</strong>",$total_variations,get_sub_field("title"),$item_select["key"]); ?>
                            </label>


                            <div class="swatches-select swatches-on-single">
                                <?php
                                foreach ($lists_product as $item) {
                                    $active = ($item == $item_select) ? "active-swatch" : "";
                                ?>
                                <a class="wd-swatch swatch-on-single <?php echo $active; ?>" href="<?php the_permalink( $item["product"] )?>"><?php echo $item["key"]; ?></a>
                                <?php
                                }
                                ?>

                            </div>

                    <?php
                    }
                    ?>

            </div>


            <?php
            }
            ?>  
		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>

	</div>

	<div id="product-sidebar" class="col large-3 hide-for-medium <?php flatsome_sidebar_classes(); ?>">
		<?php
			do_action('flatsome_before_product_sidebar');
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			if (is_active_sidebar( 'product-sidebar' ) ) {
					dynamic_sidebar('product-sidebar');
			} else if(is_active_sidebar( 'shop-sidebar' )) {
					dynamic_sidebar('shop-sidebar');
			}
		?>
	</div>

</div>
</div>

<div class="product-footer">
	<div class="container">
		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
</div>
</div>
