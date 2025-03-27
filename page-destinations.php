
<?php get_template_part('template-parts/header'); ?>
<?php
$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";
?>
<?php
$destination_sections = get_posts(array(
    'post_type'      => 'destinations',
    'posts_per_page' => -1, // Get all sections
    'orderby'        => 'menu_order', 
    'order'          => 'DES',
));
?>

<?php
if (!empty($destination_sections)) {
 
    if (isset($destination_sections[0])) {
        $section0 = $destination_sections[0];
        $section0_title = get_the_title($section0->ID);
    
        ?>

<!-- Hero Section -->
  <section class="background-container">
         <!-- Start Hero Section -->
         <section class="hero-section max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto pt-8">
            <div class="mb-8">
                <h1 style="font-family: 'Berkshire Swash', cursive;"
                    class="text-[32px] md:text-[64px] font-semibold mb-4 text-[<?= $_yellow ?>]">
                    <?php echo esc_html($section0_title); ?>
                </h1>
                <p class="w-full  text-white leading-8 text-[14px] md:text-[24px]">
                <?php   $content = get_post_field('post_content', $section0->ID); ?>
               <?php if (!empty(trim($content))): ?>
            
               <?php echo strip_tags(apply_filters('the_content', $content), '<strong><em><ul><li><ol><br>'); ?>
             
                <?php endif ?>
                </p>
            </div>
               </div>
        </section>

        <?php
// Fetch only top destinations
$args = array(
    'post_type'      => 'destination',
    'posts_per_page' => -1, // Fetch all top destinations
    'meta_query'     => array(
        array(
            'key'   => 'top_destination',
            'value' => '1', // Only get marked top destinations
            'compare' => '='
        )
    )
);
$top_destinations = new WP_Query($args);
?>

<!-- Start Top Destinations Section -->
<section class="top-destinations-section max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative my-16">
    <div class="hidden md:flex justify-between items-center pb-6">
        <h3 class="text-[#05363D] text-[26px] md:text-[36px] mt-8">Our Top Destinations</h3>
        <a href="<?php echo site_url('/top-destinations'); ?>" class=" text-[16px] text-[<?= $_yellow ?>] relative view-all">View All</a>
    </div>
    <div class="swiper top-destinations-swiper pb-12 md:pb-20">
        <div class="swiper-wrapper">

        <?php if ($top_destinations->have_posts()): ?>
    <?php while ($top_destinations->have_posts()): $top_destinations->the_post(); ?>
        <?php 
            $destination_id = get_the_ID();
       
            $main_image = get_the_post_thumbnail_url($destination_id, 'large'); 
            $gallery = get_post_meta($destination_id, 'destination_gallery', true) ?: [];

            // Query trips related to this destination
            $trip_args = array(
                'post_type'      => 'add_trip', 
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => array(
                    array(
                        'key'     => 'trip_destination',
                        'value'   => $destination_id, 
                        'compare' => '=' 
                    )
                ),
            );
            
            $destination_trips = new WP_Query($trip_args);
            $num_trips = $destination_trips->found_posts;
            wp_reset_postdata(); // Reset query to maintain correct $post

        ?>

                    <!-- Single Destination Slide -->
                    <div class="swiper-slide">
                    <a href="<?= get_permalink($destination_id) ?>"  >
                        <div class="rounded-[16px] overflow-hidden h-full relative">
                            <img loading="lazy" src="<?= esc_url($main_image) ?>" alt="<?= esc_html(get_the_title($destination_id)) ?>" class="w-full h-full object-cover main-image">
                            <div class="absolute inset-0 bg-gradient-to-b from-black/0 via-black/20 to-black/60"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                                <div class="flex gap-4 items-center">
                                <?php 
    global $wpdb;
    $post_title = $wpdb->get_var( $wpdb->prepare(
        "SELECT post_title FROM $wpdb->posts WHERE ID = %d", 
        $destination_id
    ));
?>
<h3 class="text-3xl font-semibold mb-2"><?= esc_html($post_title) ?></h3>
                                    <p class="text-sm bg-gray-50 text-[#0B5864] rounded-lg inline-block px-3 h-6 flex items-center">
                                        <?php echo $num_trips ?> Trips
                                    </p>
                                </div>
                                <p class="text-sm md:text-base mb-4 w-[80%]">
                                
                                    <?php echo esc_html(mb_substr(get_the_content(), 0, 80)) . '...'; ?>
                                </p>
                                <a href="<?= get_permalink($destination_id) ?>" class="text-[<?= $_yellow ?>] font-semibold hover:underline">Discover Trips →</a>
                            </div>

                            <!-- Gallery Thumbnails -->
                            <div class="absolute bottom-[45px] right-4 flex gap-8 flex-col">
                                <?php foreach (array_slice($gallery, 0, 3) as $img_id): ?>
                                    <img loading="lazy" src="<?= esc_url(wp_get_attachment_url($img_id)) ?>" alt="Gallery Image"
                                        class="img-option w-[45px] md:w-[109px] h-[45px] md:h-[109px] rounded-lg border-2 border-white">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <!-- <p class="text-center text-gray-600">No top destinations available.</p> -->
            <?php endif; ?>
            </a>
        </div>

        <!-- Navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>


        <?php
// Fetch posts from the 'explore_egypt_sides' custom post type
$explore_posts = get_posts(array(
    'post_type'      => 'explore_egypt_sides',
    'posts_per_page' => 3, // Adjust as needed
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
));

$_primary = '#05363D'; // Define your theme colors dynamically
$_primary_two = '#309CAB';
$_yellow = '#FACC15';

?>

<section class="witch-side max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative my-16">
    <h2 class="text-[#05363D] text-[26px] md:text-[36px]">
        Which side of Egypt are you most excited to explore?
    </h2>

    <?php if (!empty($explore_posts)): ?>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 mt-4">
            <?php foreach ($explore_posts as $post): ?>
                <?php
                $header = get_post_meta($post->ID, '_header', true);
                $place = get_post_meta($post->ID, '_place', true);
                $gallery_images = get_post_meta($post->ID, '_gallery_images', true);
                $gallery_json = !empty($gallery_images) ? json_encode($gallery_images) : '[]';
                ?>

                <div class="card-images rounded-[20px] overflow-hidden relative">
                    <div class="overlay"></div>
                    <img loading="lazy" alt="<?php echo esc_attr($header); ?>" 
                         class="w-full h-[150px] md:h-[300px] object-cover"
                         src="<?php echo esc_url($gallery_images[0] ?? 'images/placeholder.jpg'); ?>"
                         data-images='<?php echo esc_attr($gallery_json); ?>'>
                    <div class="absolute top-4 left-4">
                        <p class="text-white text-sm md:text-base"><?php echo esc_html($header); ?></p>
                        <p class="text-white text-sm md:text-base">(<?php echo esc_html($place); ?>)</p>
                    </div>

                    <!-- Image Counter -->
                    <div class="absolute bottom-4 right-4">
                        <div class="w-16 md:w-20 py-1 rounded-xl bg-gray-100 opacity-75 flex items-center justify-around">
                            <button class="prev hover:-translate-x-1 duration-300">
                                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/arrow-left-w.svg" alt="Arrow Left icon"
                                     class="group-hover:translate-x-1 duration-300 w-[14px] md:w-[18px]">
                            </button>
                            <span class="text-[<?php echo $_primary_two; ?>] text-xs md:text-base counter-view">1/<?php echo count($gallery_images); ?></span>
                            <button class="next hover:translate-x-1 duration-300">
                                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/arrow-right-w.svg" alt="Arrow Right icon"
                                     class="group-hover:translate-x-1 duration-300 w-[14px] md:w-[18px]">
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- black friday card  -->
            <?php  get_template_part('/template-parts/black-friday-sm-card')?>

        </div>
    <?php else: ?>
        <!-- <p class="text-center text-gray-500">No destinations found.</p> -->
    <?php endif; ?>
</section>
    <?php
}

}
?>

<?php
// Fetch Single Tours
$args = array(
    'post_type'      => 'tour_type',
    'posts_per_page' => -1, // Retrieve all
    'meta_query'     => array(
        array(
            'key'     => 'tour_types', // The meta field storing tour type
            'value'   => 'Single Tour',
            'compare' => 'LIKE'
        )
    )
);
$query = new WP_Query($args);
?>

<section class="tours-section max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative my-8 md:my-16">
    <div class="hidden md:flex justify-between items-center pb-6">
        <h3 class="text-[#05363D] text-[26px] md:text-[36px]">Single Tours</h3>
        <!-- <a href="single-tour.php" class="text-[16px] text-[#C8EC1F] relative view-all">View All</a> -->
    </div>
    <div class="swiper single-tours-swiper  md:pb-20">
        <div class="swiper-wrapper">
            <?php
            $single_tours_query = new WP_Query(array(
                'post_type'      => 'add_trip',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => array(
                    array(
                        'key'   => 'trip_tour_type',
                        'value' => 'Single Tour',
                        'compare' => '='
                    )
                )
            ));

            if ($single_tours_query->have_posts()) :
                while ($single_tours_query->have_posts()) :
                    $single_tours_query->the_post();
                    $trip_id = get_the_ID();
                    $link =  get_permalink(get_the_ID());
                    $trip_title = get_the_title();
                    $trip_status =  get_post_meta($trip_id, 'trip_status', true);
                    $trip_caption = get_post_meta($trip_id, 'trip_caption', true);
                    $trip_gallery = get_post_meta($trip_id, 'trip_gallery', true);
            $trip_gallery = is_array($trip_gallery) ? $trip_gallery : (is_string($trip_gallery) ? explode(',', $trip_gallery) : []);
            if (!empty($trip_gallery)) {
                $trip_gallery = array_map('intval', $trip_gallery); // Ensure valid attachment IDs
            }
            
            // Fetch image URLs
            $trip_gallery_urls = [];
            foreach ($trip_gallery as $image_id) {
                $image_url = wp_get_attachment_image_url($image_id, 'full');
                if ($image_url) {
                    $trip_gallery_urls[] = $image_url;
                }
            }
            
            // Encode URLs into JSON
            $gallery_json = !empty($trip_gallery_urls) ? json_encode(array_values($trip_gallery_urls)) : '[]';
            $trip_gallery = is_array($trip_gallery) ? $trip_gallery : (is_string($trip_gallery) ? explode(',', $trip_gallery) : []);
            $trip_thumbnail = !empty($trip_gallery_urls) ? reset($trip_gallery_urls) : "no-image.jpg";
                    $trip_price = get_post_meta($trip_id, 'trip_price', true);
                    $trip_rating = get_post_meta($trip_id, 'trip_rating', true);
                    $trip_duration = get_post_meta($trip_id, 'trip_duration', true);
                   
                    ?>
               <div class="swiper-slide card-images">
              

      <div class="card-container">
    <div class="bg-white rounded-[20px] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden  flex flex-col">
        <div class="relative">
            <div class="overlay"></div>
            <img loading="lazy" src="<?php echo esc_url($trip_thumbnail); ?>" data-images='<?php echo esc_attr($gallery_json); ?>' alt="<?php echo esc_attr($trip_title); ?>" class="w-full h-[250px] object-cover">
            <!-- Status Badge -->
            <div class="absolute top-4 left-4">
                <span class="bg-[#C8EC1F] text-[#095763] px-3 py-1 rounded-full text-xs font-medium">NEW</span>
            </div>
            <!-- Rating Badge -->
            <div class="absolute top-4 right-4">
                <span class="bg-white/80 backdrop-blur-[2px] px-2 py-0.5 rounded-full flex items-center gap-1">
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/star.svg" alt="Star icon" class="w-[14px] md:w-[18px]" />
                    <span class="text-xs"><?php echo esc_html($trip_rating); ?></span>
                </span>
            </div>
            <!-- Image Counter -->
            <div class="absolute bottom-4 right-4">
                <div class="w-16 md:w-20 py-1 rounded-xl bg-gray-100 opacity-75 flex items-center justify-around">
                    <button class="prev hover:-translate-x-1 duration-300">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/arrow-left-w.svg" alt="Arrow left icon" class="w-[14px] md:w-[18px]" />
                    </button>
                    <span class="text-[#095763] text-xs md:text-base counter-view">1/1</span>
                    <button class="next hover:translate-x-1 duration-300">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/arrow-right-w.svg" alt="Arrow right icon" class="w-[14px] md:w-[18px]" />
                    </button>
                </div>
            </div>
        </div>
        <div class="flex flex-col flex-grow p-6">
            <a href="<?php echo esc_url(home_url('/trip/' . get_post_field('post_name', $trip_id))); ?>" class="block">
                <h3 class="text-xl font-semibold mb-2"><?php echo esc_html($trip_title); ?></h3>
                <p class="text-gray-600 text-sm mb-6"><?php echo esc_html(mb_strimwidth($trip_caption, 0, 80, '...')); ?></p>
                <div class="flex items-center gap-2 mb-6">
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/time.svg" alt="time icon" width="20" height="20">
                    <span class="text-gray-600">Duration: <?php echo esc_html($trip_duration); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/dollar.svg" alt="dollar icon" width="20" height="20">
                        <span class="text-gray-600">Start from: <span class="font-medium"><?php echo esc_html($trip_price); ?>$</span></span>
                    </div>
                </div>
            </a>
            <div class="mt-auto">
                <a href="<?php echo esc_url(home_url('/trip/' . get_post_field('post_name', $trip_id))); ?>" class="text-[#095763] font-medium flex justify-end items-center group gap-2">
                    <span class="text-sm md:text-base">Book Now</span>
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/arrow-right.svg" alt="Arrow right icon" class="group-hover:translate-x-1 duration-300" width="30" height="30">
                </a>
            </div>
        </div>
    </div>
</div>

  
</div>

                    <?php
                endwhile;
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>


<?php

// Get all destinations
$destinations = get_posts([
    'post_type'      => 'destination',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
]);

$destination_data = [];

foreach ($destinations as $destination) {
    $destination_id = $destination->ID;
    $destination_name = get_the_title($destination_id);
    $landmarks = get_post_meta($destination_id, 'landmarks', true) ?: [];

    $destination_data[] = [
        'id' => $destination_id,
        'name' => $destination_name,
        'landmarks' => array_map(function ($landmark) {
            return [
                'caption' => esc_html($landmark['caption']),
                'image' => esc_url(wp_get_attachment_url($landmark['image'])),
            ];
        }, $landmarks)
    ];
}
?>
<section class="nmissable-landmarks max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative my-8 md:my-16">
    <h2 class="text-[#05363D] text-[26px] md:text-[36px]">Egypt’s Unmissable Landmarks</h2>

    <!-- Filter Buttons -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-8 gap-2 mt-8">
        <?php foreach ($destination_data as $index => $destination): ?>
            <button class="btn <?php echo $index === 0 ? 'btn-primary' : 'btn-secondary'; ?>" 
                    data-destination="<?php echo esc_attr($destination['id']); ?>">
                <?php echo esc_html($destination['name']); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Landmark Grid -->
    <div id="landmark-container" class="grid grid-cols-2 gap-4 md:grid-cols-4 mt-4">
        <?php if (!empty($destination_data)): ?>
            <?php foreach ($destination_data[0]['landmarks'] as $landmark): ?>
                <div class="card rounded-[20px] overflow-hidden relative">
                    <div class="overlay"></div>
                    <img loading="lazy" src="<?php echo esc_url($landmark['image']); ?>" 
                         alt="<?php echo esc_attr($landmark['caption']); ?>" 
                         class="w-full h-[150px] md:h-[300px] object-cover">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="text-white text-sm md:text-base"><?php echo esc_html($landmark['caption']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>


<?php get_template_part('/template-parts/reviews') ?>
   <!-- Start contact... Section -->
   <section class="contact-sections bg-[#276C76] py-6">

        <div class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative my-16">
            <div class="absolute top-0 right-10">
            <img loading="lazy" src="<?php   echo get_template_directory_uri()?>/images/icons/airplane.svg "
            alt="airplane icon" width="169" height="169" />
            </div>
               
           <div class="max-w-[650px]" >
            <h2 class="text-[<?= $_yellow ?>] text-[26px] md:text-[36px]">
                <?php 
                    $contact_section_title = nl2br(esc_html(get_theme_mod("contact_section_title")));
                ?>
                <?php echo $contact_section_title ?>
              </h2>
</div>
          <?php get_template_part('template-parts/get-help') ?>

        </div>
    </section>

    <?php
$args = array(
    'post_type'      => 'post', // Get blog posts
    'posts_per_page' => 3,      // Limit to the latest 3 posts
    'orderby'        => 'date', // Order by publish date
    'order'          => 'DESC'  // Show latest posts first
);

$query = new WP_Query($args);
?>
    
             <!-- Start blog Section -->
    <section class="blog-section max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative mt-16">
        <div class="flex justify-between items-center pb-6">
            <h3 class="text-[#05363D] text-[26px] md:text-[36px]">Blogs</h3>
            <a href="<?php echo site_url('/trips'); ?>/blog" class=" text-[16px] text-[#05363D] relative view-all">View All</a>
        </div>
        <div class="swiper blog-swiper">
            <div class="swiper-wrapper">
        <?php    if ($query->have_posts()):
                while ($query->have_posts()): $query->the_post();
            ?>
                <div class="swiper-slide">
                    <a href="<?php the_permalink(); ?>">
                    <div class="bg-[#F4F8F3] rounded-[20px] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden ">
                        <div class="relative">
                        
                                <?php the_post_thumbnail('', ['class' => 'w-full h-[250px] object-cover']); ?>
                        </div>
                       
                        <div class="p-6">
                          
                            <span
                                class="bg-[#DCFE83] text-[<?= $_primary ?>] px-3 py-1 rounded-full text-xs font-medium ">
                                <?php 
                                    ob_start();
                                    the_category(', '); 
                                    $categories = ob_get_clean(); 
                                    echo strip_tags($categories); 
                                ?>
                                </span>

                            <h3 class="text-xl font-semibold my-2">
                            <?php 
            $title = get_the_title();
            echo (mb_strlen($title) > 30) ? mb_substr($title, 0, 30) : $title;
        ?>
                            </h3>
                            <p class="text-gray-600 text-sm font-weight-300">
                            <span><?php the_date('F j, Y'); ?> at <?php the_time('g:i a'); ?></span>
                            </p>
                               <p class="text-gray-600 text-sm leading-7 mb-6 mt-2">
                                <?php 
                                  
                                      ob_start();
                                      the_excerpt();
                                      $content = ob_get_clean();
                                      $content = strip_tags($content);
                                      echo (mb_strlen($content) > 30) ? mb_substr($content, 0, 40) . '....' : $content;
                               
                                ?>
                                <a href="<?php the_permalink(); ?>" class="text-[<?= $_primary ?>] text-sm underline">
                                    Read more
                                </a>
                            </p>


                        </div>
        
                    </div>
                    </a>
                    
                 
                </div>
                <?php
    endwhile;
    wp_reset_postdata(); // Reset query data
else:
 
endif;
?>
            </div>
            <!-- Navigation buttons -->
             <div class="mt-12">
             <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
             </div>

        </div>
    </section>


<script>
    document.addEventListener("DOMContentLoaded", () => {
    // handle Our Top Destinations slides
    const swiperSlides = document.querySelectorAll(
        ".top-destinations-swiper .swiper-slide"
    );
    swiperSlides.forEach((slide) => {
        const thumbnails = slide.querySelectorAll(".img-option");
        const mainImage = slide.querySelector(".main-image");
        thumbnails.forEach((thumbnail) => {
            thumbnail.addEventListener("click", () => {
                mainImage.src = thumbnail.src;
                thumbnails.forEach((img) => img.classList.remove("border-2"));
                thumbnail.classList.add("border-2");
            });
        });
    });
    // Reusable function to initialize Swiper instances
    const initializeSwiper = (selector, config) => {
        return new Swiper(selector, {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
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
    };
    // Initialize Swiper instances
    initializeSwiper(".top-destinations-swiper", {
        breakpoints: {
            768: {
                slidesPerView: 1,
            },
            1024: {
                slidesPerView: 1.4,
            },
        },
    });
    initializeSwiper(".what-are-saying-swiper", {
        breakpoints: {
            768: {
                slidesPerView: 1,
            },
            1024: {
                slidesPerView: 1.6,
            },
        },
    });
    initializeSwiper(".single-tours-swiper");
    initializeSwiper(".blog-swiper");
});

</script>
<style>
        .background-container {
            background: linear-gradient(180deg, #276C76 0%, #BAD0B4 70%, #FFFFFF 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* start common styles */
        .btn {
            /* width: 177px; */
            height: 48px;
            border-radius: 24px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary,
        .btn-secondary:hover {
            background-color:
                <?= $_primary ?>
            ;
            color: white;
        }

        .btn-secondary {
            background-color: #E0EAEB;
            color:
                <?= $_primary ?>
            ;

        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: hwb(0deg 0% 100% / 30%);

        }

        .overlay:hover {
            background-color: hwb(0deg 0% 100% / 0%);
            animation: fadeIn 0.8s;
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
            .btn {
                font-size: 12px;
            }

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

        /* end common styles */
        /* start top destination styles */
        .top-destinations-section .swiper-slide {
            height: 487px;
        }

        @media (max-width: 900px) {
            .top-destinations-section .swiper-slide {
                height: 400px;
            }
        }

        /* end top destination styles */
        /* start what are saying section styles */
        .blog-section .swiper-pagination-bullet,
        .what-are-saying-section .swiper-pagination-bullet {
            background-color: #C1D5D8 !important;
        }

        .blog-section .swiper-pagination-bullet-active,
        .what-are-saying-section .swiper-pagination-bullet-active {
            background-color:
                <?= $_primary ?>
                !important;
        }

        /* end what are saying section styles */
    </style>
     <?php get_template_part('template-parts/why-us'); ?>
     <?php get_template_part('template-parts/scroll-to-top');?>
    <?php get_template_part('template-parts/footer'); ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
    // Attach event listeners to all navigation buttons
    document.querySelectorAll(".prev, .next").forEach((button) => {
        button.addEventListener("click", (event) => {
            const card = event.target.closest(".card-images");
            if (!card) return;

            const direction = button.classList.contains("next") ? 1 : -1;
            switchImage(card, direction);
        });
    });

    // Initialize the counter for all cards
    document.querySelectorAll(".card-images").forEach((card) => {
        const imageElement = card.querySelector("img.w-full");
        const counterElement = card.querySelector(".counter-view");
        const images = JSON.parse(imageElement.dataset.images || "[]");
        if (images.length) {
            imageElement.dataset.currentIndex = 0;
            counterElement.textContent = `1/${images.length}`;
        }
    });
});

function switchImage(card, direction) {
    const imageElement = card.querySelector("img.w-full");
    const counterElement = card.querySelector(".counter-view");
    const images = JSON.parse(imageElement.dataset.images || "[]");
    if (!images.length) return;

    // Calculate the new index
    const currentIndex = parseInt(imageElement.dataset.currentIndex, 10) || 0;
    const nextIndex =
        (currentIndex + direction + images.length) % images.length;

    // Update the image and counter
    imageElement.src = images[nextIndex];
    imageElement.dataset.currentIndex = nextIndex;
    counterElement.textContent = `${nextIndex + 1}/${images.length}`;
}

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".btn");
    const landmarkContainer = document.getElementById("landmark-container");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            // Remove active class from all buttons
            buttons.forEach(btn => btn.classList.replace("btn-primary", "btn-secondary"));
            this.classList.replace("btn-secondary", "btn-primary");

            const destinationId = this.getAttribute("data-destination");
            const selectedDestination = destinations.find(dest => dest.id === parseInt(destinationId));

            // Update Landmark Grid
            landmarkContainer.innerHTML = selectedDestination.landmarks.map(landmark => `
                <div class="card rounded-[20px] overflow-hidden relative">
                    <div class="overlay"></div>
                    <img loading="lazy" src="${landmark.image}" alt="${landmark.caption}" 
                         class="w-full h-[150px] md:h-[300px] object-cover">
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <p class="text-white text-sm md:text-base">${landmark.caption}</p>
                    </div>
                </div>
            `).join("");
        });
    });
});

    </script>
    <script>
    const destinations = <?php echo json_encode($destination_data); ?>;
</script>