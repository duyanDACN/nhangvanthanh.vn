<?php
  $url = get_stylesheet_directory_uri();
  get_header(); 
    $select__footer = get_field('select__footer','option');
?>
  <link rel='stylesheet' href='<?php echo get_home_url(); ?>/wp-content/themes/flatsome-child/assets/css/owl.carousel.min.css'>
<link rel='stylesheet' href='<?php echo get_home_url(); ?>/wp-content/themes/flatsome-child/assets/css/owl.theme.default.css'>
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <div class="page-wrapper page-right-sidebar">
        <div class="container">
             <div class="section__width">
             
            <div class="box__left__layout">
              <div class="content__box">
                
            

			<?php if(have_posts()) : the_post();	
			  ?>
                <h1 class="heading-title-single"><?php the_title(); ?></h1>

					<?php the_content(); ?>
				<?php
						echo '<div class="blog-share text-center">';
		echo '<div class="is-divider medium"></div>';
		echo do_shortcode( '[share]' );
		echo '</div>';
				?>
              <?php endif ?>
  </div>
             <div class="related-post">
                <h3 class="heading-realate"><span>Bài viết liên quan</span></h3>
	            <div class="related___post owl-carousel owl-theme">
	              <?php
	    			  global $post;
					   $category = wp_get_object_terms( $post->ID, 'category',array('orderby' => 'parent', 'order' => 'DESC'));
	    			  $rel = new WP_Query(array(
	    			  	'category__in' => wp_get_post_categories($post->ID),
	    			  	'showposts' => 6,
	    			  	'post__not_in' => array($post->ID)
	    		  	    ));
	                	if($rel->have_posts()):
	                    while($rel->have_posts()):
	                        $rel->the_post();  
	                ?>
	                    <div class="news-post-sk-clear item">
                                <div class="inner__box">
                                   <div class="box__thumb__img">
                                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                            <?php if(has_post_thumbnail()) the_post_thumbnail("full",array("alt" => get_the_title()));
                                             else echo ""; ?>
                                         </a>
                                    </div>
                                    <div class="box__content">
                                          <h3><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo the_title();?></a></h3>
                                          <div class="box__des">
                                            <?php the_excerpt(); ?>
                                          </div>
                                          <a class="vue" href="<?php the_permalink() ?>">Xem thêm</a>
                                    </div>
                                </div>
                              </div>
	                <?php
	                    endwhile;
	                    endif;
	                ?>
	            </div>
				
        	</div><!-- End relate -->

              </div> <!-- .large-9 -->

            <div class="post-sidebar box__right__layout">
                <?php get_sidebar(); ?>
              </div><!-- .post-sidebar -->
      </div>
        </div>

      </div>


    </main><!-- #main -->
  </div><!-- #primary -->
<script src='<?php echo get_home_url(); ?>/wp-content/themes/flatsome-child/assets/js/owl.carousel.js'></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
      jQuery('.related___post').owlCarousel({
      loop: true,
      margin: 20,
      dots: false,
      nav: true,
      items: 3,
      responsive:{
        0:{
            items:2
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
    });
});
</script>
<?php 
get_footer();
?>


