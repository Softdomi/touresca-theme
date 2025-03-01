<!-- add loader to the page  -->
<?php get_template_part('template-parts/loader'); ?>
<!-- add header to the page  -->
<?php get_template_part('template-parts/header'); ?>

<?php
// Query all posts of the 'faq_sections' custom post type
$faq_sections = get_posts(array(
    'post_type' => 'faq',
    'posts_per_page' => -1, // Get all sections
    'orderby' => 'menu_order', 
    'order' => 'ASC',
));

?>

<!-- FAQ Hero Section -->
<section class="bg-gradient-to-b from-[#105B66] to-[#BAD0B4] py-40">
    


    <?php if (!empty($faq_sections)): ?>
        <?php foreach ($faq_sections as $section): ?>
            <!-- <h1><?php echo esc_html(get_the_title($section->ID)); ?></h1> -->
            <!-- text-white text[24px] max-w-3xl -->
           
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0 ">
    <h1 class="font-['Berkshire_Swash'] text-[#C8E677] text-[40px] mb-2 md:text-6xl md:mb-8"><?php echo esc_html(get_the_title($section->ID)); ?></h1>
           
        
    <?php
$content = get_post_field('post_content', $section->ID);
$content = wp_strip_all_tags(apply_filters('the_content', $content)); // Remove all HTML tags
echo '<p class="text-white text-[24px] max-w-3xl" style="line-height:30.4px;">';
echo $content;
echo '</p>';
?>

    </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No FAQ sections found.</p>
        
    <?php endif; ?>
    </section>
    <section class="faq-sections">
    <?php if (!empty($faq_sections)): ?>
        <?php foreach ($faq_sections as $section): ?>
        

            <!-- Retrieve the repeater data -->
            <?php $repeater_data = get_post_meta($section->ID, '_repeater_data', true); ?>
            <?php if (!empty($repeater_data)): ?>
                <div class="container mx-auto max-w-7xl py-12 faq">
                    <div class="space-y-4">
                        <?php foreach ($repeater_data as $data): ?>
                            <div class="faq-item">
                                <div class="faq-question flex justify-between items-center" onclick="toggleFAQ(0)">
                                    <h3 class="text-[#004D40] font-medium"><?php echo esc_html($data['secondary_header']); ?></h3>
                                    <svg class="chevron w-5 h-5 text-[#46818A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                                <div class="faq-answer" id="faq-answer-0">
                                    <p class="text-gray-600"><?php echo esc_html($data['secondary_description']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No FAQ sections found.</p>
    <?php endif; ?>
    </section>


<!-- add footer to the page  -->
<?php get_template_part('template-parts/footer'); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".faq").forEach(faqSection => {
        faqSection.addEventListener("click", function (event) {
            const question = event.target.closest(".faq-question");
            if (!question) return; // Exit if the clicked element isn't a question

            const faqItem = question.parentElement;
            const answer = faqItem.querySelector(".faq-answer");
            const chevron = faqItem.querySelector(".chevron");

            // Toggle the active state
            faqItem.classList.toggle("active");
            answer.classList.toggle("active");
            chevron.classList.toggle("active");
        });
    });
});

    </script>