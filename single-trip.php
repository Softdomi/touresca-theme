<?php
$_main = "#E0EBDD";
$_primary_two = "#074C56";
$_yellow = "#C8EC1F";
$_primary = "#095763";
?>
<?php get_template_part('/template-parts/header') ?>
   <!-- Start Hero Section -->
   <div class="background-container">
   <?php get_template_part('/template-parts/trip-hero') ?>

    </div>

    <?php
// Retrieve meta values
$overview_header = get_post_meta($post->ID, 'overview_header', true);
$overview_desc = get_post_meta($post->ID, 'overview_desc', true);
$trip_includes = get_post_meta($post->ID, 'trip_includes', true) ?: [];
$trip_highlights = get_post_meta($post->ID, 'trip_highlights', true) ?: [];
$flight_header = get_post_meta($post->ID, 'flight_header', true);
$flight_description = get_post_meta($post->ID, 'flight_description', true);
$airfare_header = get_post_meta($post->ID, 'airfare_header', true);
$airfare_info = get_post_meta($post->ID, 'airfare_info', true) ?: [];
?>

<section class="tab-link shadow-[0_4px_8px_rgba(0,0,0,0.08)] sticky top-0 bg-white z-50">
    <div class="p-4 max-w-7xl mx-auto relative my-12 md:my-16">
        <div class="overflow-x-auto">
            <ul class="flex md:justify-start gap-8 whitespace-nowrap w-max md:w-full px-4 md:px-0">
                <li class="shrink-0"><a href="#overview" data-content="overview" class="btn btn-secondary btn-primary block text-[14px]">Overview</a></li>
                <li class="shrink-0"><a href="#itinerary" data-content="itinerary" class="btn btn-secondary block text-[14px]">Itinerary</a></li>
                <li class="shrink-0"><a href="#flights" data-content="flights" class="btn btn-secondary block text-[14px]">Flights</a></li>
                <li class="shrink-0"><a href="#prices" data-content="prices" class="btn btn-secondary block text-[14px]">Prices</a></li>
                <li class="shrink-0"><a href="#reviews" data-content="reviews" class="btn btn-secondary block text-[14px]">Reviews</a></li>
                <li class="shrink-0"><a href="#faq" data-content="faq" class="btn btn-secondary block text-[14px]">FAQ</a></li>
            </ul>
        </div>
    </div>
</section>

<div id="content" class="max-w-7xl mx-auto">
        <!-- start tab link content -->
        <div class="grid grid-cols-3 gap-8">
            <div class="col-span-3 md:col-span-2">
                <!-- overview -->
                <div class="tab-content" id="overview" data-tab="overview">
                    <section class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative mb-8 md:mb-16">
                        <h3 class="text-[<?= $_primary ?>] text-[26px] md:text-[36px] font-semibold mb-6">Overview</h3>
                        <h5 class="text-xl font-semibold mb-2">
                        <?php echo esc_html($overview_header); ?>
                        </h5>
                        <p class="text-gray-500 leading-8 mt-0 mb-6 text-sm md:text-base">
                        <?php echo esc_html($overview_desc); ?>
                        <div class="flex justify-between items-start flex-wrap">
                            <div>
                                <h3 class="text-xl text-[<?= $_primary ?>] font-semibold">Your Trip include :</h3>
                                <ul class="mt-4">
                                <?php foreach ($trip_includes as $include) : ?>
                                    <li class="flex items-center gap-2 mb-3">
                                        <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/mark.svg" alt="Mark icon" />
                                        <span><?php echo esc_html($include); ?></span>
                                    </li>
                            <?php endforeach ?>
                                </ul>
                            </div>
                            <div>
                                <h3 class="text-xl text-[<?= $_primary ?>] font-semibold">Trip Highlights :</h3>
                                <ul class="mt-4">
                                    <?php foreach ($trip_highlights as $highlight) : ?>
                                    <li class="flex items-center gap-2 mb-3">
                                        <img loading="lazy" src="<?php echo get_template_directory_uri()?>/images/icons/location.svg" alt="Location icon" />
                                        <span><?php echo esc_html($highlight); ?></span>
                                    </li>
                                   <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- itinerary -->
                <div class="tab-content" id="itinerary" data-tab="itinerary">
                    <?php get_template_part('/template-parts/itinerary') ?>
                </div>
          
                <!-- flights -->
                <div class="tab-content" id="flights" data-tab="flights">
                    <section class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative mb-4 md:mb-16">
                        <h3 class="text-[<?= $_primary ?>] text-[26px] md:text-[36px] font-semibold mb-6">Flights</h3>
                        <p class="text-gray-500 leading-8 mt-0 mb-4">
                        <?php echo esc_html($flight_description); ?>
                        </p>
                        <div class="bg-[#F9FBF9] p-6 rounded-lg mb-4">
                            <h3 class="text-xl md:text-2xl font-bold mb-4">    <?php echo esc_html($airfare_header); ?>:</h3>

                            <ul class="list-disc list-inside">
                            <?php foreach ($airfare_info as $info) : ?>
                            <li><?php echo esc_html($info); ?></li>
                        <?php endforeach; ?>
                          
                            </ul>
                        </div>
                    </section>
                </div>
                            </div>
            <div class="hidden md:block col-span-1">
                <?php get_template_part('/template-parts/inquery-form') ?>

                <!-- start More trips to discover -->
                <div class="mt-8 ">
                    <!-- <h3 class="text-[<?= $_primary ?>] text-3xl text-center">More trips to discover</h3> -->
                    <?php get_template_part('/template-parts/related-trips') ?>
                </div>
                <!-- end More trips to discover -->
            </div>

            <div class="col-span-3">
                
            <?php get_template_part('/template-parts/sale') ?>
                       <!-- prices -->
                       <div class="tab-content" id="prices" data-tab="prices">
                  <section class="max-w-7xl px-4 sm:px-6 mx-auto relative mb-16 ">
    <h3 class="text-[<?= $_primary ?>] text-[26px] md:text-[36px] font-semibold mb-6">Prices</h3>
    <div class="table-container">
        <!-- desktop table -->
        <table class="hidden md:block min-w-full text-center" style = "width:100% !important;">
            <thead>
                <tr class="bg-[#F4F8F3] text-gray-500">
                    <th class="border border-[<?= $_main ?>] px-4 py-6 font-weight-300">No</th>
                    <th class="border border-[<?= $_main ?>] px-4 py-6 font-weight-300">Standard Accommodations</th>
                    <th class="border border-[<?= $_main ?>] px-4 py-6 font-weight-300">Deluxe Accommodations</th>
                    <th class="border border-[<?= $_main ?>] px-4 py-6 font-weight-300">Ultra Deluxe Accommodations</th>
                    <th class="border border-[<?= $_main ?>] px-4 py-6 font-weight-300">Luxury Accommodations</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $trip_prices = get_post_meta(get_the_ID(), 'trip_prices', true);
    if (!empty($trip_prices)) :
        foreach ($trip_prices as $price) : ?>
            <tr class="hover:bg-[<?= $_main ?>] text-black">
                <td class="border border-[<?= $_main ?>] px-6 py-4">
                    <?= esc_html($price['num_adults']) ?> Adult(s)
                </td>
                <td class="border border-[<?= $_main ?>] px-6 py-4">
                    <span>Start from:</span> <strong>$<?= esc_html($price['standard']) ?></strong>
                </td>
                <td class="border border-[<?= $_main ?>] px-6 py-4">
                    <span>Start from:</span> <strong>$<?= esc_html($price['deluxe']) ?></strong>
                </td>
                <td class="border border-[<?= $_main ?>] px-6 py-4">
                    <span>Start from:</span> <strong>$<?= esc_html($price['ultra_deluxe']) ?></strong>
                </td>
                <td class="border border-[<?= $_main ?>] px-6 py-4">
                    <span>Start from:</span> <strong>$<?= esc_html($price['luxury']) ?></strong>
                </td>
            </tr>
        <?php endforeach;
    endif
    ?>
</tbody>

        </table>
        
        <!-- mobile tables -->
        <div class="md:hidden">
            <p class="mb-4">
                <?php
            $about_prices = get_post_meta(get_the_ID(), 'about_prices', true);
?>
<?php if (!empty($about_prices)) : ?>

        <?php foreach ($about_prices as $about) : ?>
            
            <?php echo esc_html($about['description']) ?>
           
            <?php endforeach ?>
<?php endif ?>
            </p>
            <?php if (!empty($trip_prices)) { 
                $categories = ['deluxe' => 'Deluxe Accommodations', 'ultra_deluxe' => 'Ultra Deluxe Accommodations'];
                foreach ($categories as $key => $label) { ?>
                    <table class="mb-4 min-w-full border-collapse border border-[<?= $_main ?>] text-center">
                        <h3 class="text-[<?= $_primary ?>] mb-2"><?= $label ?></h3>
                        <thead>
                            <tr class="bg-[#F4F8F3] text-gray-500">
                                <th class="border border-[<?= $_main ?>] px-4 py-6 font-weight-300">No</th>
                                <th class="border border-[<?= $_main ?>] px-4 py-6 font-weight-300">Prices</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trip_prices as $price) { ?>
                                <tr class="hover:bg-[<?= $_main ?>] text-black">
                                    <td class="border border-[<?= $_main ?>] px-6 py-4"><?= esc_html($price['num_adults']) ?> Adult(s)</td>
                                    <td class="text-[<?= $_primary ?>] border border-[<?= $_main ?>] px-6 py-4">
                                        <span>Start from:</span>
                                        <strong>$<?= esc_html($price[$key]) ?></strong>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } 
            } ?>
        </div>
    </div>
    <div>
    <?php
    // Retrieve About Prices
$about_prices = get_post_meta(get_the_ID(), 'about_prices', true);
?>
<?php if (!empty($about_prices)) : ?>


     
        <ul class="mt-2 mb-4">
        <?php foreach ($about_prices as $about) : ?>
            <li>
            <h4 class="text-lg text-gray-700 font-semibold mt-6"><?php echo esc_html($about['header']) ?>:</h4>
            <?php echo esc_html($about['description']) ?>
            </li>
            <?php endforeach ?>
        </ul>
  
<?php endif ?>
<?php
// Retrieve Privacy Policy
$privacy_policy = get_post_meta(get_the_ID(), 'privacy_policy', true);
?>
<?php if (!empty($privacy_policy)) : ?>
   
 <?php    foreach ($privacy_policy as $policy)  : ?>
      
        <ul class="mt-2 mb-4">
            <li>
            <h4 class="text-lg text-gray-700 font-semibold mt-6"><?php echo esc_html($policy['header']) ?>:</h4>
            <?php echo esc_html($policy['description']) ?>
            </li>
        </ul>
    <?php endforeach ?>
<?php endif ?>

<?php
// Retrieve Note
$note_header = get_post_meta(get_the_ID(), 'note_header', true);
$note_description = get_post_meta(get_the_ID(), 'note_description', true);
?>


    <h4 class="text-lg text-gray-700 font-semibold mt-4"><?php echo esc_html($note_header)?>:</h4>
		<p>
        <?php echo esc_html($note_description) ?> 
		</p>



    </div>
    <div class="md:hidden mb-4 md:mb-16 px-4">
     <?php get_template_part('/template-parts/inquery-form') ?>
         </div>
</section>

                </div>

                <!-- prices -->
              
           
                <!-- reviews -->
                <div class="tab-content" id="reviews" data-tab="reviews">
                    <section class="reviews-section max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative mb-8 md:mb-16">
                        <h3 class="text-[<?= $_primary ?>] text-[26px] md:text-[36px] font-semibold ">Reviews</h3>
                        <?php get_template_part('/template-parts/reviews') ?>
                    </section>
                </div>

                <!-- faq -->
                <div class="tab-content" id="faq" data-tab="faq">
                    <section class="max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative mb-8 md:mb-16">
                        <!-- <h3 class="text-[<?= $_primary ?>] text-[26px] md:text-[36px] font-semibold">FAQ</h3> -->
                        <?php get_template_part('/template-parts/faq') ?>
                    </section>
                </div>
            </div>

        </div>
        <!-- end tab link content -->
       
    </div>


    <?php get_template_part('template-parts/scroll-to-top');?>
<?php get_template_part('/template-parts/footer') ?>
   <style>
        html,
        body {
            scroll-behavior: smooth;
        }

        .background-container {
            background: linear-gradient(180deg, #276C76 0%, #BAD0B4 70%, #FFFFFF 100%);
            /* min-height: 100vh; */
            position: relative;
            overflow: hidden;
        }

        /* start common styles */
        .btn {
            width: auto;
            /* height: 48px; */
            padding-bottom: 10px;
            cursor: pointer;
            font-size: 16px;
            color:
                <?= $_primary ?>
            ;
        }

        .btn-primary,
        .btn-secondary:hover {
            border-bottom: 2px solid
                <?= $_primary ?>
            ;
        }

        .btn-secondary {}

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: hwb(0deg 0% 100% / 30%);
        }

        .overlay:not(.hover):hover {
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
        /* Custom Scrollbar Styling */
	.table-container {
		overflow-x: auto;
		scrollbar-width: thin;
		scrollbar-color: #E0EBDD #F4F8F3;
	}

	.table-container::-webkit-scrollbar {
		height: 10px;
	}

	.table-container::-webkit-scrollbar-track {
		background: #F4F8F3;
		border-radius: 5px;
	}

	.table-container::-webkit-scrollbar-thumb {
		background: #E0EBDD;
		border-radius: 5px;
		border: 2px solid #F4F8F3;
	}

	.table-container::-webkit-scrollbar-thumb:hover {
		background: #D4D9D1;
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
        /* start what are saying section styles */
        .blog-section .swiper-pagination-bullet,
        .reviews-section .swiper-pagination-bullet {
            background-color: #C1D5D8 !important;
        }

        .blog-section .swiper-pagination-bullet-active,
        .reviews-section .swiper-pagination-bullet-active {
            background-color:
                <?= $_primary ?>
                !important;
        }

        /* end what are saying section styles */
    </style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Tab link functionality
    const tabLinks = document.querySelectorAll('.tab-link a');
    const sections = document.querySelectorAll('.tab-content');
    
    // Options for the Intersection Observer with adjusted values
    const options = {
    root: null,
    threshold: [0.05, 0.1, 0.2, 0.3], // Detect earlier
    rootMargin: '-30% 0px -30% 0px'  // More generous margins
};
    let manualClick = false; // Flag to track manual clicks

    function updateActiveTab(entries) {
    if (manualClick) return; // Skip updates when manually clicking

    let maxVisibleSection = null;
    let maxVisibility = 0;

    console.log("Observer triggered!");

    entries.forEach(entry => {
        console.log(`Observed ${entry.target.id}: isIntersecting = ${entry.isIntersecting}, intersectionRatio = ${entry.intersectionRatio}`);

        if (entry.isIntersecting && entry.intersectionRatio > maxVisibility) {
            maxVisibility = entry.intersectionRatio;
            maxVisibleSection = entry.target;
        }
    });

    if (maxVisibleSection) {
        console.log(`✅ Active section detected: ${maxVisibleSection.id}`);
        const activeId = maxVisibleSection.getAttribute('id');
        if (activeId) {
            tabLinks.forEach(link => link.classList.remove('btn-primary'));
            const activeLink = document.querySelector(`.tab-link a[href="#${activeId}"]`);
            if (activeLink) {
                activeLink.classList.add('btn-primary');
            }
        }
    } else {
        console.log("❌ No section is currently active.");
    }
    console.log(document.getElementById("itinerary").getBoundingClientRect());

}



    // Create observer
    const observer = new IntersectionObserver(updateActiveTab, options);
    setTimeout(() => {
    const updatedSections = document.querySelectorAll('.tab-content');
    updatedSections.forEach(section => {
        observer.observe(section);
        console.log(`Observer reattached to: ${section.id}`);
    });
}, 1500);


setTimeout(() => {
    const itinerarySection = document.getElementById("itinerary");
    console.log(itinerarySection ? "Itinerary section found!" : "Itinerary section NOT found!");
}, 1000);
    // Add click event listeners to tab links
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            manualClick = true; // Set flag to disable observer temporarily

            tabLinks.forEach(link => link.classList.remove('btn-primary'));
            this.classList.add('btn-primary');

            const contentId = this.getAttribute('data-content');
            const targetSection = document.getElementById(contentId);
            
            if (targetSection) {
                const headerOffset = document.querySelector('.tab-link').offsetHeight + 20; // Dynamic height

                const elementPosition = targetSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({ top: offsetPosition, behavior: "smooth" });

                setTimeout(() => { manualClick = false; }, 1000); // Reactivate observer after scroll
            }
        });
    });

    // Swiper Initialization
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

    // Initialize Swiper instances
    initializeSwiper('.what-are-saying-swiper', {
        breakpoints: {
            768: { slidesPerView: 1 },
            1024: { slidesPerView: 1.6 },
        }
    });
    initializeSwiper('.single-tours-swiper');
    initializeSwiper('.blog-swiper');
});
</script>