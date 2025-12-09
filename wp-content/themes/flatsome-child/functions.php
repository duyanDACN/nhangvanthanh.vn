<?php
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );
// remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);
// remove_action('woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30);

/*
* Thêm nút mua ngay vào trang chi tiết sản phẩm Woocommerce
* Author: chowordpress.com
*/
add_action('woocommerce_after_add_to_cart_button','chowordpress_quickbuy_after_addtocart_button');
function chowordpress_quickbuy_after_addtocart_button(){
    global $product;
    ?>
 
    <script>
        jQuery(document).ready(function(){
            jQuery('body').on('click', '.buy_now_button', function(e){
                e.preventDefault();
                var thisParent = jQuery(this).parents('form.cart');
                if(jQuery('.single_add_to_cart_button', thisParent).hasClass('disabled')) {
                    jQuery('.single_add_to_cart_button', thisParent).trigger('click');
                    return false;
                }
                thisParent.addClass('chowordpress-quickbuy');
                jQuery('.is_buy_now', thisParent).val('1');
                jQuery('.single_add_to_cart_button', thisParent).trigger('click');
            });
        });
    </script>
    <?php
}

add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout($redirect_url) {
    if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now']) {
        $redirect_url = wc_get_checkout_url(); //đổi thành wc_get_cart_url()
    }
    return $redirect_url;
}

add_action( 'woocommerce_before_add_to_cart_quantity', 'bbloomer_echo_qty_front_add_cart' );
 
function bbloomer_echo_qty_front_add_cart() {
 echo '<div class="qty">Số lượng : </div>'; 
}

function add_tuvan(){
    ?>
    <div class="summary-action ">
              <a href="javascript:void(0)" class="btn-advise uppercase u-wBold">Tư vấn miễn phí<br><span class="small-des">(8:00 - 22:00)</span></a>
     </div>

     <div id="popup-tu-van">
     <div id="popup-content">
         <?php echo do_shortcode( '[contact-form-7 id="72749" title="Form tư vấn"]' ); ?>
     </div>
 </div>
    <?php

}
add_action('woocommerce_single_product_summary','add_tuvan',40);

// item vi tri
add_action('ux_builder_setup', 'item_vitri');
function item_vitri()
{
    add_ux_builder_shortcode('items_vitri', array(
        'name'      => __('item vị trí'),
        'priority' => 4,
        'category' => __('Content'),
        'options' => array(
            'title_vitri' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Tiêu đề'),
                'default'   =>  '',
            ),
             'image_vitri' =>  array(
                'type'  =>  'image',
                'heading'   =>  __('Hình ảnh'),
                'default'   =>  '',
            ),
            'vitri_mota' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Mô tả'),
                'default'   =>  '',
            ),
            'link__vitri' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Link map'),
                'default'   =>  '',
            ),
             'tel__one' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Phone 1'),
                'default'   =>  '',
            ),
             'tel__tow' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Phone 2'),
                'default'   =>  '',
            ),
        ),
    ));

}

add_shortcode('items_vitri', 'items_vitrifooter');

function items_vitrifooter($atts)
{
    extract(shortcode_atts(array(
        'title_vitri'  => '',
        'image_vitri'   =>  '',
        'vitri_mota'    =>  '',
        'link__vitri'    =>  '',
        'tel__one'    =>  '',
        'tel__tow'    =>  '',
    ), $atts));
    ob_start();
?>
    <div class="items_vitri">
        <div class="img_vtri">
              <?php    $tel_vitri = wp_get_attachment_image_src( $image_vitri, 'full' ); ?>
            <img src="<?php echo $tel_vitri[0]; ?>" alt="icon vitri">
        </div>
        <div class="content_vitri">
            <p>
                <span><?php echo $title_vitri; ?></span> <?php echo $vitri_mota; ?> <?php if (!empty($link__vitri)): ?>
                <?php 
                    if (!empty($tel__one)) {
                     ?>
                     <div class="tel__tel">
                         <strong>Tổng đài: </strong><a href="tel:<?php echo $tel__one; ?>"><?php echo $tel__one; ?></a> <a href="tel:<?php echo $tel__tow; ?>"><?php echo $tel__tow; ?></a> 
                     </div>
                     <?php
                    }
                 ?>
                    <a class="map__map" href="<?php echo $link__vitri ?>" target="_blank" >Xem bản đồ</a>
                <?php endif ?>
            </p>
        </div>
    </div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

// item hotline
add_action('ux_builder_setup', 'item_hotline');
function item_hotline()
{
    add_ux_builder_shortcode('items_hotline', array(
        'name'      => __('item hotline'),
        'priority' => 3,
        'category' => __('Content'),
        'options' => array(
            'title_hotline' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Tiêu đề'),
                'default'   =>  '',
            ),
             'image_hotline' =>  array(
                'type'  =>  'image',
                'heading'   =>  __('Hình ảnh'),
                'default'   =>  '',
            ),
            'tel_tel' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Số điện thoại'),
                'default'   =>  '',
            ),
             'tel_tel2' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Số điện thoại 2'),
                'default'   =>  '',
            ),
        ),
    ));

}
add_shortcode('items_hotline', 'items_phone');

function items_phone($atts)
{
    extract(shortcode_atts(array(
        'title_hotline'  => '',
        'image_hotline'   =>  '',
        'tel_tel'    =>  '',
        'tel_tel2'    =>  '',
    ), $atts));
    ob_start();
?>
 <div class="item__tel">
     <div class="img__tel">
       <?php    $tel_img = wp_get_attachment_image_src( $image_hotline, 'full' ); ?>
         <img src="<?php echo $tel_img[0]; ?>" alt="icon phone">
     </div>
      <div class="content__tel">
         <span><?php echo $title_hotline; ?></span>
         <div class="tel"><a href="tel:<?php echo $tel_tel; ?>"><?php echo $tel_tel; ?></a> | 
         <a href="tel:<?php echo $tel_tel2; ?>"><?php echo $tel_tel2; ?></a> </div>   
     </div>
 </div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_action('wp_footer','devvn_readmore_taxonomy_flatsome');
function devvn_readmore_taxonomy_flatsome(){
    if(is_woocommerce() && is_tax('product_cat')):
        ?>
        <style>
           .term-description {
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
            padding-bottom: 25px;
            padding: 15px 15px 30px 15px;
            background: #f2f2f2;
            border-radius: 10px;
            margin-top: 20px;
        }
            .devvn_readmore_taxonomy_flatsome {
                text-align: center;
                cursor: pointer;
                position: absolute;
                z-index: 10;
                bottom: 0;
                width: 100%;
                background: #fff;
            }
            .devvn_readmore_taxonomy_flatsome:before {
                height: 55px;
                margin-top: -45px;
                content: "";
                background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
                background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
                background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff00', endColorstr='#ffffff',GradientType=0 );
                display: block;
            }
            .devvn_readmore_taxonomy_flatsome a {
               font-weight: bold;
            font-size: 13px;
            color: #cb1916;
            display: inline-block;
            border: 1px solid #cb1916;
            box-sizing: border-box;
            border-radius: 5px;
            padding: 6px 55px;
            cursor: pointer;
            transition: all .3s;
            min-width: 230px;
            }
            .devvn_readmore_taxonomy_flatsome a:after {
                content: '';
                width: 0;
                right: 0;
                border-top: 6px solid #cb1916;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                display: inline-block;
                vertical-align: middle;
                margin: -2px 0 0 5px;
            }
            .devvn_readmore_taxonomy_flatsome_less:before {
                display: none;
            }
            .devvn_readmore_taxonomy_flatsome_less a:after {
                border-top: 0;
                border-left: 6px solid transparent;
                border-right: 6px solid transparent;
                border-bottom: 6px solid #cb1916;
            }
        </style>
        <script>
            // (function($){
            //     $(document).ready(function(){
            //         // $(window).on('load', function(){
            //             if($('.term-description').length > 0){
            //                 var wrap = $('.term-description');
            //                 var current_height = wrap.height();
            //                 var your_height = 300;
            //                 if(current_height > your_height){
            //                     wrap.css('height', your_height+'px');
            //                     wrap.append(function(){
            //                         return '<div class="devvn_readmore_taxonomy_flatsome devvn_readmore_taxonomy_flatsome_show"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
            //                     });
            //                     wrap.append(function(){
            //                         return '<div class="devvn_readmore_taxonomy_flatsome devvn_readmore_taxonomy_flatsome_less" style="display: none"><a title="Thu gọn" href="javascript:void(0);">Thu gọn</a></div>';
            //                     });
            //                     $('body').on('click','.devvn_readmore_taxonomy_flatsome_show', function(){
            //                         wrap.removeAttr('style');
            //                         $('body .devvn_readmore_taxonomy_flatsome_show').hide();
            //                         $('body .devvn_readmore_taxonomy_flatsome_less').show();
            //                     });
            //                     $('body').on('click','.devvn_readmore_taxonomy_flatsome_less', function(){
            //                         wrap.css('height', your_height+'px');
            //                         $('body .devvn_readmore_taxonomy_flatsome_show').show();
            //                         $('body .devvn_readmore_taxonomy_flatsome_less').hide();
            //                     });
            //                 }
            //             }
            //         // });
            //     });
            // })(jQuery);
        </script>
    <?php
    endif;
}
add_filter( 'woocommerce_product_tabs', 'delete_tab', 98 );
    function delete_tab( $tabs ) {
    unset($tabs['reviews']);
    unset( $tabs['additional_information'] ); 
    return $tabs;
}

add_action('wp_footer','devvn_readmore_flatsome');
function devvn_readmore_flatsome(){
    ?>
    <style>
        .single-product div#tab-description {
            overflow: hidden;
            position: relative;
            padding-bottom: 25px;
        }
        .fix_height{
            max-height: 800px;
            overflow: hidden;
            position: relative;
        }
        .single-product .tab-panels div#tab-description.panel:not(.active) {
            height: 0 !important;
        }
        .devvn_readmore_flatsome {
            text-align: center;
            cursor: pointer;
            position: absolute;
            z-index: 10;
            bottom: 0;
            width: 100%;
            background: #fff;
        }
        .devvn_readmore_flatsome:before {
            height: 55px;
            margin-top: -45px;
            content: "";
            background: -moz-linear-gradient(top, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
            background: -webkit-linear-gradient(top, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
            background: linear-gradient(to bottom, rgba(255,255,255,0) 0%,rgba(255,255,255,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff00', endColorstr='#ffffff',GradientType=0 );
            display: block;
        }
        .devvn_readmore_flatsome a {
            font-weight: bold;
            font-size: 13px;
            color: red;
            display: inline-block;
            border: 1px solid red;
            box-sizing: border-box;
            border-radius: 5px;
            padding: 6px 55px;
            cursor: pointer;
            transition: all .3s;
            min-width: 230px;
        }
        .devvn_readmore_flatsome a:after {
            content: '';
            width: 0;
            right: 0;
            border-top: 6px solid red;;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            display: inline-block;
            vertical-align: middle;
            margin: -2px 0 0 5px;
        }
        .devvn_readmore_flatsome_less a:after {
            border-top: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid  red;
        }
        .devvn_readmore_flatsome_less:before {
            display: none;
        }
    </style>
    <!-- <script>
        (function($){
            $(document).ready(function(){
                $(window).on('load', function(){
                    if($('.single-product div#tab-description').length > 0){
                        let wrap = $('.single-product div#tab-description');
                        let current_height = wrap.height();
                        let your_height = 1200;
                        if(current_height > your_height){
                            wrap.addClass('fix_height');
                            wrap.append(function(){
                                return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_more"><a title="Xem thêm" href="javascript:void(0);">Xem thêm</a></div>';
                            });
                            wrap.append(function(){
                                return '<div class="devvn_readmore_flatsome devvn_readmore_flatsome_less" style="display: none;"><a title="Xem thêm" href="javascript:void(0);">Thu gọn</a></div>';
                            });
                            $('body').on('click','.devvn_readmore_flatsome_more', function(){
                                wrap.removeClass('fix_height');
                                $('body .devvn_readmore_flatsome_more').hide();
                                $('body .devvn_readmore_flatsome_less').show();
                            });
                            $('body').on('click','.devvn_readmore_flatsome_less', function(){
                                wrap.addClass('fix_height');
                                $('body .devvn_readmore_flatsome_less').hide();
                                $('body .devvn_readmore_flatsome_more').show();
                            });
                        }
                    }
                });
            });
        })(jQuery);
    </script> -->
    <?php
}



function add_sale(){
    global $product;
    $sale__sale__km = get_field('sale__sale__km','option');
    ?>
    <?php if (!empty($sale__sale__km)): ?>
          <div class="box-endow">
           	<div class="endow-title"> <i class="icon-gift"></i> Khuyến mãi tại Nhang Vạn Thành</div>
            <div class="endow-content">
            <div class="endow-global u-fs15">
                <?php 
                    foreach ($sale__sale__km as $vale) {
                        ?>
                        <div class="endow-global-item">
                            <span class="icon " style="background: url(<?php echo $vale['icon__km']['url']; ?>);"></span>
                            <div class="box-texts">
                                <p><?php echo $vale['nd_km'] ?></p>
                            </div>
                        </div>
                        <?php
                    }
                 ?>
            </div>
            </div>
            </div>  
    <?php endif ?>

    <?php
}
add_action('woocommerce_single_product_summary','add_sale',21);


add_filter( 'woocommerce_checkout_fields' , 'custom_checkout_form' );
function custom_checkout_form( $fields ) {
    unset($fields['billing']['billing_postcode']); //Ẩn postCode
    unset($fields['billing']['billing_state']); //Ẩn bang hạt
    unset($fields['billing']['billing_address_2']); //Ẩn địa chỉ 2
    unset($fields['billing']['billing_company']); //Ẩn công ty
    unset($fields['billing']['billing_country']);// Ẩn quốc gia

    return $fields;
}




function add__bre(){
    ?>
    <div class="breadcrumbs">
        <div class="container">
               <?php if ( function_exists('yoast_breadcrumb') ) {
                  yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                } ?>
        </div>
     
    </div>
    <?php

}
add_action('flatsome_after_header','add__bre');



add_filter( 'gettext', 'ds_change_readmore_text', 20, 3 );

function ds_change_readmore_text( $translated_text, $text, $domain ) {
if ( ! is_admin() && $domain === 'woocommerce' && $translated_text === 'Đọc tiếp') {
$translated_text = 'Xem chi tiết';
}
return $translated_text;
}

function my_woocommerce_catalog_orderby( $orderby ) {
  unset($orderby["rating"]);
  // unset($orderby["date"]);
  unset($orderby["popularity"]);
    return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "my_woocommerce_catalog_orderby", 20 );

function wc_customize_product_sorting($sorting_options){
    $sorting_options = array(
        'menu_order' => __( 'Mặc định', 'woocommerce' ),
        'date'       => __( 'Mới nhất', 'woocommerce' ),
        'price'      => __( 'Giá Thấp - Cao', 'woocommerce' ),
        'price-desc' => __( 'Giá Cao - Thấp', 'woocommerce' ),
    );

    return $sorting_options;
}
add_filter('woocommerce_catalog_orderby', 'wc_customize_product_sorting');


if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page('Option Product');
  
}


// Shortcode to display a single product
function devvn_ux_builder_element_product(){
    add_ux_builder_shortcode('devvn_viewnumber_product', array(
        'name'      => __('Chọn sản phẩm'),
        'category'  => __('Shop'),
        'priority'  => 1,
        'options' => array(

        

        'cat' => array(
            'type' => 'select',
            'heading' => 'Category',
            'param_name' => 'cat',
            'default' => '',
            'config' => array(
                'placeholder' => 'Select...',
                'termSelect' => array(
                    'post_type' => 'product',
                    'taxonomies' => 'product_cat'
                ),
            )
        ),

        'number'    =>  array(
                'type' => 'scrubfield',
                'heading' => 'Numbers',
                'default' => '1',
                'step' => '1',
                'unit' => '',
                'min'   =>  1,
                //'max'   => 2
            ),
      ),
    ));
}
add_action('ux_builder_setup', 'devvn_ux_builder_element_product');

 
function devvn_viewnumber_func_product($atts){
  global $post,$product;
    extract(shortcode_atts(array(
      'cat' =>'1',
      'number'    => '1',
    ), $atts));
    ob_start();
    $getcat = get_term_by( 'id', $cat , 'product_cat' );
    ?>
         <div class="list__pro__list">
            <?php
              $arg = array(
                'post_type' => 'product',
                'posts_per_page' => $number,
                'tax_query' => array(
                    array(
                  'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $cat
                    )
                ),
              );
              $news_post = new WP_Query($arg);
              while($news_post -> have_posts()) :
              $news_post -> the_post();
            $img_option = get_field('img_option');
            $mota = get_field('mota');
              ?>
               <div class="pro__item">
                    <div class="inner__po">
                        <div class="box__thumb__img">
                            <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                <?php if(has_post_thumbnail()) the_post_thumbnail("medium",array("alt" => get_the_title()));
                                else echo ""; ?>
                            </a>
                        </div>
                        <div class="box__content">
                            <a class="title__post__ar" href="<?php the_permalink();?>" title="<?php the_title();?>">
                                <?php echo the_title();?></a>
                            <?php if (!empty($mota)): ?>
                            <div class="des__pro">
                                <?php echo wpautop($mota); ?>
                                <a class="v_a" href="<?php the_permalink();?>" title="<?php the_title();?>">Xem thêm</a>
                            </div>
                            <?php endif ?>
                            <?php if (!empty($img_option)): ?>
                            <div class="accessories">
                                <div class="option__pro">
                                    Phụ kiện <br>(chọn thêm)
                                </div>
                                <div class="img__options main-slider gallerys">
                                    <?php   

                                        foreach ($img_option as $key_vl) {

                           

                                            ?>
                                    <a data-fancybox="mygallery" href="<?php echo $key_vl['url'] ?>"><img src="<?php echo $key_vl['sizes']['thumbnail'] ?>"></a>
                                    <?php

                                        }

                                     ?>
                                </div>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
              <?php
              endwhile;
            wp_reset_postdata();
    ?>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('devvn_viewnumber_product', 'devvn_viewnumber_func_product');


function add__video() {
       ob_start();
    $list_video_home = get_field('list_video_home','option');
    if (!empty($list_video_home)) {
        ?>
        <div class="list__video__home row large-columns-3 medium-columns-2 small-columns-2 slider row-slider slider-nav-simple slider-nav-push is-draggable flickity-enabled" data-flickity-options='{"imagesLoaded": true, "groupCells": "100%", "dragThreshold" : 5, "cellAlign": "left","wrapAround": true,"prevNextButtons": true,"percentPosition": true,"pageDots": false, "rightToLeft": false, "autoPlay" : false}' tabindex="0">

                <?php 
                    foreach ($list_video_home as $key_video) {
                        $url_img = wp_get_attachment_image_url($key_video['ha_video'],$size = 'full');
                        ?>
                            <div class="col post-item is-selected item__video">
                                <div class="img__video">
                                    <a href="<?php echo $key_video['url_video']; ?>" class="button open-video"><img src="<?php echo $url_img ;?>"></a>
                                </div>
                                <div class="title__video"><?php echo $key_video['title__videl']; ?></div>
                            </div>
                        <?php
                    }
                 ?>
            </div>
        <?php
    }
$out = ob_get_clean();
return $out;
}
add_shortcode('video__home', 'add__video');

/**
 * Show attribute in single product template
 */
if ( ! function_exists( 'add_attribut_woocommerce2' ) ) {
  function add_attribut_woocommerce2() {
    global $product;
    $has_row    = false;
    $alt        = 1;
    $attributes = $product->get_attributes();
    $class    = '';
    if ( count( $attributes ) % 2 == 0 && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
      $class = 'number-one';
    } elseif( count( $attributes ) % 2 == 0 && ( !wc_product_sku_enabled() || !$product->get_sku() || !$product->is_type( 'variable' ) ) ) {
      $class = 'number-two';
    } elseif ( count( $attributes ) % 2 != 0 && wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) {
      $class = 'number-two';
    } elseif ( count( $attributes ) == 0 && ( !wc_product_sku_enabled() || !$product->get_sku() || !$product->is_type( 'variable' ) ) ) {
      $class = 'number-zezo';
    } else {
      $class = 'number-one';
    }
    if ( $class != 'number-zezo' ) {
      echo "<ul class='attribute-single ". $class ."'>";
    
      $x = 1;
      foreach ( $attributes as $attribute ) :
        if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
          continue;
        } else {
          $has_row = true;
        }
        ?>
        <li>
          <span class="left">
            <?php echo wc_attribute_label( $attribute['name'] ) . ': '; ?>
          </span>
          <span class="right">
            <?php
            if ( $attribute['is_taxonomy'] ) {
              $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
              echo strip_tags( apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ) );
            } else {
              $values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
              echo strip_tags( apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ) );
            }
            ?>
          </span>
        </li>
        <?php 
        $x++;
      endforeach;
      echo "</ul>";
    }

    }
    add_action('woocommerce_single_product_summary','add_attribut_woocommerce2',20);
}

// item video
add_action('ux_builder_setup', 'item_video');
function item_video()
{
    add_ux_builder_shortcode('items_video', array(
        'name'      => __('item video'),
        'priority' => 3,
        'category' => __('Content'),
        'options' => array(

             'image_video' =>  array(
                'type'  =>  'image',
                'heading'   =>  __('Hình ảnh'),
                'default'   =>  '',
            ),
            'link_video' =>  array(
                'type'  =>  'textfield',
                'heading'   =>  __('Link video'),
                'default'   =>  '',
            ),
             
        ),
    ));

}
add_shortcode('items_video', 'items_vid');

function items_vid($atts)
{
    extract(shortcode_atts(array(
        'image_video'  => '',
        'link_video'   =>  '',
    ), $atts));
    ob_start();
?>
 <?php    $video__url = wp_get_attachment_image_src( $image_video, 'full' ); ?>
 <div class="video__button__popup">
    <a href="<?php echo $link_video; ?>" class="button open-video">
        <img src="<?php echo $video__url[0] ;?>">
    </a>
 </div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_action( 'init', 'hide_notice' );
function hide_notice() {
remove_action( 'admin_notices', 'flatsome_maintenance_admin_notice' );}
/*
 * Tùy chỉnh hiển thị thông tin chuyển khoản trong woocommerce
 * Author: levantoan.com
 */
add_filter('woocommerce_bacs_accounts', '__return_false');
 
add_action( 'woocommerce_email_before_order_table', 'devvn_email_instructions', 10, 3 );
function devvn_email_instructions( $order, $sent_to_admin, $plain_text = false ) {
 
    if ( ! $sent_to_admin && 'bacs' === $order->get_payment_method() && $order->has_status( 'on-hold' ) ) {
        devvn_bank_details( $order->get_id() );
    }
 
}
 
add_action( 'woocommerce_thankyou_bacs', 'devvn_thankyou_page' );
function devvn_thankyou_page($order_id){
    devvn_bank_details($order_id);
}
 
function devvn_bank_details( $order_id = '' ) {
    $bacs_accounts = get_option('woocommerce_bacs_accounts');
    if ( ! empty( $bacs_accounts ) ) {
        ob_start();
        echo '<table style=" border: 1px solid #ddd; border-collapse: collapse; width: 100%; ">';
        ?>
        <tr>
            <td colspan="2" style="border: 1px solid #eaeaea;padding: 6px 10px;"><strong>Thông tin chuyển khoản</strong></td>
        </tr>
        <?php
        foreach ( $bacs_accounts as $bacs_account ) {
            $bacs_account = (object) $bacs_account;
            $account_name = $bacs_account->account_name;
            $bank_name = $bacs_account->bank_name;
            $stk = $bacs_account->account_number;
            $icon = $bacs_account->iban;
            ?>
            <tr>
                <td style="width: 200px;border: 1px solid #eaeaea;padding: 6px 10px;"><?php if($icon):?><img src="<?php echo $icon;?>" alt=""/><?php endif;?></td>
                <td style="border: 1px solid #eaeaea;padding: 6px 10px;">
                    <strong>STK:</strong> <?php echo $stk;?><br>
                    <strong>Chủ tài khoản:</strong> <?php echo $account_name;?><br>
                    <strong>Chi Nhánh:</strong> <?php echo $bank_name;?><br>
                    <strong>Nội dung chuyển khoản:</strong> DH<?php echo $order_id;?>
                </td>
            </tr>
            <?php
        }
        echo '</table>';
        echo ob_get_clean();;
    }
 
}
add_filter('woocommerce_checkout_fields', 'devvn_custom_email_required', 999999);
function devvn_custom_email_required($fields){
    $fields['billing']['billing_email']['required'] = false;
    return $fields;
}
//Check click check box
add_filter('woocommerce_checkout_show_terms', '__return_false');
add_action( 'woocommerce_checkout_process', function() {
    if ( ! isset($_POST['terms']) ) {
        wc_add_notice( 'Bạn phải đồng ý với điều khoản trước khi đặt hàng.', 'error' );
    }
});


function get_cart_totals_ajax(){
    $subtotal  = WC()->cart->get_subtotal();
    $discount  = WC()->cart->get_discount_total();
    $shipping  = WC()->cart->get_shipping_total();
    $total     = WC()->cart->get_total();

    wp_send_json([
        'subtotal' => wc_price($subtotal),
        'discount' => $discount > 0 ? wc_price(-$discount) : 0,
        'shipping' => wc_price($shipping),
        'total'    => $total
    ]);
}
add_action('wp_ajax_get_cart_totals', 'get_cart_totals_ajax');
add_action('wp_ajax_nopriv_get_cart_totals', 'get_cart_totals_ajax');



//Xử lý add vào giỏ hàng
add_action('wp_ajax_custom_add_to_cart', 'custom_add_to_cart');
add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_add_to_cart');

function custom_add_to_cart()
{

    check_ajax_referer('custom_add_to_cart_nonce'); // BẮT BUỘC

    $product_id = intval($_POST['product_id']);
    $quantity   = intval($_POST['quantity']);
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;

    if ($variation_id) {
        $added = WC()->cart->add_to_cart($product_id, $quantity, $variation_id);
    } else {
        $added = WC()->cart->add_to_cart($product_id, $quantity);
    }

    if ($added) {
        // ======================
        // XỬ LÝ KHUYẾN MÃI
        // ======================
        $money_min = get_field('money_min', $product_id);
        $gift_id   = get_field('product_gift', $product_id);

        if ($money_min && $gift_id) {

            $total_price_this_product = 0;

            foreach (WC()->cart->get_cart() as $item_key => $item) {
                if ($item['product_id'] == $product_id) {
                    $total_price_this_product += floatval($item['line_total']);
                }
            }

            if ($total_price_this_product >= $money_min) {

                $gift_exists = false;

                foreach (WC()->cart->get_cart() as $item) {
                    if ($item['product_id'] == $gift_id) {
                        $gift_exists = true;
                    }
                }

                if (!$gift_exists) {
                    WC()->cart->add_to_cart(
                        $gift_id,
                        1,
                        0,
                        [],
                        [
                            'is_gift' => true,
                            'gift_note' => 'Khuyến mãi theo sản phẩm'
                        ]
                    );
                }
            } else {
                // KHÔNG đủ thì remove quà
                foreach (WC()->cart->get_cart() as $item_key => $item) {
                    if ($item['product_id'] == $gift_id) {
                        WC()->cart->remove_cart_item($item_key);
                    }
                }
            }
        }
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }

    wp_die();
}


add_action('woocommerce_before_calculate_totals', function($cart){
    if (is_admin() && !defined('DOING_AJAX')) return;

    foreach ($cart->get_cart() as $key => $item) {

        if(isset($item['is_gift'])){
            $item['data']->set_price(0);
        }
    }
});


add_filter('woocommerce_get_item_data', function($data, $item){
    if(isset($item['gift_note'])){
        $data[] = [
            'name' => 'Khuyến mãi',
            'value' => $item['gift_note']
        ];
    }
    return $data;
}, 10, 2);

add_action('woocommerce_checkout_create_order', function($order, $data){
    if(isset($_POST['shipping_speed'])){
        $order->update_meta_data('_shipping_speed', sanitize_text_field($_POST['shipping_speed']));
    }
}, 10, 2);

add_action( 'woocommerce_admin_order_data_after_shipping_address', function( $order ){
    $value = $order->get_meta('_shipping_speed');
    if($value){
        echo '<p><strong>Hình thức giao hàng:</strong> '.$value.'</p>';
    }
});

// SAVE JSON
function my_acf_json_save_point( $path ) {

    $themeDir = get_stylesheet_directory() . '/acf-field';

    if ( ! is_dir( $themeDir ) ) {
        mkdir( $themeDir, 0755, true );
    }

    return $themeDir;
}
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );
// LOAD JSON
function my_acf_json_load_point( $paths ) {

    unset( $paths[0] );

    $paths[] = get_stylesheet_directory() . '/acf-field';

    return $paths;
}
add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );

