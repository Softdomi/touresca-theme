<?php

$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";
?>
<?php
$current_post_id = get_the_ID(); 
$categories = get_the_category();

if (!empty($categories)) {
    $category_id = $categories[0]->term_id; 

    $related_posts = new WP_Query(array(
        'cat'            => $category_id, 
        'post__not_in'   => array($current_post_id),
        'posts_per_page' => -1, 
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

  
    if ($related_posts->have_posts()) : ?>
     
           <!-- Start Related Articles Section -->
    <section class="max-w-7xl px-4 sm:px-6 lg:px-0 mx-auto relative my-12">
    <h3 class="text-[<?= $_primary ?>] text-[26px] md:text-[40px] pb-4 font-semibold">Related
    Articles</h3>
        <div class="swiper related-articles-swiper pb-12 md:pb-20">

            <div class="swiper-wrapper">
            <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                <div
                    class="swiper-slide bg-[#F4F8F3] rounded-[20px] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden ">
                    <a href="<?php the_permalink(); ?>">
                    <div class="relative">
              
                            <?php the_post_thumbnail('', ['class' => 'w-full h-[250px] object-cover']); ?>
                    </div>
                    <div class="p-6">
                        <span
                            class="bg-[<?= $_yellow ?>] text-[<?= $_primary ?>] px-3 py-1 rounded-full text-xs font-medium ">
                            <?php 
        ob_start();
        the_category(', '); 
        $categories = ob_get_clean(); 
        echo strip_tags($categories); 
    ?> </span>

                        <h3 class="text-2xl font-semibold my-2">                 <?php 
            $title = get_the_title();
            echo (mb_strlen($title) > 30) ? mb_substr($title, 0, 30) : $title;
        ?>
               
                        </h3>
                        <p class="text-gray-600 text-sm font-weight-300">
                        <span><?php the_date('F j, Y'); ?> at <?php the_time('g:i a'); ?></span>
                        </p>
                        <p class="text-gray-600 text-sm leading-7 mb-6 mt-2">    <?php 
        $excerpt = get_the_excerpt();
        $excerpt = strip_tags($excerpt);
        $excerpt = get_the_excerpt();
        $trimmed_excerpt =( mb_strlen($excerpt) > 30) ? mb_substr($excerpt, 0, 40)  . '...' : $excerpt ;
        echo strip_tags($trimmed_excerpt );
    ?>
                                <a href="<?php the_permalink(); ?>" class="text-[<?= $_primary ?>] text-sm underline">
                                    Read more
                                </a>
                            </p>
                    </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
            <!-- Navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <?php endif;
    wp_reset_postdata(); // Reset the global post object
}
?>