<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Section Header -->
    <div class="text-center mb-12">
        <h2 class="why mb-2">
            Why to choose
            <span>Touresca</span>
        </h2>
    </div>

    <!-- Features Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php for ($i = 1; $i <= 3; $i++) : ?>
            <?php 
                $image = get_theme_mod("why_us_image_$i", ""); 
                $header = get_theme_mod("why_us_header_$i", "Default Header $i");
                $description = get_theme_mod("why_us_description_$i", "Default description for section $i.");
            ?>
            <div class="bg-[#F4F8F3] rounded-2xl p-8 text-center">
                <div class="flex justify-center mb-6">
                    <?php if ($image) : ?>
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($header); ?>" class="w-14  object-fit-cover">
                    <?php endif; ?>
                </div>
                <h3 class="why-h3 mb-4"><?php echo esc_html($header); ?></h3>
                <p class="why-p"><?php echo esc_html($description); ?></p>
            </div>
        <?php endfor; ?>
    </div>
</section>
