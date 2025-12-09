<?php get_header();

$curauth = get_user_by('slug', $author_name);

$args = [
    'post_type' =>  'post',
    'posts_per_page'    => 12,
    'author__in' => $curauth->ID,
    'post_status' => 'publish',
];

$theQuery = new WP_Query( $args );
$countPost = $theQuery->found_posts;

?>

<div class="main-page page-author">
    <div class="se--block text-center">
        <div class="container">
            <div class="avt-author">
                <?php echo get_avatar( get_the_author_meta( 'ID' )); ?>
            </div>
            <div class="content-author">
                <h2><?php echo $curauth->display_name; ?></h2>
                <?php
                $authorId = get_the_author_meta('ID');
                $twitter = get_field('twitter', 'user_' . $authorId);
                $linkedin = get_field('linkedin', 'user_' . $authorId);
                ?>
                <div class="social-icon">
                    <a href="<?=esc_html($twitter)?>" target="_blank"><img src="https://cdn.diemnhangroup.com/noithatdiemnhan/2024/01/icon.png" alt=""></a>
                    <a href="<?=$linkedin?>" target="_blank"><img src="https://cdn.diemnhangroup.com/noithatdiemnhan/2024/01/LinkedIn_logo_initials.png" alt=""></a>
                </div>
                <div class="_info_tieu_su">
                    <p><?php echo $curauth->user_description; ?></p>
                </div>
            </div>
        </div>
    </div>
    <section class="se-news-review">
        <div class="container">
            <p class="title"> </p>
            <?php if ( $theQuery->have_posts() ) { ?>
                <div
                class="category-tips__list row large-columns-1 medium-columns-1 small-columns-1 row-small has-shadow row-box-shadow-1">
                <?php while ( $theQuery->have_posts() ) {
                    $theQuery->the_post(); ?>

                    <?php get_template_part( 'template-parts/posts/post','item'); ?>

                    <?php
                }  wp_reset_query(); ?>
            </div>
            <?php if( $countPost>12){?>
                <button data-paged=2 data-max-number-page=<?= $theQuery->max_num_pages; ?> data-count=<?= $countPost; ?>
                data-id="<?= $curauth->ID ?>" class="button-loadmore loadMorePostAuthor">Xem thêm</button>
            <?php } ?>
        <?php } else { ?>
            <p class="text-center">Đang cập nhật bài viết...</p>
        <?php } ?>
    </div>
</section>
</div>
<?php get_footer(); ?>