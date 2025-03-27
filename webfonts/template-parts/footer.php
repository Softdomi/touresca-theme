<html>
    <style>
           .social-icon {
            background-color: rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }
        footer .nav-link.active {
            color: #C5FF4A !important; 
            background:transparent !important ;
        }
    </style>
<footer class="bg-[#06414A] py-24">
<?php
$footer_logo = get_theme_mod("footer_logo");
$facebook = get_theme_mod("footer_facebook_link");
$twitter = get_theme_mod("footer_twitter_link");
$instagram = get_theme_mod("footer_instagram_link");
$whatsapp = get_theme_mod("footer_whatsapp_link");
$email = get_theme_mod("footer_email");
$phone = get_theme_mod("footer_phone");
$address = get_theme_mod("footer_address");
$location = get_theme_mod("footer_location");
?>
        <div class="container mx-auto px-8">
            <div class="grid grid-cols-12 gap-8">
                <!-- Logo Section -->
                <div class="col-span-8 md:col-span-4 flex justify-center md:justify-start items-center order-1 md:order-1">
                    <div class="flex items-center">
                    <?php if ($footer_logo) : ?>
                <img src="<?php echo esc_url($footer_logo) ?>" alt="Touresca Logo" class="">
            <?php endif; ?>
                      
                    </div>
                </div>

                <!-- Navigation Links -->
              <?php  display_menu('footer', 'Footer_Nav_Walker', 
              ['menu_class' => 'col-span-12 md:col-span-4 space-y-4 pl-4 md:pl-12 order-2 md:order-3']);?>

            

                <!-- Contact Section -->
                <div class="col-span-12 md:col-span-4 pl-4 md:pl-0 order-3 md:order-2">
                    <h3 class="text-[#C5FF4A] text-xl mb-6">Contact</h3>
                    <div class="space-y-4 text-white">
                        <div class="flex items-center space-x-3">
                            <i class="far fa-envelope w-5"></i>
                            <span> 
                            <?php if ($email) : ?>
                                <a href="mailto:<?php echo esc_url($email) ?>"><?php echo esc_html($email) ?></a>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-phone w-5"></i>
                            <span>
                            <?php if ($phone) : ?>
                                <a href="tel:<?php echo esc_url($phone) ?>"><?php echo esc_html($phone) ?></a>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt w-5"></i>
                            <span> <?php if ($location) : ?>
                                <a href="<?php echo esc_url($location) ?>">
                                <?php if ($address) : ?>
                                    <?php echo esc_html($address) ?></a>
                                <?php endif; ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Social Media Icons -->
                    <div class="flex space-x-3 mt-6">
                        <?php if ($facebook) : ?>
                        <a href="<?php echo esc_url($facebook) ?>" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram) ?>" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($whatsapp) : ?>
                        <a href="<?php echo esc_url($whatsapp) ?>" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <?php endif; ?>
                        <?php if ($twitter) : ?>
                        <a href="<?php echo esc_url($twitter) ?>" class="social-icon w-10 h-10 rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php wp_footer() ?>
</body>


</html>