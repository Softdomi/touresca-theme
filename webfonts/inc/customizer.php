<?php 
// add custom nav logo 
function theme_customize_register($wp_customize) {
    // Add Section
    $wp_customize->add_section('theme_logo_section', array(
        'title'       => __('Navigation Logo', 'your-theme'),
        'priority'    => 30,
    ));

    // Add Setting
    $wp_customize->add_setting('theme_nav_logo', array(
        'default'    => '',
        'transport'  => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Add Control
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_nav_logo_control', array(
        'label'      => __('Upload Logo', 'your-theme'),
        'section'    => 'theme_logo_section',
        'settings'   => 'theme_nav_logo',
    )));
}
add_action('customize_register', 'theme_customize_register');

// Add section for footer settings 
function register_footer_settings($wp_customize) {
    $wp_customize->add_section("footer_settings_section", array(
        "title" => __("Footer Settings ", "custom_theme"),
        "priority" => 40, 
        "description" => __("Settings for the footer section."),
    ));

    // Add setting for Footer Logo
    $wp_customize->add_setting("footer_logo", array(
        "default" => "",  
        "transport" => "postMessage",
    ));

    // Add control for Footer Logo
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "footer_logo", array(
        "label" => "Footer Logo",
        "section" => "footer_settings_section",
        "settings" => "footer_logo" 
    )));

    // Add social media links for footer
    $social_media = array("facebook", "twitter", "instagram", "whatsapp");

    foreach ($social_media as $platform) {
        $wp_customize->add_setting("footer_{$platform}_link", array(
            "default" => "",  
            "transport" => "postMessage",
        ));

        $wp_customize->add_control("footer_{$platform}_link", array(
            "label" => ucfirst($platform) . "URL",
            "section" => "footer_settings_section",
            "settings" => "footer_{$platform}_link",
            "type" => "text",
        ));
    }

    // Add contact info (email, phone, address)
    $contact_info = array("email", "phone", "address" , "location");

    foreach ($contact_info as $info) {
        $wp_customize->add_setting("footer_{$info}", array(
            "default" => "",  
            "transport" => "postMessage",
        ));

        $wp_customize->add_control("footer_{$info}", array(
            "label" => ucfirst($info),
            "section" => "footer_settings_section",
            "settings" => "footer_{$info}",
            "type" => "text",
        ));
    }
}
add_action('customize_register', 'register_footer_settings');

// why to choose us section settings 
function register_why_us_settings($wp_customize) {
    $wp_customize->add_section("why_us_section_settings", array(
        "title"       => __("Why Us Section", "custom_theme"),
        "priority"    => 30, 
        "description" => __("Settings for the 'Why Us' section."),
    ));

    // Register three items (each with img, header, description)
    for ($i = 1; $i <= 3; $i++) {
        // Image setting
        $wp_customize->add_setting("why_us_image_$i", array(
            "default"   => "",  
            "transport" => "refresh",
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "why_us_image_$i", array(
            "label"    => __("Image $i", "custom_theme"),
            "section"  => "why_us_section_settings",
            "settings" => "why_us_image_$i",
        )));

        // Header setting
        $wp_customize->add_setting("why_us_header_$i", array(
            "default"   => "",  
            "transport" => "refresh",
        ));

        $wp_customize->add_control("why_us_header_$i", array(
            "label"    => __("Header $i", "custom_theme"),
            "section"  => "why_us_section_settings",
            "settings" => "why_us_header_$i",
            "type"     => "text",
        ));

        // Description setting
        $wp_customize->add_setting("why_us_description_$i", array(
            "default"   => "",  
            "transport" => "refresh",
        ));

        $wp_customize->add_control("why_us_description_$i", array(
            "label"    => __("Description $i", "custom_theme"),
            "section"  => "why_us_section_settings",
            "settings" => "why_us_description_$i",
            "type"     => "textarea",
        ));
    }
}

add_action('customize_register', 'register_why_us_settings');


// sale settings section 
function register_sale_settings($wp_customize) {
    $wp_customize->add_section("sale_settings_section", array(
        "title"       => __("Sale Settings", "custom_theme"),
        "priority"    => 40,
        "description" => __("Settings for the sale section."),
    ));

    // Sale fields array
    $sale_fields = [
        "percentage" => ["label" => "Sale Percentage", "default" => "50%", "type" => "text"],
        "description" => ["label" => "Sale Description", "default" => "Get the best discount on our products!", "type" => "textarea"],
        "button_text" => ["label" => "Sale Button Text", "default" => "Shop Now", "type" => "text"],
        "button_link" => ["label" => "Sale Button URL", "default" => "#", "type" => "url"],
    ];

    foreach ($sale_fields as $key => $field) {
        $setting_id = "sale_{$key}";

        $wp_customize->add_setting($setting_id, array(
            "default"   => $field["default"],
            "transport" => "refresh",
            "sanitize_callback" => $field["type"] === "url" ? "esc_url_raw" : "sanitize_text_field",
        ));

        $wp_customize->add_control($setting_id, array(
            "label"   => __($field["label"], "custom_theme"),
            "section" => "sale_settings_section",
            "type"    => $field["type"],
        ));
    }
}
add_action("customize_register", "register_sale_settings");

// contact ways info settings 
// Contact Info Settings Section
// Contact Info Settings Section
function register_contact_info_settings($wp_customize) {
    $wp_customize->add_section("contact_info_settings_section", array(
        "title"       => __("Contact Info Settings", "custom_theme"),
        "priority"    => 50,
        "description" => __("Settings for the contact information section."),
    ));
   // section title 
   $wp_customize->add_setting("contact_section_title", array(
    "default"   => "test title",  
    "transport" => "refresh",
));

$wp_customize->add_control("contact_section_title", array(
    "label"    => __("Contact Section Title", "custom_theme"),
    "section"  => "contact_info_settings_section",
    "settings" => "contact_section_title",
    "type"     => "textarea",
));
    // Loop to create 3 sets of contact info fields
    for ($i = 1; $i <= 3; $i++) {
     
        // Image setting
        $wp_customize->add_setting("contact_image_$i", array(
            "default"   => "",  
            "transport" => "refresh",
        ));

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "contact_image_$i", array(
            "label"    => __("Contact Image $i", "custom_theme"),
            "section"  => "contact_info_settings_section",
            "settings" => "contact_image_$i",
        )));

        // Header setting
        $wp_customize->add_setting("contact_header_$i", array(
            "default"   => "",  
            "transport" => "refresh",
        ));

        $wp_customize->add_control("contact_header_$i", array(
            "label"    => __("Contact Header $i", "custom_theme"),
            "section"  => "contact_info_settings_section",
            "settings" => "contact_header_$i",
            "type"     => "text",
        ));

        // Description setting
        $wp_customize->add_setting("contact_description_$i", array(
            "default"   => "",  
            "transport" => "refresh",
        ));

        $wp_customize->add_control("contact_description_$i", array(
            "label"    => __("Contact Description $i", "custom_theme"),
            "section"  => "contact_info_settings_section",
            "settings" => "contact_description_$i",
            "type"     => "textarea",
        ));
    }
}
add_action("customize_register", "register_contact_info_settings");

// Review Settings Section


?>

