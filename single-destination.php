
<style>


        .hero {
            /* background-image: url('images/city-top.jpg'); */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 354px;
            background-position:center;
        }

        .bg-image {
 
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
<?php get_template_part('/template-parts/header')?>
<?php
// Get the destination slug from the URL
$destination_slug = get_query_var('name');

// Query for the destination post
$args = array(
    'name'           => $destination_slug,
    'post_type'      => 'destination',
    'post_status'    => 'publish',
    'posts_per_page' => 1
);

$destination_query = new WP_Query($args);

if ($destination_query->have_posts()) :
    while ($destination_query->have_posts()) : $destination_query->the_post();
        $post_id = get_the_ID();
        
        // Retrieve meta fields
        $hero_image = get_post_meta($post_id, 'hero_image', true);
        $hero_desc = get_post_meta($post_id, 'hero_desc', true);
        $top_destinations_header = get_post_meta($post_id, 'top_destinations_header', true);
        $top_destinations_desc = get_post_meta($post_id, 'top_destinations_desc', true);
        $top_destination = get_post_meta($post_id, 'top_destination', true);
        $landmarks = get_post_meta($post_id, 'landmarks', true);
        $landmarks_header = get_post_meta($post_id, 'landmarks_header', true);
        $about_header = get_post_meta($post_id, 'about_header', true);
        $about_description = get_post_meta($post_id, 'about_description', true);
        $tourist_attractions_header = get_post_meta($post_id, 'tourist_attractions_header', true);
        $tourist_attractions = get_post_meta($post_id, 'tourist_attractions', true) ?: [];
        $gallery = get_post_meta($post_id, 'destination_gallery', true) ?: [];
        $nearby_destinations = get_post_meta($post_id, 'nearby_destinations', true) ?: [];
        $nearby_destinations_header = get_post_meta($post_id, 'nearby_destinations_header', true);
        ?>
  <!-- Hero Section -->

 <!-- article Hero Section -->
 <section class="hidden md:block hero py-28 relative">
        <div class="overlay bg-[#074C564A] flex justify-center items-center text-white text-[40px] md:text-[96px]"
            style="font-family: 'Berkshire Swash', cursive; background-image: url('<?php echo esc_url(wp_get_attachment_url($hero_image)); ?>');"><?php echo esc_html(get_the_title()); ?></div>
    </section>
<!-- destination trips  -->

<section class="background-container">

<div class="max-w-7xl px-4 sm:px-6 lg:px-0 mx-auto relative my-12">

    <h3 class="text-xl md:text-4xl font-semibold my-2 text-[<?= $_yellow ?>]"><?php echo esc_html($about_header); ?></h3>

    <p class="text-[#FDFDFD] text-sm md:text-base leading-7 mb-6 mt-4">
    <?php echo esc_html($about_description); ?> </p>


                </div>
                </section>

 <!-- Start Tourist attractions in Cairo -->
 <section class="max-w-7xl px-4 sm:px-6 lg:px-0 mx-auto relative my-16">
    <h2 class="text-[#05363D] text-[26px] md:text-[36px]"><?php echo esc_html($tourist_attractions_header); ?></h2>

    <?php $count = count($tourist_attractions); ?>

    <div class="grid <?php echo ($count < 5) ? 'grid-cols-' . $count : 'grid-cols-2 md:grid-cols-4'; ?> gap-4 mt-4">
        <?php if ($count < 5): ?>
            <!-- If fewer than 5 attractions, make all cards next to each other in a single row -->
            <?php foreach ($tourist_attractions as $attraction): ?>
                <div class="card rounded-[20px] overflow-hidden relative">
                    <div class="overlay"></div>
                    <img loading="lazy" src="<?php echo esc_url(wp_get_attachment_url($attraction['image'])); ?>"
                        alt="<?php echo esc_attr($attraction['caption']); ?>" class="w-full h-[150px] md:h-[300px] object-cover">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="text-white text-sm md:text-base"><?php echo esc_html($attraction['caption']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- If count is 5 or a multiple of 5, use the structured layout -->
            <?php foreach (array_chunk($tourist_attractions, 5) as $chunk): ?>
                <div class="col-span-4 md:col-span-1 grid grid-cols-2 md:grid-cols-1 gap-4">
                    <?php for ($i = 0; $i < 2; $i++): ?>
                        <?php if (isset($chunk[$i])): ?>
                            <div class="card rounded-[20px] overflow-hidden relative">
                                <div class="overlay"></div>
                                <img loading="lazy" src="<?php echo esc_url(wp_get_attachment_url($chunk[$i]['image'])); ?>"
                                    alt="<?php echo esc_attr($chunk[$i]['caption']); ?>" class="w-full h-[150px] md:h-[300px] object-cover">
                                <div class="absolute bottom-4 left-0 w-full text-center">
                                    <p class="text-white text-sm md:text-base"><?php echo esc_html($chunk[$i]['caption']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>

                <?php if (isset($chunk[2])): ?>
                    <div class="col-span-4 md:col-span-1 card rounded-[20px] overflow-hidden relative">
                        <div class="overlay"></div>
                        <img loading="lazy" src="<?php echo esc_url(wp_get_attachment_url($chunk[2]['image'])); ?>"
                            alt="<?php echo esc_attr($chunk[2]['caption']); ?>" class="w-full h-[100%] object-cover">
                        <div class="absolute bottom-4 left-0 w-full text-center">
                            <p class="text-white text-sm md:text-base"><?php echo esc_html($chunk[2]['caption']); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-span-4 md:col-span-2 grid grid-cols-2 md:grid-cols-1 gap-4">
                    <?php for ($i = 3; $i < 5; $i++): ?>
                        <?php if (isset($chunk[$i])): ?>
                            <div class="card rounded-[20px] overflow-hidden relative">
                                <div class="overlay"></div>
                                <img loading="lazy" src="<?php echo esc_url(wp_get_attachment_url($chunk[$i]['image'])); ?>"
                                    alt="<?php echo esc_attr($chunk[$i]['caption']); ?>" class="w-full h-[150px] md:h-[300px] object-cover">
                                <div class="absolute bottom-4 left-0 w-full text-center">
                                    <p class="text-white text-sm md:text-base"><?php echo esc_html($chunk[$i]['caption']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($nearby_destinations)): ?>
    <!-- Start Nearby Destinations -->
    <section class="max-w-7xl px-4 sm:px-6 lg:px-0 mx-auto relative my-16">
        <h2 class="text-[#05363D] text-[26px] md:text-[36px]">
            <?php echo esc_html($nearby_destinations_header); ?>
        </h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 mt-4">
            <?php foreach ($nearby_destinations as $dest_id): ?>
                <?php 
                    $title = get_the_title($dest_id); 
                    $permalink = get_permalink($dest_id); // Get correct destination link
                    $thumbnail = get_the_post_thumbnail_url($dest_id, 'full') ?: 'default-image.jpg'; // Fallback image
                    $trips_count = get_post_meta($dest_id, 'trips_count', true) ?: '0'; // Assuming trips count is stored as metadata
                ?>
                <div class="card rounded-[20px] overflow-hidden relative">
                    <div class="overlay"></div>
                    <img loading="lazy" src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-[150px] md:h-[300px] object-cover">
                    <div class="absolute bottom-12 left-4 w-full">
                        <span class="bg-[#DCFE83] text-[<?= $_primary ?>] px-3 py-1 rounded-full text-xs font-medium ">
                            <?php echo esc_html($trips_count); ?> trips
                        </span>
                    </div>
                    <div class="absolute bottom-4 left-4 w-full">
                        <a href="<?php echo esc_url($permalink); ?>">  <!-- Updated to get correct permalink -->
                            <p class="text-white text-xl font-semibold flex justify-start items-center gap-2">
                                <span><?php echo esc_html($title); ?></span>
                                <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M26.2861 16H5.7147" stroke="#FFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M26.2861 16L19.013 22.7882" stroke="#FFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M26.2861 16L19.013 9.21177" stroke="#FFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </p>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>

        <?php
    endwhile;
    wp_reset_postdata();
else :
    echo '<p>Destination not found.</p>';
endif;
?>


<?php get_template_part('/template-parts/destination-reviews')?>

<?php get_template_part('/template-parts/footer')?>
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
                        // breakpoints: {
                        //     768: { slidesPerView: 1 },
                        //     1024: { slidesPerView: 1 },
                        // },
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

            initializeSwiper('.blog-swiper');
        });
    </script>
    <script defer src="js/image-switcher.js"></script>