<?php
$args = array(
    'post_type' => 'reviews',
    'posts_per_page' => 10
);
$reviews = new WP_Query($args);
$first_review_title = '';


?>

<section class="what-are-saying-section max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto relative my-16">
<h3 class="text-[#05363D] text-[26px] md:text-[36px] mb-6">
What travelers are saying about our guided trips ?
</h3>


<div class="swiper what-are-saying-swiper pb-12 md:pb-20">
<div class="swiper-wrapper">
    
<?php
if ($reviews->have_posts()) :
    while ($reviews->have_posts()) : $reviews->the_post();
        $subtitle = get_post_meta(get_the_ID(), '_subtitle', true);
        $rating = get_post_meta(get_the_ID(), '_rating', true);
        $visitor_name = get_post_meta(get_the_ID(), '_visitor_name', true);
        $visitor_address = get_post_meta(get_the_ID(), '_visitor_address', true);
        $travelled_in = get_post_meta(get_the_ID(), '_travelled_in', true);
        $visitor_image = get_post_meta(get_the_ID(), '_visitor_image', true);
        $gallery = get_post_meta(get_the_ID(), '_gallery', true) ?: [];
        ?>

		<div class="swiper-slide bg-[#F4F8F3] shadow-lg rounded-lg p-6 border border-gray-200">
			<!-- Star Rating -->
            <?php


echo '<div class="flex items-center">';
for ($i = 1; $i <= 5; $i++) {
    $color = ($i <= $rating) ? 'text-yellow-500' : 'text-gray-300';
    echo '<svg class="w-6 h-6 ' . $color . '" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.173c.969 0 1.371 1.24.588 1.81l-3.375 2.452a1 1 0 00-.364 1.118l1.286 3.967c.3.921-.755 1.688-1.54 1.118l-3.375-2.452a1 1 0 00-1.175 0l-3.375 2.452c-.785.57-1.84-.197-1.54-1.118l1.286-3.967a1 1 0 00-.364-1.118L2.075 9.394c-.783-.57-.381-1.81.588-1.81h4.173a1 1 0 00.95-.69l1.286-3.967z"/>
          </svg>';
}
echo '</div>';
?>
           
			<!-- Travel Info -->
			<div class="flex items-center justify-between flex-wrap">
				<h2 class="text-2xl font-bold mt-4"><?php echo  $subtitle ?></h2>
                <?php
$travelled_in = get_post_meta(get_the_ID(), '_travelled_in', true);

$on_position = strpos($travelled_in, 'on');

if ($on_position !== false) {
    // Get the first part (everything before "on")
    $first_part = trim(substr($travelled_in, 0, $on_position));

    // Get the second part (everything including and after "on")
    $second_part = trim(substr($travelled_in, $on_position + 3)); // +3 to remove "on" from start

    echo '<span class="inline-block bg-green-100 text-green-800 text-xs md:text-sm font-medium px-3 py-1 rounded-full">';
    echo htmlspecialchars($first_part) . ' on <span class="font-semibold">' . htmlspecialchars($second_part) . '</span>';
    echo '</span>';
}
?>


				</span>
			</div>
			<!-- Description -->
			<p class="text-gray-700 mt-3 text-sm md:text-base">
            <?php   $content = get_post_field('post_content', get_the_ID()); ?>
            <?php if (!empty(trim($content))): ?>
            
            <?php echo strip_tags(apply_filters('the_content', $content), '<strong><em><ul><li><ol><br>'); ?>
          
             <?php endif ?>
			</p>

			<!-- Photos Section -->
			<div class="mt-4">
				<h3 class="text-gray-700 mb-2">Photos from the trip</h3>
				<div class="flex space-x-3">
                <?php foreach ($gallery as $image) : ?>
                        <img src="<?= esc_url($image); ?>" alt="Trip photo 1"
						class="scale-75 hover:scale-100 duration-300 w-16 h-16 md:w-28 md:h-28 rounded-lg object-cover shadow-md">
                    <?php endforeach; ?>
				</div>
			</div>

			<!-- User Section -->
			<div class="flex items-center mt-6">
            <?php if ($visitor_image): ?>
                       <img loading="lazy" src="<?= esc_url($visitor_image); ?>" alt="User profile" class="w-12 h-12 rounded-full border border-gray-200"/>
                         <?php endif; ?>
				<div class="ml-3">
					<p class="font-bold">
                    <?php if ($visitor_name): ?>
                        <?php echo esc_html($visitor_name) ?>
                         <?php endif; ?>
                </p>
                    <p class="text-sm text-gray-500 flex items-center gap-1">
						<img loading="lazy" src="<?php echo get_template_directory_uri() ?>/images/icons/location.svg" alt="Location icon" />
                        <?php if ($visitor_address): ?>
                            <span> <?php echo esc_html($visitor_address) ?></span>
                         <?php endif; ?>
				      
					</p>
				</div>
			</div>
		</div>
        <?php endwhile;
        wp_reset_postdata();
    endif;
    ?>
		
	</div>

	<!-- Navigation buttons -->
	<div class="swiper-button-prev"></div>

	<div class="swiper-button-next"></div>

	<!-- Pagination -->
	<div class="swiper-pagination"></div>
</div>
   
</section>


