<?php
// Variables
$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";
// Get itinerary meta data
$itinerary_header = get_post_meta(get_the_ID(), 'itinerary_header', true);
$itinerary_desc = get_post_meta(get_the_ID(), 'itinerary_desc', true);
$map_iframe = get_post_meta(get_the_ID(), 'map_iframe', true);
$days = get_post_meta(get_the_ID(), 'days', true);
$activities = get_post_meta(get_the_ID(), 'activities', true);
?>


<section class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative mb-4">
    <h3 class="text-[<?= $_primary ?>] text-[26px] md:text-[36px] font-semibold mb-6"><?php echo esc_html($itinerary_header); ?></h3>
    <p class="text-gray-500 leading-8 mt-0 mb-6 text-sm md:text-base">
    <?php echo esc_html($itinerary_desc); ?>
    </p>

    <div class="flex justify-between items-start flex-wrap">
        <!-- Map Section -->
        <div class="w-full mb-12">
            <iframe class="w-full h-[500px]"
                src="<?php  echo esc_url($map_iframe) ?>"
                allowfullscreen="" loading="lazy">
            </iframe>
        </div>

        <!-- Itinerary Timeline -->
        <div class="w-full">
        <?php if (!empty($days)) : ?>
            <?php foreach ($days as $day) : ?>
            <div class="relative mb-10">
                <div class="absolute left-0 top-0 h-full border-2 border-dashed border-gray-300"></div>
                <div class="flex items-start ml-4">
                    <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/location.svg" alt="Location icon"
                        class="absolute -left-[10px] -top-[28px] w-6 h-6" />
                    <div class="rounded-lg p-6 pt-0 w-full">
                        <!-- Day Header -->
                        <div onclick="toggleContent(this)"
                            class="header flex cursor-pointer justify-between items-center bg-[#F4F8F3] px-2 py-3 rounded-lg text-[<?= $_primary ?>] mb-2">
                            <h2 class="text-base md:text-xl font-semibold">
                            <?php echo esc_html($day['title'] ?? ''); ?>
                            </h2>
                         
                            <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/arrow-top.svg" alt="arrow-top icon" class="arrow-top w-6 h-6" />
                        </div>

                        <!-- Day Content -->
                        <div class="itinerary-content">
                        <?php if (!empty($day['image'])) : ?>
                        <img src="<?php echo esc_url(wp_get_attachment_url($day['image'])); ?>" alt="Day Image"  class="w-full h-[150px] md:h-[300px] object-cover rounded-xl">
                    <?php endif; ?>
            
               
                            <div class="space-y-4 text-gray-700 my-4">
                                <ul class="list-disc pl-5 flex flex-col gap-2">
                                    <li>
                                        <strong><?php echo esc_html($day['arrival_header'] ?? ''); ?>:</strong> 
                                        <?php echo esc_html($day['arrival_desc'] ?? ''); ?>
                                    </li>
                                    <li>
                                        <strong><?php echo esc_html($day['afternoon_header'] ?? ''); ?>:</strong> 
                                        <?php echo esc_html($day['afternoon_desc'] ?? ''); ?>
                                    </li>
                                    <li>
                                        <strong><?php echo esc_html($day['evening_header'] ?? ''); ?>:</strong> 
                                        <?php echo esc_html($day['evening_desc'] ?? ''); ?>
                                    </li>
                                    <li>
                                        <div class="flex items-center space-x-2">
                                            <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/break-fast.svg" alt="break-fast icon" />
                                            <span><strong><?php echo esc_html($day['meals_header'] ?? ''); ?>:</strong>
                                            <?php echo esc_html($day['meals_desc'] ?? ''); ?></span>
                                        </div>
                                    </li>
                                    <!-- Accommodation -->
 
                                    <li>
    <div class="flex flex-col">
        <div class="flex items-center space-x-2">
            <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/bed.svg" alt="bed icon" />
            <span><strong>Accommodation:</strong></span>
        </div>

        <!-- Fetch Accommodation Gallery -->
        <?php 
$accommodation_gallery = array_filter($day['accommodation']['gallery'] ?? [], function ($id) {
    return is_numeric($id) && $id > 0; // Ensures all IDs are valid numbers and greater than 0
});


  // Convert attachment IDs to URLs
  $gallery_urls = [];
  foreach ($accommodation_gallery as $image_id) {
      $image_url = wp_get_attachment_url($image_id);
      if ($image_url) {
          $gallery_urls[] = esc_url($image_url);
      }
  }


  // Set the first image (default to placeholder if empty)
  $first_image = !empty($gallery_urls) ? $gallery_urls[0] : get_template_directory_uri() . '/images/single-tour/room.jpg';
  
  // Encode the gallery URLs as JSON for JavaScript
  $gallery_json = json_encode($gallery_urls, JSON_UNESCAPED_SLASHES);



        ?>

        <!-- Room Card -->
        <div class="bg-[#F9FBF9] mt-2 rounded-[20px] max-w-[272px] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden">
            <div class="relative">
                <div class="overlay"></div>
                
                <!-- Default Image -->
                <img loading="lazy" 
     src="<?php echo esc_url(  $first_image ?? get_template_directory_uri().'/images/single-tour/room.jpg'); ?>" 
     alt="Accommodation Image"
     class="w-full h-[250px] object-cover accommodation-image"
     data-images='<?php echo json_encode($gallery_urls, JSON_UNESCAPED_SLASHES); ?>' />

                <!-- Card Badges -->
                <div class="absolute top-4 left-4">
                    <p class="bg-white/80 backdrop-blur-[2px] px-2 py-0.5 rounded-full flex items-center gap-1">
                        <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/star.svg" alt="Star icon"
                            class="w-[14px] md:w-[18px]" />
                        <span class="text-xs"><?php echo esc_html($day['accommodation']['rate'] ?? ''); ?></span>
                    </p>
                </div>

                <!-- Image Counter & Controls -->
                <div class="absolute bottom-4 right-4">
                    <div class="w-16 md:w-20 py-1 rounded-xl bg-gray-100 opacity-75 flex items-center justify-around">
                        <button class="prev hover:-translate-x-1 duration-300">
                            <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/arrow-left-w.svg" alt="Arrow left icon"
                                class="w-[14px] md:w-[18px]" />
                        </button>
                        <span class="text-xs md:text-base counter-view">1/<?php echo count($accommodation_gallery); ?></span>
                        <button class="next hover:translate-x-1 duration-300">
                            <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/arrow-right-w.svg" alt="Arrow right icon"
                                class="w-[14px] md:w-[18px]" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <h3 class="text-xl font-semibold mb-2"><?php echo esc_html($day['accommodation']['title'] ?? ''); ?></h3>
                <p class="text-gray-600 text-sm mb-6">
                    <?php echo esc_html($day['accommodation']['description'] ?? ''); ?>
                </p>
            </div>
        </div>
    </div>
</li>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".accommodation-image").forEach(image => {
        let images = image.getAttribute("data-images");
        
        // Check if images exist and are a valid JSON
        if (!images || images === "[]") {
            console.error("No images found for:", image);
            return;
        }
        
        try {
            images = JSON.parse(images);
        } catch (error) {
            console.error("Error parsing JSON:", error);
            return;
        }

        let currentIndex = 0;
        let totalImages = images.length;
        let counterView = image.closest(".relative").querySelector(".counter-view");

        // Check if images array has valid URLs
        console.log("Images loaded:", images);

        if (totalImages > 1) {
            let prevButton = image.closest(".relative").querySelector(".prev");
            let nextButton = image.closest(".relative").querySelector(".next");

            function updateImage() {
                if (images[currentIndex]) {
                    image.src = images[currentIndex];
                    counterView.textContent = (currentIndex + 1) + "/" + totalImages;
                    console.log("Updated Image:", images[currentIndex]);
                } else {
                    console.error("Invalid image index:", currentIndex);
                }
            }

            nextButton.addEventListener("click", function () {
                currentIndex = (currentIndex + 1) % totalImages;
                updateImage();
            });

            prevButton.addEventListener("click", function () {
                currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                updateImage();
            });
        }
    });
});

</script>

<!-- Display Activities -->

<?php if (!empty($day['activities'])) : ?>
       
    <!-- <pre><?php print_r($day['activities']); ?></pre> -->

            <?php foreach ($day['activities'] as $activity) : ?>
             
                       <!-- Activities -->
                       <li>
                                        <div class="flex items-center space-x-2">
                                            <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/activity.svg" alt="activity icon" />
                                            <span><?php echo esc_html($activity['header'] ?? '')?>:</span>
                                        </div>
                                        <div class="mt-2 flex flex-col gap-2">
                                            <!-- Activity Card 1 -->
                                            <div class="w-full bg-[#F9FBF9] rounded-lg shadow-lg overflow-hidden flex relative flex-col md:flex-row">
                                             

                                                    <?php if (!empty($activity['image'])) : ?>
                        <img src="<?php echo esc_url(wp_get_attachment_url($activity['image'])); ?>"  class="w-full md:w-1/3 h-auto object-cover">
                    <?php endif; ?>
                                                <div class="p-6 w-full md:w-2/3">
                                                    <div class="absolute top-2 right-2 bg-[<?= $_yellow ?>] text-[<?= $_primary ?>] text-sm px-3 py-1 rounded-xl">
                                                    <?php echo  esc_html($activity['status'] ?? 'no status')?>
                                                    </div>
                                                    <h2 class="text-xl font-semibold mb-2"><?php echo esc_html($activity['title'] ?? 'no title'); ?></h2>
                                                    <p class="text-gray-600 mb-4">
                                                    <?php echo esc_html($activity['description'] ?? 'no description'); ?>
                                                        </p>
                                                    <div class="flex justify-start gap-2 items-center text-[<?= $_primary ?>]">
                                                        <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/dollar.svg" alt="dollar icon" width="20" height="20">
                                                        <span>Start from:</span>
                                                        <span class="font-semibold"><?php echo esc_html($activity['price'] ?? ''); ?>$/person</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Activity Card 2 -->
                                            <div class="w-full bg-[#F9FBF9] rounded-lg shadow-lg overflow-hidden flex relative flex-col md:flex-row">
                                                <!-- Same structure as Activity Card 1 -->
                                                <!-- ... -->
                                            </div>
                                        </div>
                                    </li>
            <?php endforeach; ?>

    <?php endif; ?>
                             
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        <?php endif ?>

          
    
    </div>
</section>

<style>
    .itinerary-content {
        overflow: hidden;
        transition: max-height 0.5s ease-in-out;
        max-height: 0;
    }

    .itinerary-content.show {
        max-height: 4000px;
    }

    .arrow-top {
        transition: transform 0.3s ease;
    }

    .arrow-top.rotate {
        transform: rotate(180deg);
    }

    .overlay {
        position: absolute;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .overlay:hover {
        background-color: rgba(0, 0, 0, 0);
    }
    
</style>
<script>
function toggleContent(element) {
    const content = element.nextElementSibling;
    const icon = element.querySelector('.arrow-top');
    
    icon.classList.toggle('rotate');
    content.classList.toggle('show');
    
    // Trigger a resize event to help scroll detection
    setTimeout(() => {
        window.dispatchEvent(new Event('scroll'));
    }, 500);
}

// Initialize first item as open
document.addEventListener('DOMContentLoaded', () => {
    const firstHeader = document.querySelector('.header');
    if (firstHeader) {
        toggleContent(firstHeader);
    }
});
</script>