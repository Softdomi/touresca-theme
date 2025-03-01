
<?php
// Query all posts of the 'faq_sections' custom post type
$faq_sections = get_posts(array(
    'post_type' => 'faq',
    'posts_per_page' => 3, // Get all sections
    'orderby' => 'menu_order', 
    'order' => 'ASC',
));

?>
<section class="faq-sections">
    <?php if (!empty($faq_sections)): ?>
        <div class="bg-white pt-12">
    

    </div>
        <?php foreach ($faq_sections as $section): ?>
        
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-2">
        <h2 class="text-[#095763] text-[32px] sm:text-[40px] font-[600] mb-2"><?php echo esc_html(get_the_title($section->ID)); ?></h2>
        <div class="flex justify-between items-center">
        <?php  $subtitle = get_post_meta($section->ID, '_subtitle', true);   ?>
            <p class="text-gray-500 text-[14px] sm:text-[20px] max-w-[80%]"><?php echo  $subtitle ?></p>
            <a href="<?php echo site_url('/faq'); ?>" class="text-[#095763] text-[16px] hover:underline hover:text-[#309CAB]">Show all</a>
        </div>
    </div>
            <!-- Retrieve the repeater data -->
            <?php $repeater_data = get_post_meta($section->ID, '_repeater_data', true); ?>
            <?php if (!empty($repeater_data)): ?>
                <div class="container mx-auto max-w-7xl py-12 faq">
                    <div class="space-y-4">
                    <?php foreach ($repeater_data as $index => $data): ?>
    <div class="faq-item">
        <div class="faq-question flex justify-between items-center" onclick="toggleFAQ(<?php echo $index; ?>)">
            <h3 class="text-[#004D40] font-medium"><?php echo esc_html($data['secondary_header']); ?></h3>
            <svg class="chevron w-5 h-5 text-[#46818A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"> 
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <div class="faq-answer">
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
<!-- End of HTML content -->


