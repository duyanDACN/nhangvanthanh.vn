<?php
    $url = get_stylesheet_directory_uri();
    $term = $wp_query->get_queried_object();
    $category_id = $term->term_id;
     get_header(); 
?>
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <div class="page-wrapper page-right-sidebar">
        <div class="container">
               <div class="section__width">
              
                <div class="box__left__layout">
                  <div class="boxx__header__cate">
                     <h1 class="heading-title-home">
                              <?php echo $term->name ;?>
                    </h1>
                    <div class="mota__dess">
                      <?php 
                         echo wpautop($term->description);
                       ?>
                    </div>
                  </div>
                 <div class="new-list">
                  <div class="box__colum__nth2">
                    <div class="box__nth__archive">
                      <?php
                         $arg = array(
                          'post_type' => 'post',
                          'tax_query' => array(
                              array(
                                  'taxonomy' => 'category',
                                  'field' => 'id',
                                  'terms' => $category_id
                              )
                          ),
                          'paged'=> get_query_var('paged'),
                          );
                          $news_post = new WP_Query($arg);
                          while($news_post -> have_posts()) :
                          $news_post -> the_post();
                            ?>
                              <div class="news-post-news">
                                <div class="box__news__inner">
                                   <div class="box__thumb__img">
                                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                            <?php if(has_post_thumbnail()) the_post_thumbnail("full",array("alt" => get_the_title()));
                                             else echo ""; ?>
                                         </a>
                                    </div>
                                    <div class="box__content">
                                          <h3><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php echo the_title();?></a></h3>
                                          <div class="date__da">
                                            <i class="icon-clock"></i>  <?php the_time('d-m-Y'); ?>
                                          </div>
                                          <div class="box__des">
                                            <?php the_excerpt(); ?>
                                          </div>
                                          <a href="<?php the_permalink() ?>">Xem thêm</a>
                                    </div>
                                </div>
                              </div>
                           <?php
                          endwhile; 
                          wp_reset_postdata();

                         flatsome_posts_pagination();
                          ?>
                    </div>
                      
                  </div>
              
            </div>
              </div> <!-- .large-9 -->

              <div class="post-sidebar box__right__layout">
                <?php get_sidebar(); ?>
              </div><!-- .post-sidebar -->


       </div>
        </div>

      </div>


    </main><!-- #main -->
  </div><!-- #primary -->

<?php 
get_footer();
?>


