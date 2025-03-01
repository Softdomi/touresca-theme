<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


</head>
<?php 
$hero_image_id = get_post_meta(get_the_ID(), 'hero_image', true);
$hero_image_url = wp_get_attachment_url($hero_image_id);
if ($hero_image_id) : ?>
  
<?php endif; ?>



<?php
// destinations.php
$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";
?>
<?php get_template_part('template-parts/header'); ?>


    <!-- article Hero Section -->
    <?php
// Assuming you're fetching post data from the database
// $post = get_post(); /
$title = $post->post_title;
$category = get_the_category($post->ID)[0]->name ?? 'Uncategorized';
$date = get_the_date('j F Y', $post->ID);
$time = get_the_time('H:i A', $post->ID);
$hero_img = get_post_meta($post->ID, 'hero_image', true);

?>
   <style>


        .hero {
            background-image: url('images/article-top.jpg');
            background-size: cover;
            background-position: center;
            height: 354px;
        }

        .swiper-pagination .swiper-pagination-bullet {
            width: 19px;
            height: 8px;
            border-radius: 5px;
            opacity: 1;
            background-color: #FBFEF3 !important;

        }

        .related-articles-swiper .swiper-pagination .swiper-pagination-bullet {
            background-color: #C1D5D8 !important;

        }



        .swiper-pagination .swiper-pagination-bullet-active,
        .related-articles-swiper .swiper-pagination .swiper-pagination-bullet-active {
            width: 37px;
            background-color:
                <?= $_primary ?>
                !important;
        }

        .swiper-button-prev,
        .swiper-button-next {
            top: auto;
            bottom: 0px;
            width: 50px !important;
            height: 50px !important;
            border-radius: 50% !important;
            background-color: #E1F0F3;
            z-index: 11;
        }

        /* Override Swiper default styles */
        .swiper-button-prev:after,
        .swiper-button-next:after {
            font-size: 24px !important;
            font-weight: bold;
            color: #A2C0C4;
        }

        .swiper-button-prev:hover::after,
        .swiper-button-next:hover::after {
            color:
                <?= $_primary ?>
            ;
        }

        @media (max-width: 900px) {
            .swiper-pagination .swiper-pagination-bullet {
                width: 12px;
                height: 5px;
            }

            .swiper-pagination .swiper-pagination-bullet-active {
                width: 25px;
            }

            .swiper-button-prev,
            .swiper-button-next {
                width: 40px !important;
                height: 40px !important;
            }

            /* Override Swiper default styles */
            .swiper-button-prev:after,
            .swiper-button-next:after {
                font-size: 18px !important;
            }
        }
    </style>
<!-- article Hero Section -->
<section 
    class="hidden md:block hero py-28 bg-cover bg-center" 
    style="background-image: url('<?php echo esc_url($hero_image_url); ?>');">
</section>


<section class="max-w-7xl px-4 sm:px-6 lg:px-0 mx-auto relative my-12">
    <span style="background-color: <?= esc_attr($_yellow) ?>; color: <?= esc_attr($_primary) ?>;" 
          class="px-3 py-1 rounded-full text-xs  ">
        
       
          <?php 
        ob_start();
        the_category(', '); 
        $categories = ob_get_clean(); 
        echo strip_tags($categories); 
    ?>
    </span>

    <h3 style="color: <?= esc_attr($_primary) ?>;" class="text-xl md:text-4xl font-semibold my-2">
        <?= esc_html($title) ?>
    </h3>

    <p class="text-gray-600 text-sm font-weight-300">
        <span><?= esc_html($date) ?></span>
        <span><?= esc_html($time) ?></span>
    </p>

    <?php 
    $sections = get_post_meta(get_the_ID(), 'post_sections', true);
    if (!empty($sections)) :
        foreach ($sections as $section) :
    ?>
        
            <?php if (!empty($section['heading'])) : ?>
                <h3 style="color: <?= esc_attr($_primary) ?>;" class="text-xl md:text-2xl font-semibold my-4">
                    <?= esc_html($section['heading']); ?>
                </h3>
            <?php endif ?>
       
<p>
<?php
  $content = get_the_content(); 
    $content = apply_filters('the_content', $content);
    
    if (!empty($content)) : ?>
        <div class="text-gray-600 text-sm md:text-base leading-7 mb-6 mt-2">
            <?= $content; ?>
        </div>
    <?php endif; ?>
</p>

            <?php if (!empty($section['image'])) : ?>
                <img loading="lazy" src="<?= esc_url(wp_get_attachment_url($section['image'])); ?>" alt=""
                     class="w-full h-[350px] object-cover rounded-lg mb-6">
            <?php endif ?>

            <?php if (!empty($section['description'])) : ?>
                <p class="text-gray-600 text-sm md:text-base leading-7 mb-6 mt-2">
                    <?= esc_html($section['description']); ?>
                </p>
            <?php endif ?>
      
    <?php 
        endforeach;
    endif;
    ?>
</section>




<?php
$current_post_id = get_the_ID(); 
$categories = get_the_category();

if (!empty($categories)) {
    $category_id = $categories[0]->term_id; 

    $related_posts = new WP_Query(array(
        'cat'            => $category_id, 
        'post__not_in'   => array($current_post_id),
        'posts_per_page' => 3, 
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
<?php get_template_part('template-parts/footer'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Reusable function to initialize Swiper instances
            const initializeSwiper = (selector, config = {}) => {
                const swiperElement = document.querySelector(selector);
                if (swiperElement) {
                    return new Swiper(selector, {
                        loop: true,
                        slidesPerView: 1,
                        spaceBetween: 20,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            768: { slidesPerView: 1 },
                            1024: { slidesPerView: 3.2 },
                        },
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        lazy: {
                            loadPrevNext: true,
                        },
                        grabCursor: true,
                        ...config,
                    });
                }
            };

            initializeSwiper('.related-trips-swiper');
            initializeSwiper('.related-articles-swiper');
        });
    </script>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>