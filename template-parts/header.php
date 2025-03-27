<!DOCTYPE html >
<html <?php language_attributes()?> >
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <title><?php echo wp_get_document_title(); ?></title>
    <meta name="description" content="Explore Egypt's top destinations, tours, and historical landmarks. Find the best travel experiences in Cairo, Luxor, Aswan, and more.">
    <meta name="keywords" content="Egypt tourism, travel to Egypt, best tours in Egypt, Cairo tours, Luxor temples, Aswan trips, pyramids, Nile cruise">
    <meta name="author" content="Your Website Name">
    <meta name="robots" content="index, follow">

    <!-- Open Graph (Facebook & Social Media) -->
    <meta property="og:title" content="<?php echo wp_get_document_title(); ?>">
    <meta property="og:description" content="Explore Egypt's top destinations and unforgettable travel experiences.">
    <meta property="og:image" content="<?php echo esc_url(get_template_directory_uri() . '/assets/images/og-image.jpg'); ?>">
    <meta property="og:url" content="<?php echo esc_url(home_url()); ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo wp_get_document_title(); ?>">
    <meta name="twitter:description" content="Discover Egypt’s top destinations, from the Pyramids to the Red Sea.">
    <meta name="twitter:image" content="<?php echo esc_url(get_template_directory_uri() . '/assets/images/twitter-image.jpg'); ?>">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/images/favicon.ico'); ?>" type="image/x-icon">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo esc_url(home_url()); ?>">

    <!-- Pingback -->
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
</head>
<style>
        .nav-link {
            position: relative;
        }
       .nav .nav-link.active {
            background-color: #F5FEDD;
            padding: 8px 30px;
            border-radius: 20px;
            color:#074C56 !important;
        }
        .search-input::placeholder {
            color: #9ca3af;
            font-size: 14px;
        }
        /* Add mobile menu transition */
        .mobile-menu {
            transition: all 0.3s ease-in-out;
            display: none;
        }
        .mobile-menu.show {
            display: block;
        }

         a {
font-size: 18px;
font-weight: 600;
line-height: 28.8px;
text-align: left;
        }

        @media (max-width: 1200px) {
    .ss-s {
        display: none !important;
    }
}

    </style>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>




<nav class="w-full bg-white border-b navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                <?php 
$nav_logo = get_theme_mod('theme_nav_logo');
if ($nav_logo): ?>
    <a href="<?php echo home_url(); ?>">
    <div class="flex-shrink-0 flex items-center">
                    <div class="flex items-center mb-2">
                        <a href="<?php echo home_url()?>">
                        <img src="<?php echo esc_url($nav_logo); ?>" alt="Site Logo" class="nav-logo">
                        </a>
                    </div>
                </div>

    </a>
<?php else: ?>
    <a href="<?php echo home_url(); ?>">
        <h1 class="site-title"><?php bloginfo('name'); ?></h1>
    </a>
<?php endif; ?>


                 
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden md:flex items-center space-x-8 nav">
                   <?php  display_menu('navbar', 'Custom_Nav_Walker', ['menu_class' => 'nav-links flex space-x-8']); ?>
   
</div>

          


<!-- Search Bar (Desktop Only) -->
<?php
$args = array(
    'post_type'      => 'destination',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
);

$all_destinations = new WP_Query($args);
?>

<!-- Search Bar (Desktop Only) -->
<div class="ss-s hidden md:flex items-center relative">
    <div class="relative">
        <form action="<?php echo site_url('/trips'); ?>" method="GET" id="headerSearchForm">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" id="headerTripSearch" name="trip_search" style="width:100% !important;"
                placeholder="Tours, destinations..." 
                class="search-input w-80 pl-10 pr-24 py-2 rounded-full border border-gray-200 focus:outline-none focus:border-teal-600 text-sm"
            >
            <button type="submit" class="absolute right-0 top-0 h-full px-6 bg-teal-600 text-white text-sm font-medium rounded-r-full hover:bg-teal-700 transition duration-150">
                Search
            </button>
        </form>
    </div>
</div>


   
    <div id="searchResults" class="hidden absolute top-full left-0 mt-1 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50 text-sm">
        <ul id="destinationList" class="py-1">
            <?php if ($all_destinations->have_posts()) : ?>
                <?php while ($all_destinations->have_posts()) : $all_destinations->the_post(); ?>
                    <?php 
                    $destination_id = get_the_ID();
                    $destination_title = get_the_title();
                    $destination_link = get_permalink($destination_id);
                    ?>

                    <li class="destination-item px-3 py-2 hover:bg-gray-100 cursor-pointer relative group flex items-center gap-2 text-sm" data-title="<?php echo strtolower($destination_title); ?>">
                        <i class="fas fa-map-marker-alt text-teal-600 me-1"></i> <!-- Destination Icon -->
                        <a href="<?php echo esc_url($destination_link); ?>" class="font-semibold text-gray-800"><?php echo esc_html($destination_title); ?></a>

                        <?php
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
                        ?>

                        <?php if ($destination_trips->have_posts()) : ?>
                            <ul class="trip-submenu absolute left-3/4 top-0 ml-1 hidden bg-white border border-gray-200 rounded-lg shadow-md w-44 py-1 group-hover:block text-xs">
                                <?php while ($destination_trips->have_posts()) : $destination_trips->the_post(); ?>
                                    <?php $trip_id = get_the_ID(); ?> <!-- Explicitly get the correct trip ID -->
                                    <li class="trip-item px-3 py-2 hover:bg-gray-100 flex items-center gap-2">
                                        <i class="fas fa-plane text-gray-400 me-2"></i> <!-- Trip Icon -->
                                        <a href="<?php echo esc_url(get_permalink($trip_id)); ?>" class="text-gray-800 hover:text-teal-600 text-sm"><?php the_title(); ?></a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>

                        <?php wp_reset_postdata(); ?> <!-- Reset post data after trip query -->
                    </li>

                <?php endwhile; ?>
            <?php else : ?>
                <li id="noResults" class="px-3 py-2 text-gray-600 hidden">No destinations found.</li>
            <?php endif; ?>
        </ul>
    </div>

            



                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="p-2 rounded-md hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            
                </div>
              
                

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu bg-white border-t">
    <div class="px-2 pt-2 pb-3 space-y-1">
  
    <?php  display_menu('navbar', 'Custom_Nav_Walker', ['menu_class' => 'px-2 pt-2 pb-3 space-y-1 ']); ?>

    </div>
</div>
    </nav>

      
</html>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(".search-input");
    const searchResults = document.getElementById("searchResults");
    const destinationItems = document.querySelectorAll(".destination-item");
    const noResultsItem = document.querySelector(".no-results");

    function filterResults() {
        const searchText = searchInput.value.toLowerCase().trim();
        let hasResults = false;

        if (searchText.length > 0) {
            searchResults.classList.remove("hidden"); 
        } else {
            searchResults.classList.add("hidden"); 
            return;
        }

        destinationItems.forEach((destination) => {
            const destinationName = destination.getAttribute("data-title").toLowerCase();
            let destinationVisible = destinationName.includes(searchText);
            let tripsVisible = false;

            destination.querySelectorAll(".trip-item").forEach((trip) => {
                const tripName = trip.textContent.toLowerCase();
                const isTripMatch = tripName.includes(searchText);

                if (isTripMatch) {
                    trip.style.display = "block";
                    tripsVisible = true;
                } else {
                    trip.style.display = "none";
                }
            });

            if (destinationVisible || tripsVisible) {
                destination.style.display = "block";
                hasResults = true;
            } else {
                destination.style.display = "none";
            }
        });

        noResultsItem.classList.toggle("hidden", hasResults);
    }

    searchInput.addEventListener("input", filterResults);

    searchInput.addEventListener("focus", function () {
        if (searchInput.value.trim().length > 0) {
            searchResults.classList.remove("hidden");
        }
    });

    document.addEventListener("click", function (event) {
        if (!event.target.closest(".ss-s")) {
            searchResults.classList.add("hidden");
        }
    });
});


</script>
<script>
        // Improved Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            menuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('show');
            });

               // Add classes to mobile menu links
        const menuLinks = mobileMenu.querySelectorAll('a');

menuLinks.forEach(link => {
    link.classList.add('block', 'px-3', 'py-2', 'rounded-md' , 'text-gray-600', 'hover:text-gray-800', 'hover:bg-gray-50', 'font-medium');
});
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle header search form submission
        const headerSearchForm = document.getElementById('headerSearchForm');
        if (headerSearchForm) {
            headerSearchForm.addEventListener('submit', function(event) {
                event.preventDefault();
                
                const searchInput = document.getElementById('headerTripSearch');
                if (!searchInput || searchInput.value.trim() === '') {
                    return; // Don't submit if search is empty
                }
                
                // Create search URL with the search term
                const searchTerm = searchInput.value.trim();
                const actionUrl = this.getAttribute('action');
                
                // Redirect to the search page
                window.location.href = `${actionUrl}?trip_search=${encodeURIComponent(searchTerm)}`;
            });
        }
    });
</script>

