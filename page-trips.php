<?php get_template_part('/template-parts/header'); ?>

<?php
// Get any query parameters for filtering
$destination_slug = isset($_GET['destination_filter']) ? sanitize_text_field($_GET['destination_filter']) : '';

$destination_id = '';
if (!empty($destination_slug)) {
    $destination_post = get_page_by_path($destination_slug, OBJECT, 'destination');
    if ($destination_post) {
        $destination_id = $destination_post->ID;
    }
}

// Initial query - we'll actually get trips via AJAX later, this is just for initial info
$args = array(
    'post_type'      => 'add_trip',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => array()
);

if (!empty($destination_id)) {
    $args['meta_query'][] = array(
        'key'   => 'trip_destination',
        'value' => $destination_id,
        'compare' => '='
    );
}
?>

<!-- Hero Section -->
<section class="bg-gradient-to-b from-[#105B66] to-[#BAD0B4] py-28">
<?php
$args = array(
    'post_type'      => 'Trips Content',
    'posts_per_page' => 1, // Get the latest content
    'post_status'    => 'publish',
);

$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post(); ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
            <h1 class="font-['Berkshire_Swash'] text-[#C8E677] text-[40px] mb-2 md:text-6xl md:mb-8"><?php the_title(); ?></h1>
            <p class="text-white text-[24px] max-w-4xl mb-8" style="line-height:30.4px;">
                <?php $content = get_the_content(); ?>
                <?php echo strip_tags(apply_filters('the_content', $content), '<strong><em><ul><li><ol><br>'); ?>
            </p>

            <?php get_template_part('/template-parts/custom-search-component')?>
        </div>
    <?php endwhile;
    wp_reset_postdata();
endif;
?>
</section>

<!-- Main Content -->
<section class="py-12 max-w-7xl mx-auto px-4">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Mobile Filter Toggle Button -->
        <div class="lg:hidden mb-4">
            <button id="filter-toggle" class="flex items-center justify-center bg-[#095763] text-white px-4 py-2 rounded-lg w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                </svg>
                Filters
            </button>
        </div>
        
        <div id="filter-overlay" class="filter-overlay"></div>
        
        <!-- Filters Sidebar -->
        <div id="filters-container" class="filters-container lg:relative lg:left-0 lg:w-1/4 space-y-6">
            <div class="flex justify-between lg:hidden mb-4">
                <h3 class="text-xl font-semibold">Filters</h3>
                <button id="close-filters" class="text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="trip-filter-form" class="space-y-6">
                <div class="filter-section p-4 bg-[#F4F8F3] rounded-lg">
                    <h3 class="font-semibold text-lg mb-3 text-[#095763]">Destination</h3>
                    <div class="space-y-2">
                        <?php
                        $destinations = new WP_Query(array(
                            'post_type'      => 'destination',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                        ));
                        while ($destinations->have_posts()) : $destinations->the_post(); ?>
                            <label class="flex items-center">
                                <input type="checkbox" name="destination[]" value="<?php the_ID(); ?>" class="custom-checkbox">
                                <input type="hidden" name="destination_filter" value="<?php the_ID(); ?>">
                                <span class="ml-2"><?php the_title(); ?></span>
                            </label>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
                
                <!-- Trip Style Filter -->
                <div class="filter-section p-4 bg-[#F4F8F3] rounded-lg">
                    <h3 class="font-semibold text-lg mb-3 text-[#095763]">Trip Style</h3>
                    <div class="space-y-1">
                        <?php
                        $trip_style_options = ['Adventure', 'Culture', 'Family', 'Group tours', 'Honey moon', 'Nature', 'Solo travelers'];
                        foreach ($trip_style_options as $style) {
                            echo "<label class='flex items-center space-x-2'>
                                    <input type='checkbox' name='trip_style[]' value='$style' class='rounded border-gray-300 custom-checkbox'>
                                    <span>$style</span>
                                  </label>";
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Duration Filter -->
                <div class="filter-section p-4 bg-[#F4F8F3] rounded-lg">
                    <h3 class="font-semibold text-lg mb-3 text-[#095763]">Duration</h3>
                    <div class="space-y-1">
                        <label class="flex items-center space-x-2"><input type="checkbox" name="duration[]" value="less_10" class="custom-checkbox"> <span>Less than 10 days</span></label>
                        <label class="flex items-center space-x-2"><input type="checkbox" name="duration[]" value="10_20" class="custom-checkbox"> <span>10-20 days</span></label>
                        <label class="flex items-center space-x-2"><input type="checkbox" name="duration[]" value="20_30" class="custom-checkbox"> <span>20-30 days</span></label>
                        <label class="flex items-center space-x-2"><input type="checkbox" name="duration[]" value="more_30" class="custom-checkbox"> <span>More than 30 days</span></label>
                    </div>
                </div>
                
                <!-- Price Filter  -->
                <div class="filter-section p-4 bg-[#F4F8F3] rounded-lg">
                    <h3 class="font-semibold text-lg mb-3 text-[#095763]">Price</h3>
                    <div class="space-y-1">
                        <label class="flex items-center space-x-2"><input type="checkbox" name="price[]" value="less_100" class="custom-checkbox"> <span>Less than $100</span></label>
                        <label class="flex items-center space-x-2"><input type="checkbox" name="price[]" value="100_300" class="custom-checkbox"> <span>$100 - $300</span></label>
                        <label class="flex items-center space-x-2"><input type="checkbox" name="price[]" value="300_500" class="custom-checkbox"> <span>$300 - $500</span></label>
                        <label class="flex items-center space-x-2"><input type="checkbox" name="price[]" value="more_500" class="custom-checkbox"> <span>More than $500</span></label>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Results Section -->
        <div class="lg:w-3/4">
        <div class="mb-6 flex justify-center md:justify-end">
    <label for="sort_by" class="mr-2 flex items-center text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 3a1 1 0 00-1 1v9.586l-2.293-2.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l4-4a1 1 0 10-1.414-1.414L11 13.586V4a1 1 0 00-1-1z"/>
        </svg>
        Sort By:
    </label>
    <div class="relative">
        <select name="sort_by" id="sort_by" class="border border-gray-300 p-2 rounded appearance-none bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Default</option>
            <option value="price_asc">Price: Low to High</option>
            <option value="price_desc">Price: High to Low</option>
            <option value="rating_high">Rating: High to Low</option>
            <option value="rating_low">Rating: Low to High</option>
            <option value="discount_high">Discount: High to Low</option>
            <option value="discount_low">Discount: Low to High</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>
</div>

            
            <!-- Loading indicator -->
            <div id="loading-indicator" class="py-10 text-center">
                <div class="inline-block animate-spin h-8 w-8 border-4 border-[#095763] border-t-transparent rounded-full"></div>
                <p class="mt-2 text-gray-600">Loading trips...</p>
            </div>
            
            <!-- Results container -->
            <div class="flex flex-col gap-6" id="trip-results">
                <?php
                
                ?>
            </div>

            <div id = "pagination"></div>
       
        </div>
    </div>
</section>
<style>
.pagination { display: block !important; }
.pagination-link { display: inline-flex !important; 
}
.swiper-button-next, .swiper-button-prev{
    width:32px !important ;
    height:32px !important ;
    border-radius:50% !important
}
.swiper-button-next svg, .swiper-button-prev svg{
   width:25px !important;
}
</style>
<!-- Add Swiper CSS in the head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    :root {
        --primary-color: #095763;
        --accent-color: #C8E677;
        --secondary-color: #E0EAEB;
        --text-color: #333333;
        --light-bg: #F8F9FA;
    }

    .hero-section {
        background: linear-gradient(180deg, #276C76 0%, #BAD0B4 100%);
    }

    input[type="checkbox"] {
        width: 24px !important;
        height: 24px !important;
    }
    
    .fancy-title {
        font-family: 'Berkshire Swash', cursive;
    }
    
    .highlight-text {
        color: #C8E677;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #07444d;
    }
    
    .btn-secondary {
        background-color: var(--secondary-color);
        color: var(--primary-color);
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    
    .badge-best-seller {
        background-color: var(--accent-color);
        color: var(--primary-color);
    }
    
    .trip-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .trip-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .star-rating {
        color: #FFB800;
    }
    
    .book-now-btn {
        color: var(--primary-color);
        transition: all 0.3s ease;
    }
    
    .book-now-btn:hover svg {
        transform: translateX(5px);
    }
    
    .custom-checkbox {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 20px;
        height: 22px;
        border: 2px solid #ddd;
        border-radius: 4px;
        margin: 0;
        padding: 0;
        position: relative;
        cursor: pointer;
        background-color: white;
    }

    .custom-checkbox:checked {
        background-color: #095763 !important;
        border-color: #095763 !important;
        position: relative;
    }

    .custom-checkbox:checked::after {
        content: '';
        position: absolute;
        left: 6px;
        top: 2px;
        width: 6px;
        height: 12px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    
    .filter-section {
        background-color: #F8F9FA;
        border-radius: 16px;
    }
    
    /* Swiper specific styling */
    .swiper {
        width: 100%;
        height: 100%;
    }
    
    .swiper-slide {
        width: 25% !import;
        height: 100%;
        position: relative;
    }
    
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .swiper-button-next:after, 
    .swiper-button-prev:after {
        display: none;
    }
    
    .swiper-pagination {
        bottom: 10px !important;
    }
    
    @media (max-width: 768px) {
        .filters-container {
            position: fixed;
            left: -100%;
            top: 0;
            bottom: 0;
            width: 80%;
            z-index: 50;
            transition: left 0.3s ease;
            background-color: white;
            overflow-y: auto;
            padding: 1rem;
        }
        
        .filters-container.show {
            left: 0;
        }
        
        .filter-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            display: none;
        }
        
        .filter-overlay.show {
            display: block;
        }
    }
</style>

<!-- Add scripts to the footer to ensure DOM is loaded -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    // Ajax function to load trips with filtering
    document.addEventListener("DOMContentLoaded", function() {
        // Elements
        const filterForm = document.getElementById("trip-filter-form");
        const sortSelect = document.getElementById("sort_by");
        const resultsContainer = document.getElementById("trip-results");
        const loadingIndicator = document.getElementById("loading-indicator");
        const filterToggleBtn = document.getElementById('filter-toggle');
        const closeFiltersBtn = document.getElementById('close-filters');
        const filtersContainer = document.getElementById('filters-container');
        const filterOverlay = document.getElementById('filter-overlay');
        
        // Mobile filters functionality
        if (filterToggleBtn && closeFiltersBtn && filtersContainer && filterOverlay) {
            // Open filters when the filter button is clicked
            filterToggleBtn.addEventListener('click', function() {
                filtersContainer.classList.add('show');
                filterOverlay.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });
            
            // Close filters when the close button is clicked
            closeFiltersBtn.addEventListener('click', function() {
                filtersContainer.classList.remove('show');
                filterOverlay.classList.remove('show');
                document.body.style.overflow = ''; // Enable scrolling
            });
            
            // Close filters when clicking on the overlay
            filterOverlay.addEventListener('click', function() {
                filtersContainer.classList.remove('show');
                filterOverlay.classList.remove('show');
                document.body.style.overflow = ''; // Enable scrolling
            });
        }

        // Get query parameters for initial load
        function getQueryParams() {
            const params = new URLSearchParams(window.location.search);
            let queryData = {};
            params.forEach((value, key) => {
                queryData[key] = value;
            });
            return queryData;
        }

        // دالة مساعدة لتحديث عداد الشرائح
        function updateSlideCounter(swiper, swiperEl) {
            const slideCountElement = swiperEl.querySelector('.slide-count');
            if (slideCountElement) {
                // نحسب عدد الشرائح الحقيقي (بدون الشرائح المكررة)
                let totalSlides = swiper.slides.length;
                if (swiper.params.loop) {
                    totalSlides = totalSlides - (2 * (swiper.loopedSlides || 1));
                }
                // نتأكد من أن العدد الإجمالي عدد صحيح موجب
                totalSlides = Math.max(1, totalSlides);
                
                // تحديث النص
                const currentIndex = swiper.realIndex + 1;
                slideCountElement.textContent = `${currentIndex}/${totalSlides}`;
                console.log(`Counter updated to ${currentIndex}/${totalSlides}`);
            }
        }

        // Function to initialize swipers after content is loaded
        function initializeSwipers() {
            console.log("Initializing swipers...");
            const swiperElements = document.querySelectorAll('.swiper');
            
            if (swiperElements.length > 0) {
                swiperElements.forEach((swiperEl, index) => {
                    // نقوم بتعيين ID للعنصر إذا لم يكن موجودًا
                    let tripId = swiperEl.getAttribute('data-trip-id');
                    if (!tripId) {
                        tripId = `trip-${index}`;
                        swiperEl.setAttribute('data-trip-id', tripId);
                        console.log(`Set missing trip ID to: ${tripId}`);
                    }
                    
                    // تهيئة Swiper للعنصر
                    try {
                        console.log(`Initializing swiper for trip ID: ${tripId}`);
                        
                        const swiper = new Swiper(swiperEl, {
                            slidesPerView: 1,
                            spaceBetween: 0,
                            loop: true,
                            autoHeight: true,
                            navigation: {
                                nextEl: swiperEl.querySelector('.swiper-button-next'),
                                prevEl: swiperEl.querySelector('.swiper-button-prev'),
                            },
                            on: {
                                init: function() {
                                    console.log(`Swiper initialized for trip #${tripId}`);
                                    // تحديث العداد عند التهيئة
                                    updateSlideCounter(this, swiperEl);
                                },
                                slideChange: function() {
                                    // تحديث العداد عند تغيير الشريحة
                                    updateSlideCounter(this, swiperEl);
                                }
                            }
                        });
                        
                        // بدلاً من الاعتماد على أحداث swiper للتنقل، نضيف أحداث النقر مباشرة
                        const prevButton = swiperEl.querySelector('.swiper-button-prev');
                        const nextButton = swiperEl.querySelector('.swiper-button-next');
                        
                        if (prevButton) {
                            prevButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                console.log(`Prev button clicked for ${tripId}`);
                                swiper.slidePrev();
                            });
                        }
                        
                        if (nextButton) {
                            nextButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                console.log(`Next button clicked for ${tripId}`);
                                swiper.slideNext();
                            });
                        }
                    } catch (error) {
                        console.error(`Error initializing Swiper for trip #${tripId}:`, error);
                    }
                });
            } else {
                console.log('No Swiper containers found to initialize');
            }
        }
        
        function handlePagination() {
      document.querySelectorAll(".pagination-link").forEach(link => {
          link.addEventListener("click", function (e) {
              e.preventDefault(); // Prevent full page reload

              let page = this.getAttribute("data-page");
              if (!page) {
                  return;
              }

              // Update the URL with the new page number
              const params = new URLSearchParams(window.location.search);
              params.set('paged', page);
              const newUrl = `${window.location.pathname}?${params.toString()}`;
              history.pushState({ page: page }, '', newUrl);

              console.log("Navigating to page:", page);
              fetchTrips(false, page); // Fetch data without reloading
          });
      });
  }

  // Handle browser back/forward buttons
  window.addEventListener('popstate', function (event) {
      if (event.state && event.state.page) {
          fetchTrips(false, event.state.page);
      }
  });


// Ensure pagination clicks are handled on page load
document.addEventListener("DOMContentLoaded", function () {
    handlePagination();
});


function fetchTripsWithPagination(page) {
    if (!filterForm) {
        console.error("Filter form not found");
        return;
    }

    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }

    let formData = new FormData(filterForm);
    formData.append("paged", page);  // Correct parameter

    let ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>?action=filter_trips';

    fetch(ajaxUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }

        if (resultsContainer) {
            resultsContainer.innerHTML = data;

            console.log("Updated HTML Response:", data);

            // Reinitialize Swipers to fix design issues
            setTimeout(() => {
                initializeSwipers();
            }, 200);

            // Ensure filters are displayed correctly
            fixFilterDisplay();

            // Reattach pagination event listeners
            handlePagination();
        }
    })
    .catch(error => {
        console.error('Error fetching trips:', error);
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
        resultsContainer.innerHTML = '<p class="text-center text-red-500">Error loading trips. Please try again.</p>';
    });
}

// Ensure pagination clicks are handled on page load
document.addEventListener("DOMContentLoaded", function () {
    handlePagination();
});

// Function to fix the filter display issue
function fixFilterDisplay() {
    let filterContainer = document.querySelector(".filters-container"); 
    if (filterContainer) {
        filterContainer.style.display = 'block'; // Ensure the filter appears properly
    }
}


// Function to fetch trips WITHOUT pagination when filtering
// Function to fetch trips, handling both filtering and pagination
function fetchTrips(initialLoad = false, page = 1) {
    if (!filterForm) {
        console.error("Filter form not found");
        return;
    }

    // Show loading indicator
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }

    if (resultsContainer) {
        resultsContainer.innerHTML = '';
    }

    let formData = new FormData(filterForm);
    let params = new URLSearchParams(formData);

    // Add sorting parameter
    if (sortSelect) {
        params.set("sort_by", sortSelect.value);
    }

    // If it's the first load, get query params from URL
    if (initialLoad) {
        const queryParams = getQueryParams();
        for (let key in queryParams) {
            params.set(key, queryParams[key]);
        }
    }

    // Add pagination parameter correctly
    params.set("paged", page);

    let ajaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>?action=filter_trips';

    fetch(ajaxUrl, {
        method: 'POST',
        body: params // Using URLSearchParams instead of FormData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.text();
    })
    .then(data => {
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }

        if (resultsContainer) {
            console.log("AJAX Response:", data);
            resultsContainer.innerHTML = data;

            // تأخير تهيئة Swiper للتأكد من اكتمال تحميل العناصر في DOM
            setTimeout(() => {
                initializeSwipers();
            }, 200);

            // Ensure pagination works after the AJAX update
            handlePagination();
        }
    })
    .catch(error => {
        console.error('Error fetching trips:', error);
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
        if (resultsContainer) {
            resultsContainer.innerHTML = '<p class="text-center text-red-500">Error loading trips. Please try again.</p>';
        }
    });
}



// Event Listeners
if (filterForm) {
    filterForm.addEventListener("change", function() {
        fetchTrips(false, 1); // Always reset to page 1
    });
}

if (sortSelect) {
    sortSelect.addEventListener("change", function() {
        fetchTrips(false, 1); // Reset to page 1 when sorting
    });
}
// Load trips on page load
 // Function to initialize pagination links
 function initializePagination() {
        const paginationLinks = paginationContainer.querySelectorAll('.pagination-link');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const page = this.getAttribute('data-page');
                if (page) {
                    updateUrl(page);
                    fetchTrips(page);
                }
            });
        });
    }

    // Function to update URL with the current page number
    function updateUrl(page) {
        const params = new URLSearchParams(window.location.search);
        params.set('paged', page);
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        history.pushState({ page }, '', newUrl);
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function (event) {
        if (event.state && event.state.page) {
            fetchTrips(event.state.page);
        }
    });

    // Initial fetch
    const initialPage = new URLSearchParams(window.location.search).get('paged') || 1;
    fetchTrips(initialPage);


        // تهيئة Swipers بعد تحميل الصفحة
        setTimeout(() => {
            initializeSwipers();
        }, 500);
    });

  
  

    // إصلاح مشكلة أزرار التنقل والعداد
function fixSwiperControls() {
    console.log("إصلاح مشكلة أزرار التنقل...");
    
    // الحصول على جميع أزرار التنقل
    const prevButtons = document.querySelectorAll('.swiper-button-prev');
    const nextButtons = document.querySelectorAll('.swiper-button-next');
    
    // ربط أحداث النقر بالأزرار مباشرةً
    prevButtons.forEach(btn => {
        // إزالة أي معالجات أحداث سابقة
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
        
        // إضافة معالج حدث جديد
        newBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log("تم النقر على زر السابق");
            
            // العثور على Swiper المرتبط
            const swiperContainer = this.closest('.swiper');
            const tripId = swiperContainer.getAttribute('data-trip-id');
            console.log(`زر السابق للعنصر: ${tripId}`);
            
            // التنقل للشريحة السابقة يدويًا
            const counterElement = swiperContainer.querySelector('.slide-count');
            if (counterElement) {
                const parts = counterElement.textContent.split('/');
                let currentIndex = parseInt(parts[0]);
                const totalSlides = parseInt(parts[1]);
                
                // حساب الشريحة السابقة مع دعم التكرار
                currentIndex = (currentIndex > 1) ? currentIndex - 1 : totalSlides;
                
                // تحديث العداد
                counterElement.textContent = `${currentIndex}/${totalSlides}`;
                
                // تحريك الشرائح يدويًا
                const slideWidth = swiperContainer.offsetWidth;
                const slideWrapper = swiperContainer.querySelector('.swiper-wrapper');
                if (slideWrapper) {
                    const currentPos = -1 * (currentIndex - 1) * slideWidth;
                    slideWrapper.style.transform = `translate3d(${currentPos}px, 0px, 0px)`;
                    slideWrapper.style.transition = 'transform 300ms ease';
                }
            }
        });
    });
    
    nextButtons.forEach(btn => {
        // إزالة أي معالجات أحداث سابقة
        const newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);
        
        // إضافة معالج حدث جديد
        newBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log("تم النقر على زر التالي");
            
            // العثور على Swiper المرتبط
            const swiperContainer = this.closest('.swiper');
            const tripId = swiperContainer.getAttribute('data-trip-id');
            console.log(`زر التالي للعنصر: ${tripId}`);
            
            // التنقل للشريحة التالية يدويًا
            const counterElement = swiperContainer.querySelector('.slide-count');
            if (counterElement) {
                const parts = counterElement.textContent.split('/');
                let currentIndex = parseInt(parts[0]);
                const totalSlides = parseInt(parts[1]);
                
                // حساب الشريحة التالية مع دعم التكرار
                currentIndex = (currentIndex < totalSlides) ? currentIndex + 1 : 1;
                
                // تحديث العداد
                counterElement.textContent = `${currentIndex}/${totalSlides}`;
                
                // تحريك الشرائح يدويًا
                const slideWidth = swiperContainer.offsetWidth;
                const slideWrapper = swiperContainer.querySelector('.swiper-wrapper');
                if (slideWrapper) {
                    const currentPos = -1 * (currentIndex - 1) * slideWidth;
                    slideWrapper.style.transform = `translate3d(${currentPos}px, 0px, 0px)`;
                    slideWrapper.style.transition = 'transform 300ms ease';
                }
            }
        });
    });
}

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.getElementById("filter-form");

    if (filterForm) {
        filterForm.addEventListener("submit", function (e) {
            e.preventDefault(); // Prevent page reload

            let formData = new FormData(this);
            let params = new URLSearchParams(formData); // Convert form data to query string
            let baseUrl = window.location.origin + window.location.pathname; // Get base URL
            let newUrl = baseUrl + "?" + params.toString(); // Append form data as query string

            history.pushState(null, "", newUrl); // Update browser URL without reload

            // Send AJAX request using fetch API
            fetch(ajaxurl, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params.toString() + "&action=filter_trips",
            })
                .then((response) => response.text())
                .then((data) => {
                    document.getElementById("trips-container").innerHTML = data; // Update trips dynamically
                })
                .catch((error) => console.error("Error:", error));
        });
    }

    // Handle pagination clicks dynamically
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("pagination-link")) {
            e.preventDefault();
            let pageUrl = new URL(e.target.href);
            let searchParams = pageUrl.searchParams; // Extract query parameters

            let currentParams = new URLSearchParams(window.location.search);
            currentParams.set("paged", searchParams.get("paged")); // Update pagination parameter

            let updatedUrl = window.location.pathname + "?" + currentParams.toString();
            history.pushState(null, "", updatedUrl); // Update browser URL

            // Fetch updated paginated trips
            fetch(ajaxurl, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: currentParams.toString() + "&action=filter_trips",
            })
                .then((response) => response.text())
                .then((data) => {
                    document.getElementById("trips-container").innerHTML = data; // Update trips
                })
                .catch((error) => console.error("Error:", error));
        }
    });
});

</script>





