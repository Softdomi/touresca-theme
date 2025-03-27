<?php

$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";
?>
<?php 
$selected_trip_ids = get_post_meta(get_the_ID(), 'selected_trips', true);
if (!empty($selected_trip_ids) && is_array($selected_trip_ids)) {
    $selected_trips = new WP_Query([
        'post_type' => 'add_trip', 
        'post__in' => $selected_trip_ids,
        'posts_per_page' => -1
    ]);
} else {
    $selected_trips = null;
}
?>

            <?php
if ($selected_trips && $selected_trips->have_posts()) : ?>
<section class="bg-[#46818A] py-12">
    <div class = "max-w-7xl px-4 sm:px-6 lg:px-0 mx-auto ">

  
<div class="absolute top-0 right-10">
                <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/airplane.svg" alt="airplane icon" width="169" height="169" />
            </div>
            <div class="pb-6">
                <h3 class="font-['Berkshire_Swash'] text-[<?= $_yellow ?>] text-[26px] md:text-[40px] pb-4">Related
                    Trips</h3>
                <p class="hiddden md:block font-light text-white text-[14px] md:text-[16px]">
                    Dreaming of a getaway within Egypt ? Discover unbeatable destinations across egypt
                </p>
            </div>
<div class="swiper related-trips-swiper pb-12 md:pb-20">
<div class="swiper-wrapper">
    <?php while ($selected_trips->have_posts()) : $selected_trips->the_post(); 
        $trip_title = get_the_title();
        $trip_id = get_the_ID();
        $trip_status = get_post_meta($trip_id, 'trip_status', true);
        $trip_caption = get_post_meta($trip_id, 'trip_caption', true);
        $trip_price = get_post_meta($trip_id, 'trip_price', true);
        $trip_rating = get_post_meta($trip_id, 'trip_rating', true);
        $trip_discount = get_post_meta($trip_id, 'trip_discount', true);
        $trip_duration = get_post_meta($trip_id, 'trip_duration', true);
        $btn_txt = get_post_meta($trip_id, 'see_btn_txt', true);
        $btn_link = get_post_meta($trip_id, 'see_btn_link', true);
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
    ?>
  
    <div class="card-images swiper-slide" >
    <div class="bg-white rounded-[20px] flex flex-col h-full shadow-[0_2px_8px_rgba(0,0,0,0.08)]">
        <div class="relative">
            <div class="overlay"></div>
            <img loading="lazy" src="<?php echo esc_url($trip_thumbnail); ?>" 
                data-images='<?php echo esc_attr($gallery_json); ?>' 
                alt="<?php echo esc_attr($trip_title); ?>" 
                class="w-full h-[250px] object-cover trip-image">

            <div class="absolute top-4 left-4">
                <span class="bg-[<?= $_yellow ?>] text-[<?= $_primary ?>] px-3 py-1 rounded-full text-xs font-medium">
                    <?php echo esc_html($trip_status); ?>
                </span>
            </div>
            <div class="absolute top-4 right-4">
                <span class="bg-white/80 backdrop-blur-[2px] px-2 py-0.5 rounded-full flex items-center gap-1">
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/star.svg" alt="Star icon" class="w-[14px] md:w-[18px]">
                    <span class="text-xs"><?= esc_html($trip_rating); ?></span>
                </span>
            </div>
            <!-- Image Counter & Controls -->
            <div class="absolute bottom-4 right-4">
                <div class="w-16 md:w-20 py-1 rounded-xl bg-gray-100 opacity-75 flex items-center justify-around">
                    <button class="prev hover:-translate-x-1 duration-300">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/arrow-left-w.svg" alt="Arrow left icon" class="w-[14px] md:w-[18px]" />
                    </button>
                    <span class="text-xs md:text-base counter-view">1/<?php echo count($trip_gallery); ?></span>
                    <button class="next hover:translate-x-1 duration-300">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/arrow-right-w.svg" alt="Arrow right icon" class="w-[14px] md:w-[18px]" />
                    </button>
                </div>
            </div>
        </div>
        <div class="p-6 flex-1">
            <a href="<?php echo esc_url(home_url('/trip/' . get_post_field('post_name', $trip_id))); ?>">
            <h3 class="text-xl font-semibold mb-2"><?= esc_html($trip_title); ?></h3>
            <p class="text-gray-600 text-sm mb-6"><?= esc_html($trip_caption); ?></p>
            <div class="flex items-center gap-2 mb-6">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/time.svg" alt="time icon" width="20" height="20">
                <span class="text-gray-600">Duration: <?= esc_html($trip_duration); ?> Day</span>
            </div>
            <div class="flex items-center gap-2">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/dollar.svg" alt="dollar icon" width="20" height="20">
                <span class="text-gray-600">Start from: <span class="font-medium"><?= esc_html($trip_price); ?>$</span></span>
            </div>
        </a>
        </div>
        <div class="p-6">
            <a href="<?php echo esc_url(home_url('/trip/' . get_post_field('post_name', $trip_id))); ?>" class="text-[<?= $_primary ?>] font-medium flex justify-end items-center group gap-2">
                <span class="text-sm md:text-base">Book Now</span>
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/arrow-right.svg" alt="Arrow right icon" class="group-hover:translate-x-1 duration-300" width="30" height="30">
            </a>
        </div>
    </div>
    
    </div>

    <?php endwhile; wp_reset_postdata(); ?>
     <!-- Navigation buttons -->
  
</div>
<div class="md:hidden flex  swiper-button-prev"></div>
                <div class="md:hidden flex  swiper-button-next"></div>

                <!-- Pagination -->
                <div class="hidden md:block swiper-pagination"></div>
    </div>
    

<?php else : ?>
<!-- <p>No trips found.</p> -->
<?php endif; ?>
</section>
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