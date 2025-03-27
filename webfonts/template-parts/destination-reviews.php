<?php
$args = array(
    'post_type' => 'reviews',
    'posts_per_page' => 10
);
$reviews = new WP_Query($args);
?>
    <style>
        .hero {
            background-image: url('images/city-top.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 354px;
        }

        .bg-image {
            background-image: url('images/lock-sun.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            /* height: 354px; */
        }

        .bg-image .swiper-slide {
            width: 100% !important;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: hwb(0deg 0% 100% / 30%);

        }

        .background-container {
            background: linear-gradient(180deg, #276C76 0%, #BAD0B4 70%, #FFFFFF 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .view-all::after {
            width: 100%;
            height: 2px;
            position: absolute;
            bottom: -5px;
            left: 0;
            background-color:
                <?= $_yellow ?>
            ;
            content: '';
        }


        .swiper-pagination .swiper-pagination-bullet {
            width: 19px;
            height: 8px;
            border-radius: 5px;
            opacity: 1;
            background-color: #FBFEF3 !important;
        }




        .swiper-pagination .swiper-pagination-bullet-active {
            width: 37px;
            background-color:
                <?= $_yellow ?>
                !important;
        }

        .swiper-button-prev,
        .swiper-button-next {
            display: flex;
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
            .bg-image {
                background: transparent !important;
                height: auto;
            }

            .swiper-pagination .swiper-pagination-bullet {
                background-color: #EAF2E8 !important;
            }

            .swiper-pagination .swiper-pagination-bullet-active {
                width: 25px;
                background-color:
                    <?= $_yellow ?>
                    !important;

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
<!-- Start What Our Clients Say About Cairo? -->
<section class="max-w-7xl px-4 sm:px-6 lg:px-0 mx-auto relative my-16">
    <h2 class="text-[#05363D] text-[26px] md:text-[36px]">What Our Clients Say About Cairo?</h2>
    <div class="bg-image p-0 md:p-10 mt-4 flex flex-col md:flex-row justify-start" style = 'background-image: url(<?php echo get_template_directory_uri(); ?>/images/lock-sun.jpg)'>
        <div class="swiper blog-swiper w-full md:w-5/12 ms-0 me-auto">
            <div class="swiper-wrapper pb-20 md:pb-0">

                <?php if ($reviews->have_posts()) :
                    while ($reviews->have_posts()) : $reviews->the_post();
                        $subtitle = get_post_meta(get_the_ID(), '_subtitle', true);
                        $rating = get_post_meta(get_the_ID(), '_rating', true);
                        $visitor_name = get_post_meta(get_the_ID(), '_visitor_name', true);
                        $visitor_address = get_post_meta(get_the_ID(), '_visitor_address', true);
                        $visitor_image = get_post_meta(get_the_ID(), '_visitor_image', true);
                        $content = get_post_field('post_content', get_the_ID());
                ?>

                <div class="swiper-slide bg-[#F4F8F3] opacity-75 shadow-lg rounded-lg p-6 border border-gray-200">
                    <!-- Star Rating -->
                    <div class="flex items-center">
                        <?php for ($i = 1; $i <= 5; $i++) {
                            $color = ($i <= $rating) ? 'text-yellow-500' : 'text-gray-300';
                            echo '<svg class="w-6 h-6 ' . $color . '" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.375 2.452a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.375-2.452a1 1 0 00-1.175 0l-3.375 2.452c-.785.57-1.84-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2.075 9.394c-.783-.57-.381-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.967z"/>
                                  </svg>';
                        } ?>
                    </div>

                    <!-- Review Content -->
                    <div class="flex items-start flex-col">
                            <h2 class="text-2xl font-bold mt-4"><?php echo esc_html($subtitle); ?></h2>
                            <?php
$travelled_in = get_post_meta(get_the_ID(), '_travelled_in', true);

$on_position = strpos($travelled_in, 'on');

if ($on_position !== false) {
    // Get the first part (everything before "on")
    $first_part = trim(substr($travelled_in, 0, $on_position));

    // Get the second part (everything including and after "on")
    $second_part = trim(substr($travelled_in, $on_position + 3)); // +3 to remove "on" from start

    echo '<span class="inline-block bg-green-100 text-green-800 text-xs md:text-sm font-medium px-3 py-1 rounded-full">';
    echo htmlspecialchars($first_part) . ' on <span class="font-semibold">' . htmlspecialchars($second_part) . '</span>';
    echo '</span>';
}
?>
                        </div>
                    <h3 class="text-lg font-semibold mt-4"><?php echo esc_html($subtitle); ?></h3>
                    <p class="text-gray-700 mt-2 text-sm md:text-base">
                        <?php echo strip_tags(apply_filters('the_content', $content), '<strong><em><ul><li><ol><br>'); ?>
                    </p>

                    <!-- User Info -->
                    <div class="flex items-center mt-4">
                        <?php if ($visitor_image): ?>
                            <img loading="lazy" src="<?= esc_url($visitor_image); ?>" alt="User profile" class="w-12 h-12 rounded-full border border-gray-200"/>
                        <?php endif; ?>
                        <div class="ml-3">
                            <p class="font-bold"><?php echo esc_html($visitor_name); ?></p>
                            <p class="text-sm text-gray-500 flex items-center gap-1">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/location.svg" alt="Location icon" />
                                <span><?php echo esc_html($visitor_address); ?></span>
                            </p>
                        </div>
                    </div>
                </div>

                <?php endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </div>
          <!-- Navigation buttons -->
          <div class="relative w-full md:w-5/12">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
    </div>
        
</section>
