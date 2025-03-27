<?php
$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";
?>
<?php
// Get Black Friday settings from the customizer
$bf_title = get_theme_mod('black_friday_title', 'Black Friday Offer');
$bf_subtitle = get_theme_mod('black_friday_subtitle', 'Limited Time Deal!');
$bf_description = get_theme_mod('black_friday_description', 'A private visit to Queen Nefertari\'s Tomb, known as the with an expert Egyptologist as the guide.');
$bf_btn_text2 = get_theme_mod('black_friday_btn_text2', 'Book Trip');
$bf_btn_link2 = get_theme_mod('black_friday_btn_link2', '#');
?>

<!-- Black Friday Offer Card -->
<div class="swiper-slide">
    <div class="bg-[#095763] rounded-[20px] p-10 h-full flex flex-col items-center text-center">
        <h3 class="font-['Berkshire_Swash'] text-[#C8EC1F] text-[40px] leading-[44px] mt-6 mb-8">
            <?php echo esc_html($bf_title); ?>
        </h3>
        <p class="text-white text-[20px] font-medium mb-8">
            <?php echo esc_html($bf_subtitle); ?>
        </p>
        <p class="text-white/80 text-base mb-8">
            <?php echo esc_html($bf_description); ?>
        </p>
        <div class="flex-grow flex items-center justify-center">
            <a href="<?php echo esc_url($bf_btn_link2); ?>"
               class="bg-[#C8E677] text-[#06414A] py-3 px-6 md:px-20 w-full md:w-fit rounded-full hover:bg-opacity-90 transition-colors">
                <?php echo esc_html($bf_btn_text2); ?>
            </a>
        </div>
    </div>
</div>
