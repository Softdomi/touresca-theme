<?php
$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";

$destination_id = get_the_ID();  
// $current_destination_id = get_post_meta($trip_id, 'trip_destination', true);

?>
<?php 
$args = array(
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
    // 'post__not_in'   => array($destination_id) 
);

$destination_trips = new WP_Query($args);
?>


 <?php if ($destination_trips->have_posts()) : ?>
    <div >



   
<!-- destination trips  -->
    <div class="flex justify-between items-center pb-6">
                <h3 class="text-[<?= $_yellow ?>] text-[26px] md:text-[36px]"> <?php echo esc_html(get_the_title()); ?> tours</h3>
                <!-- <a href="<?php echo site_url('/trips'); ?>" class=" text-[16px] text-[<?= $_yellow ?>] relative view-all">See All</a> -->
            </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
     

            <?php while ($destination_trips->have_posts()) : $destination_trips->the_post(); ?>
            <?php 
            $trip_title = get_the_title();
            $trip_id = get_the_ID();
            $trip_status = get_post_meta(get_the_ID(), 'trip_status', true);
            $trip_caption = get_post_meta(get_the_ID(), 'trip_caption', true);
            $trip_price = get_post_meta(get_the_ID(), 'trip_price', true);
            $trip_rating = get_post_meta(get_the_ID(), 'trip_rating', true);
            $trip_discount = get_post_meta(get_the_ID(), 'trip_discount', true);
            $trip_duration = get_post_meta(get_the_ID(), 'trip_duration', true);
            $trip_staus = get_post_meta(get_the_ID(), 'trip_gallery', true);
            $btn_txt = get_post_meta(get_the_ID(), 'see_btn_txt', true);
            $btn_link = get_post_meta(get_the_ID(), 'see_btn_link', true);
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
            
            // Debugging output
            echo "<script>console.log('Trip Gallery:', " . json_encode($trip_gallery) . ");</script>";
            echo "<script>console.log('Trip Gallery URLs:', " . json_encode($trip_gallery_urls) . ");</script>";
            $trip_gallery = array_filter(array_map('intval', $trip_gallery)); // Remove `0` and invalid IDs

// Debugging
echo "<script>console.log('Filtered Trip Gallery IDs:', " . json_encode($trip_gallery) . ");</script>";


            
?>
   

  
     <div class="card-images">
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

              
     

       
    
      
            <?php endwhile; ?>
 </div>

    <?php wp_reset_postdata(); ?>
<?php else : ?>
 
<?php endif; ?> 


</div>

<!-- <?php

echo "<p>Current Trip ID: </p>";
echo "<p>Current Tour Type: " . esc_html($current_tour_type) . "</p>";

if (!empty($current_tour_type)) {

    $related_trips = new WP_Query(array(
        'post_type'      => 'add_trip', 
        'posts_per_page' => 4,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'trip_tour_type',
                'value'   => $current_tour_type,
                'compare' => '='
            )
        ),
        'post__not_in' => array($trip_id) 
    ));

   

    if ($related_trips->have_posts()) {
        echo '<h3>Related Trips</h3>';
        echo '<ul>';
        while ($related_trips->have_posts()) {
            $related_trips->the_post();
            $related_trip_id = get_the_ID();
            $related_trip_title = get_the_title();
            $related_trip_url = get_permalink();

            echo '<li><a href="' . esc_url($related_trip_url) . '">' . esc_html($related_trip_title) . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p style="color: red;">No related trips found.</p>';
    }


    wp_reset_postdata();
} else {
    echo '<p style="color: red;">No tour type found for this trip.</p>';
}
?> -->
    <script>
 
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".card-images").forEach((card) => {
        const imageElement = card.querySelector("img.w-full");
        const counterElement = card.querySelector(".counter-view");
        const nextButton = card.querySelector(".next");
        const prevButton = card.querySelector(".prev");

        // ✅ Parse images from `data-images`
        let images;
        try {
            images = JSON.parse(imageElement.dataset.images || "[]");
        } catch (error) {
            console.error("Error parsing data-images:", error);
            images = [];
        }

        if (!images.length) {
            console.warn("No images found for this card.");
            return;
        }

        // ✅ Initialize
        let currentIndex = 0;
        function updateImage() {
            if (images[currentIndex]) {
                imageElement.src = images[currentIndex];
                counterElement.textContent = `${currentIndex + 1}/${images.length}`;
                console.log(`Updated Image: ${images[currentIndex]} (Index: ${currentIndex})`);
            } else {
                console.warn("Invalid image index:", currentIndex);
            }
        }

        // ✅ Button Click Handlers
        nextButton.addEventListener("click", () => {
            currentIndex = (currentIndex + 1) % images.length; // Loop to first image if at end
            updateImage();
        });

        prevButton.addEventListener("click", () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length; // Loop to last image if at start
            updateImage();
        });

        // ✅ Set first image on page load
        updateImage();
    });
});
</script>




  