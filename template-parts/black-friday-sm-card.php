<!-- // Get Black Friday settings from the customizer -->
<?php
$_yellow = "#C8EC1F";
$_primary = "#095763";
$_primary_two = "#074C56";
?>
<?php
$bf_title = get_theme_mod('black_friday_title', 'Black Friday Offer');
$bf_subtitle = get_theme_mod('black_friday_subtitle', 'Limited Time Deal!');
$bf_btn_text1 = get_theme_mod('black_friday_btn_text1', 'Discover Now');
$bf_btn_link1 = get_theme_mod('black_friday_btn_link1', '#');
?>



<div class="overflow-hidden bg-[<?php echo $_primary; ?>] rounded-[20px] p-2 md:p-8 text-center h-[150px] md:h-[300px]">
    <h3 class="font-['Berkshire_Swash'] text-[<?php echo $_yellow; ?>] text-[16px] md:text-[30px] my-2 md:mt-6 md:mb-8">
        <?php echo esc_html($bf_title); ?>
    </h3>
    <p class="text-white text-[14px] md:text-[20px] font-medium mb-4 md:mb-8">
        <?php echo esc_html($bf_subtitle); ?>
    </p>
    <a href="<?php echo esc_url($bf_btn_link1); ?>" class="text-[<?php echo $_yellow; ?>] flex items-center justify-center gap-2 md:gap-4 group">
        <span class="text-[14px] md:text-[16px]"><?php echo esc_html($bf_btn_text1); ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:translate-x-1 duration-300"
             width="30" height="30" viewBox="0 0 33 32" fill="none">
            <path d="M26.7861 16H6.2147" stroke="<?php echo $_yellow; ?>" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M26.7861 16L19.513 22.7882" stroke="<?php echo $_yellow; ?>" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M26.7861 16L19.513 9.21177" stroke="<?php echo $_yellow; ?>" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>
</div>