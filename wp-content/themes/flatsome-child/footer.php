<?php
/**
 * The template for displaying the footer.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

global $flatsome_opt;
?>

</main>

<footer id="footer" class="footer-wrapper">

	<?php do_action('flatsome_footer'); ?>

</footer>

</div>
<script type="text/javascript">
    jQuery(document).on("click", ".btn-advise", function() {
        jQuery("body").addClass("has-popup");
        // jQuery(".wpcf7-response-output").hide();
        jQuery("#popup-tu-van").show();

    })
      jQuery(document).on("click", ".frm-action span.btn-cancel", function() {
        jQuery("body").removeClass("has-popup");
        jQuery("#popup-tu-van").hide();
    });
</script>

<script type="text/javascript" src="https://govi.vn/wp-content/themes/flatsome-child/assets/js/theia-sticky-sidebar.js"></script>
<script src='<?php echo get_home_url(); ?>/wp-content/themes/flatsome-child/assets/js/jquery.fancybox.min.js'></script>
<script type="text/javascript">
      jQuery(document).ready(function() {

        jQuery('.product-tabs_detail .woocommerce-tabs,.product-tabs_detail .right__info__product').theiaStickySidebar({
          // Settings
          additionalMarginTop: 50
        });


      });

jQuery(".product-footer").on("click",".devvn_readmore_flatsome_less a", function(){
  jQuery('.theiaStickySidebar').css({
    'position':'relative',
    'transform':'none',
  });
   jQuery('.right__info__product').addClass('andingay');
  // jQuery('.right__info__product').css({
  //   'min-height':'1px !important',
  // });

});

// jQuery(".title__cate").on("click",".orderby-wrapper a", function(){
jQuery('.orderby li').on('click', function(){
   jQuery(this).addClass('active_active').siblings().removeClass('active_active');
});
</script>
<!--  -->


<?php wp_footer(); ?>

</body>
</html>
