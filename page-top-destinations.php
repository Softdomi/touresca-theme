
<?php get_template_part('/template-parts/header') ?>
<?php
// Get the global post ID
$top_destinations_header = get_post_meta(get_the_ID(), 'top_destinations_header', true);
$top_destinations_desc = get_post_meta(get_the_ID(), 'top_destinations_desc', true);
?>
<?php
// Query Top Destinations
$destination_sections = get_posts(array(
    'post_type'      => 'destinations',
    'posts_per_page' => -1, // Get all sections
    'orderby'        => 'menu_order', 
    'order'          => 'DES',
));


if (!empty($destination_sections)) {
 
    if (isset($destination_sections[1])) {
        $section1 = $destination_sections[1];
        $section1_title = get_the_title($section1->ID);
    
        ?>

<!-- Hero Section -->
  <section class="background-container">
         <!-- Start Hero Section -->
    <!-- Top Hero Section -->
<section class="bg-gradient-to-b from-[#105B66] to-[#BAD0B4] py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
        <h1 class="font-['Berkshire_Swash'] text-[#C8E677] text-[40px] mb-2 md:text-6xl md:mb-8">
        <?php echo esc_html($section1_title); ?>
        </h1>
        <p class="text-white text-[24px] max-w-4xl" style="line-height:30.4px;">
        <?php   $content = get_post_field('post_content', $section1->ID); ?>
               <?php if (!empty(trim($content))): ?>
            
               <?php echo strip_tags(apply_filters('the_content', $content), '<strong><em><ul><li><ol><br>'); ?>
             
                <?php endif ?>
        </p>
    </div>
</section>

        <?php
    }}
    ?>

<?php

// Query Top Destinations
$args = array(
    'post_type'      => 'destination',
    'meta_key'       => 'top_destination',
    'meta_value'     => '1',
    'posts_per_page' => -1,
);
$top_destinations = new WP_Query($args);
?>



<!-- Destinations Grid Section -->
<!-- Destinations Grid Section -->
<section class="py-16 w-full bg-white">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-28">
        <!-- Grid Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if ($top_destinations->have_posts()) : ?>
                <?php while ($top_destinations->have_posts()) : $top_destinations->the_post(); ?>
                    <?php
                    $destination_name = get_the_title();
                    $destination_link = get_permalink();
                    $destination_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $destination_id = get_the_ID();
                    
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
            
            wp_reset_postdata();
            ?>
                    <a href="<?php echo esc_url($destination_link); ?>" class="relative rounded-2xl overflow-hidden h-[423px] lg:w-[397px] group block">
                        <img src="<?php echo esc_url($destination_image); ?>" alt="<?php echo esc_attr($destination_name); ?>" class="w-full h-full object-cover transition duration-300 group-hover:scale-110"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-8 left-6">
                            <span class="bg-[#C8E677] text-[#0B5864] px-7 py-2 rounded-full text-sm font-semibold">
                                <?php echo esc_html($num_trips); ?> Trips
                            </span>
                            <div class="flex items-center gap-2">
                                <h3 class="text-white text-3xl font-semibold mt-6"><?php echo esc_html($destination_name); ?></h3>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="text-white">
                                    <path d="M17 7L7 17M17 7H7M17 7V17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </a>

                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="text-center text-gray-500">No top destinations available.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
            </section>
<?php get_template_part('template-parts/scroll-to-top');?>
<?php get_template_part('/template-parts/footer') ?>