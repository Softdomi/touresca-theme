
<section class="grid grid-cols-1 gap-4 md:grid-cols-3 mt-4">
    
    <?php for ($i = 1; $i <= 3; $i++): ?>
        <?php 
    
            $contact_image = get_theme_mod("contact_image_$i");
            $contact_header = get_theme_mod("contact_header_$i", "");
            $contact_description = get_theme_mod("contact_description_$i", "");
        ?>

        <?php if (!empty($contact_header) || !empty($contact_description)): ?>
            <div class="card rounded-[20px] overflow-hidden relative bg-[#F4F8F3] p-6">
             
                <h3 class="text-[#05363D] text-3xl mb-4 flex items-center gap-2">
                <?php if ($contact_image): ?>
                    <img src="<?php echo esc_url($contact_image); ?>" alt="Contact Image <?php echo $i; ?>">
                <?php endif; ?>

			<span><?php echo esc_html($contact_header); ?></span>
		</h3>
        <p class="text-gray-500 text-base mb-4 leading-7">
        <?php echo esc_html($contact_description); ?></p>
		<a href="#" class="text-[<?= $_primary ?>] font-medium flex justify-end items-center gap-2 group">
			<span>Start Chat</span>
			<img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icons/arrow-right.svg" alt="Arrow right icon"
				class="group-hover:translate-x-1 duration-300" width="30" height="30" />

		</a>
                
            </div>
        <?php endif; ?>
    <?php endfor; ?>
</section>



