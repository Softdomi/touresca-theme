<!-- Search Container with Background Effects -->
<div class="relative w-full max-w-6xl mx-auto px-4 py-6">
    <!-- Glassmorphism Search Bar -->
    <div class="hidden md:block bg-white/90 backdrop-blur-lg rounded-[30px] p-3 shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_40px_rgba(200,230,119,0.3)] transition-all duration-500 border border-white/20">       
         <!-- Search Form -->
        <form class="flex items-center gap-3 px-3" id="searchForm" action="<?php echo site_url('/trips'); ?>" method="GET">
            
            <!-- Destination Select -->
            <div class="relative flex-1 group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6">
                    <svg class="w-full h-full text-[#06414A] group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                 <!-- Destination Filter -->
                 <select name="trip_search" class="w-full appearance-none bg-transparent pl-12 pr-10 py-4 text-[#06414A] font-medium border-2 border-transparent focus:border-[#C8E677] rounded-2xl cursor-pointer outline-none transition-all duration-300 hover:bg-[#f8faf1]">
    <option value="">Destination</option>
    <?php
    $destination_slug = isset($_GET['trip_search']) ? sanitize_text_field($_GET['trip_search']) : '';
    $destinations = new WP_Query(array(
        'post_type'      => 'destination',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ));
    while ($destinations->have_posts()) : $destinations->the_post(); 
        $dest_slug = get_the_title(); // طالما بتستخدم trip_search خلي القيمة هي العنوان
        $selected = ($dest_slug === $destination_slug) ? 'selected' : '';
    ?>
    <option value="<?php echo esc_attr($dest_slug); ?>" <?php echo $selected; ?>>
        <?php the_title(); ?>
    </option>
    <?php endwhile; wp_reset_postdata(); ?>
</select>
                <!-- Custom Dropdown Arrow -->
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none group-hover:translate-y-[-45%] transition-transform duration-300">
                    <svg class="w-5 h-5 text-[#06414A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <!-- Date Picker -->
            <div class="relative flex-1 group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6">
                    <svg class="w-full h-full text-[#06414A] group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <?php $trip_date = isset($_GET['trip_date']) ? sanitize_text_field($_GET['trip_date']) : ''; ?>
                <input style="width:100% !important" type="date" name="trip_date" id="trip_date" value="<?php echo esc_attr($trip_date); ?>" class="custom-date w-full bg-transparent pl-12 pr-6 py-4 text-[#06414A] font-medium border-2 border-transparent focus:border-[#C8E677] rounded-2xl outline-none transition-all duration-300 hover:bg-[#f8faf1] cursor-pointer">
            </div>

            <!-- Duration Select -->
            <div class="relative flex-1 group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6">
                    <svg class="w-full h-full text-[#06414A] group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <?php $duration = isset($_GET['duration']) ? sanitize_text_field($_GET['duration']) : ''; ?>
                <select name="duration" class="w-full appearance-none bg-transparent pl-12 pr-10 py-4 text-[#06414A] font-medium border-2 border-transparent focus:border-[#C8E677] rounded-2xl cursor-pointer outline-none transition-all duration-300 hover:bg-[#f8faf1]">
                    <option value="">Duration</option>
                    <option value="less_10" <?php selected($duration, 'less_10'); ?>>Less than 10 days</option>
                    <option value="10_20" <?php selected($duration, '10_20'); ?>>10-20 days</option>
                    <option value="20_30" <?php selected($duration, '20_30'); ?>>20-30 days</option>
                    <option value="more_30" <?php selected($duration, 'more_30'); ?>>More than 30 days</option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none group-hover:translate-y-[-45%] transition-transform duration-300">
                    <svg class="w-5 h-5 text-[#06414A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <!-- Price Range Select -->
            <div class="relative flex-1 group">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6">
                    <svg class="w-full h-full text-[#06414A] group-hover:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <?php $price = isset($_GET['price']) ? sanitize_text_field($_GET['price']) : ''; ?>
                <select name="price" class="w-full appearance-none bg-transparent pl-12 pr-10 py-4 text-[#06414A] font-medium border-2 border-transparent focus:border-[#C8E677] rounded-2xl cursor-pointer outline-none transition-all duration-300 hover:bg-[#f8faf1]">
                    <option value="">Price Range</option>
                    <option value="less_100" <?php selected($price, 'less_100'); ?>>Less than $100</option>
                    <option value="100_300" <?php selected($price, '100_300'); ?>>$100 - $300</option>
                    <option value="300_500" <?php selected($price, '300_500'); ?>>$300 - $500</option>
                    <option value="more_500" <?php selected($price, 'more_500'); ?>>More than $500</option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none group-hover:translate-y-[-45%] transition-transform duration-300">
                    <svg class="w-5 h-5 text-[#06414A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <!-- Search Button -->
            <button type="submit" class="bg-gradient-to-r from-[#C8E677] to-[#9BE677] hover:from-[#d4f281] hover:to-[#a7f281] text-[#06414A] px-8 py-4 rounded-2xl font-medium transition-all duration-300 flex items-center gap-2 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-[#C8E677] focus:ring-offset-2">
                <span>Search</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Mobile Search Bar -->
    <div class="md:hidden w-full">
        <form class="w-full" id="mobileSearchForm" action="<?php echo site_url('/trips'); ?>" method="GET">
            <!-- Mobile search field only -->
            <div class="relative w-full">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5">
                    <svg class="w-full h-full text-[#06414A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" style = "width:100% !important" name="trip_search" placeholder="Search trips..." class="w-full bg-white/90 backdrop-blur-md rounded-xl py-3 px-12 font-medium text-[#06414A] shadow-lg focus:shadow-xl transition-all duration-300 border border-white/20 focus:outline-none focus:ring-2 focus:ring-[#C8E677]">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 bg-gradient-to-r from-[#C8E677] to-[#9BE677] text-[#06414A] p-2 rounded-lg transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Mobile Filters -->
    <!-- <div class="md:hidden flex justify-center gap-4 mt-6">
        <a href="#mobileFilters" class="flex-1 bg-white/80 backdrop-blur-md rounded-xl py-3 px-6 font-medium text-[#06414A] shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 border border-white/20">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                Filters
            </span>
        </a>
        <a href="#mobileSort" class="flex-1 bg-white/80 backdrop-blur-md rounded-xl py-3 px-6 font-medium text-[#06414A] shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 border border-white/20">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                </svg>
                Sort
            </span>
        </a>
    </div> -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prevent empty fields from being submitted
        function handleFormSubmit(formId) {
            const form = document.getElementById(formId);
            if (!form) return;
            
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                // Create URL Parameters object
                const params = new URLSearchParams();
                
                // Add only non-empty values
                const formData = new FormData(form);
                for (const [key, value] of formData.entries()) {
                    if (value.trim() !== '') {
                        params.append(key, value);
                    }
                }
                
                // Navigate to final URL
                const actionUrl = form.getAttribute('action');
                const queryString = params.toString();
                const redirectUrl = queryString ? `${actionUrl}?${queryString}` : actionUrl;
                
                window.location.href = redirectUrl;
            });
        }
        
        // Apply to search forms
        handleFormSubmit('searchForm');
        handleFormSubmit('mobileSearchForm');
        
        // Add dropdown effects
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.addEventListener('mouseover', function() {
                const arrow = this.nextElementSibling?.querySelector('svg');
                if (arrow) {
                    arrow.style.transform = 'translateY(-2px) rotate(180deg)';
                }
            });
            
            select.addEventListener('mouseout', function() {
                const arrow = this.nextElementSibling?.querySelector('svg');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            });
        });
    });
</script>

<style>
/* Custom date input styling */
input[type="date"]::-webkit-calendar-picker-indicator {
    background: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2306414A' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    width: 20px;
    height: 20px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

input[type="date"]::-webkit-calendar-picker-indicator:hover {
    transform: translateY(-2px);
}

/* Fix for mobile datepicker */
@media (max-width: 768px) {
    input[type="date"] {
        min-height: 48px;
    }
}

/* Smooth hover transition for selects */
select:hover + div svg {
    transform: translateY(-2px);
}

/* Custom scrollbar for dropdowns */
select::-webkit-scrollbar {
    width: 8px;
}

select::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

select::-webkit-scrollbar-thumb {
    background: #C8E677;
    border-radius: 4px;
}

select::-webkit-scrollbar-thumb:hover {
    background: #9BE677;
}
</style>