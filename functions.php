<?php

// include customizer file 
// posts
// 1-the post thumbnail it does not exist in all themes
// 2-to add it to my see we do the following 
// to add thumbnail to the post
add_theme_support( 'post-thumbnails' ); 
require_once get_template_directory() . "/inc/customizer.php";
// tp enqueue your styles files 
function add_styles(){
    // to add css files we use wp_enqueue_style 
    wp_enqueue_style('tailwindcss', get_template_directory_uri() . '/dist/output.css', array(), filemtime(get_template_directory() . '/dist/output.css'));
    // Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0', 'all');
    // wp_enqueue_style('tailwindcss', 'https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css', array(), null , false);
    wp_enqueue_style('fontawesome' , get_template_directory_uri() . '/css/all.min.css');

    wp_enqueue_style('dashboard-css-file' , get_template_directory_uri() . '/css/dashboard-style.css' ,  array(), time(), 'all');
    wp_enqueue_style('main-css-file' , get_template_directory_uri() . '/css/main.css' ,  array(), time(), 'all');

    
}
/////////////////////////////////////////////////////////////////////////////////////////////
// tp enqueue your scripts files 
function add_script(){
    // wp_enqueue_script('tailwind-js', 'https://cdn.tailwindcss.com', array(), null, true);
    wp_enqueue_script('image-switcher' , get_template_directory_uri() . '/js/main.js' , array() , false , true);
    // wp_enqueue_script('destinations' , get_template_directory_uri() . '/js/destinations.js' ,  array() , false , true);
    // wp_enqueue_script('image-switcher' , get_template_directory_uri() . '/js/image-switcher.js' , array() , false , true);
     // Swiper JS
     wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
    wp_deregister_script('jquery');
    wp_register_script('jquery' , includes_url('/js/jquery/jquery.js') , false , " " , true );
    wp_enqueue_script('jquery');
  
}
////////////////////////////////////////////////////////////////////////////////////////////
// we use add_action to run the function I made by using specific hook 
add_action('wp_enqueue_scripts' , 'add_styles');
add_action('wp_enqueue_scripts' , 'add_script');

//////////////////////////////////////////////////////////////////////////////////////////
function enqueue_intl_tel_input() {
    wp_enqueue_style('intl-tel-input-css', 'https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/css/intlTelInput.min.css');
    wp_enqueue_script('intl-tel-input-js', 'https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_intl_tel_input');

// to enable the website-owner to add it is logo dynamically 
function theme_custom_logo_setup() {
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'theme_custom_logo_setup');



/////////////////////////////////////////////////////////////////////////////////////////
    // to add locations for menus and make more than one menu
function registr_custom_menu(){
    register_nav_menus(array(
        'navbar'=>"navigation bar" ,
        'footer'=>'footer menu'
    ));
}

///////////////////////////////////////////////////////////////////////////////////////
// walker to handle links classes 
class Custom_Nav_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // Check if this is the current page or an ancestor
        $is_active = in_array('current-menu-item', $classes) || in_array('current_page_item', $classes) || in_array('current-menu-ancestor', $classes);

        // Generate the <li> classes
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        // Add "nav-link" to all links and "active" only if the link is active
        $link_classes = 'nav-link';
        if ($is_active) {
            $link_classes .= ' active';
        }

        // Generate the <a> attributes
        $attributes = !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= ' class="' . esc_attr($link_classes) . '"';

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= '<li' . $class_names . '>' . $item_output . '</li>';
    }
}

class Footer_Nav_Walker extends Walker_Nav_Menu {
    // Start element output
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<div class="flex items-center space-x-2">';
        $output .= '<i class="fas fa-chevron-right text-white text-xs"></i>';
        $output .= '<a href="' . esc_url($item->url) . '" class="text-white hover:text-[#C5FF4A] transition-colors">';
        $output .= apply_filters('the_title', $item->title, $item->ID);
        $output .= '</a>';
        $output .= '</div>';
    }
}
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('theme-style', get_stylesheet_uri(), [], microtime()); // Prevent caching
});

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
// to display menu 
function display_menu($theme_location = 'navbar', $walker_class = 'Custom_Nav_Walker', $args = []) {
    if (!has_nav_menu($theme_location)) {
        return; // Don't render if the menu is not assigned
    }

    // Merge default args with user-provided args
    $default_args = array(
        'theme_location' => $theme_location,
        'menu_class'     => 'nav-links flex space-x-8',
        'container'      => false,
        'walker'         => class_exists($walker_class) ? new $walker_class() : null,
    );

    $final_args = array_merge($default_args, $args);

    wp_nav_menu($final_args);
}

// init is the hook which fire when the page loaded 
add_action('init' , 'registr_custom_menu');
////////////////////////////////////////////////////////////////////////////
function create_reviews_cpt() {
    $labels = array(
        'name' => __('Reviews', 'textdomain'),
        'singular_name' => __('Review', 'textdomain'),
        'menu_name' => __('Reviews', 'textdomain'),
        'add_new' => __('Add New Review', 'textdomain'),
        'add_new_item' => __('Add New Review', 'textdomain'),
        'edit_item' => __('Edit Review', 'textdomain'),
        'new_item' => __('New Review', 'textdomain'),
        'view_item' => __('View Review', 'textdomain'),
        'all_items' => __('All Reviews', 'textdomain'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'reviews'),
    );

    register_post_type('reviews', $args);
}
add_action('init', 'create_reviews_cpt');
function add_reviews_meta_boxes() {
    add_meta_box(
        'review_details',
        'Review Details',
        'render_reviews_meta_box',
        'reviews',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_reviews_meta_boxes');

function render_reviews_meta_box($post) {
    // Retrieve stored values
    $subtitle = get_post_meta($post->ID, '_subtitle', true);
    $rating = get_post_meta($post->ID, '_rating', true);
    $visitor_name = get_post_meta($post->ID, '_visitor_name', true);
    $visitor_address = get_post_meta($post->ID, '_visitor_address', true);
    $travelled_in = get_post_meta($post->ID, '_travelled_in', true);
    $visitor_image = get_post_meta($post->ID, '_visitor_image', true);
    $gallery = get_post_meta($post->ID, '_gallery', true) ?: [];

    wp_nonce_field('save_review_meta', 'review_meta_nonce');
    ?>
<div class="reviews-fields fields-container">
<p><label for="subtitle"><strong>Subtitle:</strong></label></p>
    <input type="text" id="subtitle" name="subtitle" value="<?= esc_attr($subtitle); ?>" style="width:70%; " />

    <p><label for="rating"><strong>Rating (out of 5):</strong></label></p>
    <input type="number" id="rating" name="rating" min="1" max="5" value="<?= esc_attr($rating); ?>" style="width:70%;" />

    <p><label for="visitor_name"><strong>Visitor Name:</strong></label></p>
    <input type="text" id="visitor_name" name="visitor_name" value="<?= esc_attr($visitor_name); ?>" style="width:70%;" />

    <p><label for="visitor_address"><strong>Visitor Address:</strong></label></p>
    <input type="text" id="visitor_address" name="visitor_address" value="<?= esc_attr($visitor_address); ?>" style="width:70%;" />

    <p><label for="travelled_in"><strong>Travelled In:</strong></label></p>
    <input type="text" id="travelled_in" name="travelled_in" value="<?= esc_attr($travelled_in); ?>" style="width:70%;" />

    <!-- Visitor Image Upload -->
    <p><label><strong>Visitor Image:</strong></label></p>
    <input type="hidden" id="visitor_image" name="visitor_image" value="<?= esc_url($visitor_image); ?>" />
    
    <img id="visitor_image_preview" src="<?= esc_url($visitor_image); ?>" style="width:90px; height:90px; object-fit:cover;margin-bottom:8px; display: <?= $visitor_image ? 'block' : 'none'; ?>;">
    <div style = "display:flex; gap:8px">
    <button type="button" id="upload_visitor_image" class = "upload">Upload </button>
    <button type="button" class = "remove" id="remove_visitor_image" style="<?= $visitor_image ? 'display:block;' : 'display:none;'; ?>">Remove</button>
    </div>
   

    <!-- Gallery Upload -->
    <p><strong>Gallery Images:</strong></p>
    <div id="gallery-container" style = "display:flex; gap:8px ; ">
        <?php if (!empty($gallery)) : ?>
            <?php foreach ($gallery as $image) : ?>
                <div class="gallery-item ">
                    <div>
                    <div>
                    <img src="<?= esc_url($image); ?>" style="max-width:90px; height:90px; object-fit:cover;margin-bottom:8px">
                    <input type="hidden" name="gallery_images[]" value="<?= esc_url($image); ?>">
                    </div>
                  
                    <button type="button" class="remove-gallery-image remove sm-rm-btn" 
                    >Remove</button>
                    </div>
                
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class = "" style="display:flex; width:80%; justify-content:end">
    <button type="button" id="add-gallery-image" class = "upload">Upload </button>
    </div>
    
</div>


    <script>
        jQuery(document).ready(function($) {
            let mediaUploader;

            // Upload Visitor Image
            $('#upload_visitor_image').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media({
                    title: 'Choose Image',
                    button: { text: 'Choose Image' },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    let attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#visitor_image').val(attachment.url);
                    $('#visitor_image_preview').attr('src', attachment.url).show();
                    $('#remove_visitor_image').show();
                });

                mediaUploader.open();
            });

            // Remove Visitor Image
            $('#remove_visitor_image').click(function() {
                $('#visitor_image').val('');
                $('#visitor_image_preview').hide();
                $(this).hide();
            });

            // Upload Gallery Images
            $('#add-gallery-image').click(function(e) {
                e.preventDefault();
                let galleryUploader = wp.media({
                    title: 'Choose Images',
                    button: { text: 'Choose Images' },
                    multiple: true
                });

                galleryUploader.on('select', function() {
                    let selection = galleryUploader.state().get('selection');
                    selection.map(function(attachment) {
                        attachment = attachment.toJSON();
                        $('#gallery-container').append(
                            '<div class="gallery-item">' +
                            '<img src="' + attachment.url + '" style="max-width:100px;">' +
                            '<input type="hidden" name="gallery_images[]" value="' + attachment.url + '">' +
                            '<button type="button" class="remove-gallery-image remove">Remove</button>' +
                            '</div>'
                        );
                    });
                });

                galleryUploader.open();
            });

            // Remove Gallery Image
            $('#gallery-container').on('click', '.remove-gallery-image', function() {
                $(this).closest('.gallery-item').remove();
            });
        });
    </script>
    <?php
}

function save_reviews_meta_boxes($post_id) {
    if (!isset($_POST['review_meta_nonce']) || !wp_verify_nonce($_POST['review_meta_nonce'], 'save_review_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save text fields
    $fields = ['subtitle', 'rating', 'visitor_name', 'visitor_address', 'travelled_in', 'visitor_image'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, "_{$field}", sanitize_text_field($_POST[$field]));
        } else {
            delete_post_meta($post_id, "_{$field}");
        }
    }

    // Save gallery images
    if (!empty($_POST['gallery_images']) && is_array($_POST['gallery_images'])) {
        update_post_meta($post_id, '_gallery', array_map('esc_url', $_POST['gallery_images']));
    } else {
        delete_post_meta($post_id, '_gallery');
    }
}
add_action('save_post', 'save_reviews_meta_boxes');
// Register the Custom Post Types for Sections
function register_section_post_types(){
// Define the sections/pages you want to create
$pages = ["home" , "destinations"  , "blog_sections" , "about" , "faq" , "contact" ];
foreach($pages as $page){
    $name = ucfirst($page)  ;
 // Register the custom post type
    register_post_type($page , array(
     "labels"=>array(
        "name"=>$name , 
        "singular_name" => $page  ,
        "add_new_item"=>"add new section for $name" ,
        "edit_item"=>"edit $name"
     ) ,
      "public"=>true ,
      "has_archive"=>false ,
      "supports"=>["title" , "editor" , "thumbnail"] ,
      "menu_icon"=>"dashicons-layout" ,
      "capabilities" => array(
        "publish_posts" => "edit_pages",
        "edit_posts" => "edit_pages",
        "edit_others_posts" => "edit_pages",
        "delete_posts" => "do_not_allow", 
        "delete_others_posts" => "do_not_allow",
        "read_private_posts" => "read",
        "edit_post" => "edit_page",
        "delete_post" => "do_not_allow" 
    ),
    "map_meta_cap" => true ,
      "register_meta_box_cb"=> function() use ($page) {
        add_meta_box(
            "{$page}_meta_box" ,
           ucfirst($page) . ' Section Fields',
           "render_section_meta_boxes" , 
           $page,
           'normal',
           'default'
        );
      }
    ) );
}
}

add_action('init', 'register_section_post_types');
add_action('init', 'register_section_post_types');
function remove_trash_option($actions, $post) {
    $custom_post_types = ["home", "destinations", "blog_sections", "about", "faq", "contact"];

    if (in_array($post->post_type, $custom_post_types)) {
        // Remove "Trash" and "Quick Edit"
        unset($actions['trash']);
        unset($actions['inline hide-if-no-js']);

        return $actions;
    }

    return $actions;
}

add_filter('post_row_actions', 'remove_trash_option', 10, 2);

// Render the Meta Boxes for Custom Fields
function render_section_meta_boxes($post) {
    // Define basic fields
    $fields = [
        'subtitle'    => 'Subtitle',
        'button_txt'  => 'Button Text',
        'rating'      => 'Rating From 5',
        'image'       => 'Image',
        'name'        => 'User Name',
        'address'     => 'Address'
    ];
    ?>

    <!-- Non-Repeated Fields -->
    <div id="non-repeated-fields" class="fields-container">
        <?php foreach ($fields as $field_key => $field_label) : ?>
            <?php $value = get_post_meta($post->ID, "_{$field_key}", true); ?>
            <?php if (!empty($value) || array_filter($fields, fn($k) => get_post_meta($post->ID, "_{$k}", true))) : ?>
                <div class="field-container">
                    <p>
                    <label for="<?= esc_attr($field_key); ?>"><strong><?= esc_html($field_label); ?></strong></label>
                    </p>
                   
                    <input type="text" name="<?= esc_attr($field_key); ?>" id="<?= esc_attr($field_key); ?>" 
                        value="<?= esc_attr($value); ?>" >
                    <?php if (empty($value)) : ?>
                        <button type="button" class="remove-field remove" data-field="<?= esc_attr($field_key); ?>" data-type="single">✖</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Repeater Fields -->
    <h3>Secondary Fields</h3>
    <div id="repeater-fields">
        <?php 
        $repeater_data = get_post_meta($post->ID, '_repeater_data', true) ?: [];
        if (!empty($repeater_data)) {
            foreach ($repeater_data as $index => $data) {
                render_repeater_field($index, $data);
            }
        }
        ?>
    </div>
    <button type="button" class="button add-repeater upload">Add Field</button>

    <!-- Repeater Field Template -->
    <script type="text/template" id="repeater-template">
        <?php render_repeater_field('REPLACE_INDEX'); ?>
    </script>

    <!-- Gallery Images -->
    <!-- NEW MULTI-IMAGE FIELD -->
    <h3>Gallery Images</h3>
    <div id="gallery-images">
        <?php 
        $gallery_images = get_post_meta($post->ID, '_gallery_images', true) ?: [];
        if (!empty($gallery_images)) {
            foreach ($gallery_images as $image) {
                render_gallery_image_field($image);
            }
        }
        ?>
    </div>
    <div  style="display:flex; justify-content:flex-end; width:80%;">
    <button type="button" class="button add-gallery-image upload">Add Image</button>
    </div>
  

    <!-- Gallery Image Template -->
    <script type="text/template" id="gallery-image-template">
        <?php render_gallery_image_field(''); ?>
    </script>

   

    <!-- Remove Empty Containers & Handle AJAX Removal -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.remove-field').forEach(button => {
                button.addEventListener("click", function() {
                    let field = this.dataset.field;
                    let type = this.dataset.type;
                    let container = this.closest('.field-container');

                    let data = new FormData();
                    data.append("action", "remove_meta_field");
                    data.append("security", "<?= wp_create_nonce('remove_meta_field_nonce'); ?>");
                    data.append("post_id", "<?= $post->ID; ?>");
                    data.append("field", field);
                    data.append("type", type);

                    fetch(ajaxurl, {
                        method: "POST",
                        body: data
                    }).then(response => response.json())
                      .then(result => {
                          if (result.success) {
                              container.remove();
                              checkEmptyContainers();
                          } else {
                              alert(result.message);
                          }
                      });
                });
            });

            function checkEmptyContainers() {
                let repeaterContainer = document.querySelector("#repeater-fields");
                let galleryContainer = document.querySelector("#gallery-images");

                if (repeaterContainer && repeaterContainer.children.length === 0) {
                    repeaterContainer.remove();
                }
                if (galleryContainer && galleryContainer.children.length === 0) {
                    galleryContainer.remove();
                }
            }

            checkEmptyContainers();
        });
    </script>

    <?php add_repeater_script(); ?>
<?php
}
// Function to Render a Single Repeater Field
function render_repeater_field($index, $data = []) { 
    $secondary_header = $data['secondary_header'] ?? '';
    $secondary_description = $data['secondary_description'] ?? '';
    $image = $data['image'] ?? '';
?>
    <div class="repeater-field fields-container" style="margin-bottom: 20px;">
        <p>
        <label><strong>Secondary Header:</strong></label>
        </p>
       
        <input 
            type="text" 
            name="repeater[<?= esc_attr($index) ?>][secondary_header]" 
            value="<?= esc_attr($secondary_header) ?>" 
            >
        <p>
        <label><strong>Secondary Description:</strong></label>
        </p>
       
        <textarea 
            name="repeater[<?= esc_attr($index) ?>][secondary_description]" 
            rows="3" 
            ><?= esc_textarea($secondary_description) ?></textarea>
         
            <p>
            <label><strong>Image:</strong></label>
            </p>
        
        <input 
            type="hidden" 
            class="image-field" 
            name="repeater[<?= esc_attr($index) ?>][image]" 
            value="<?= esc_url($image) ?>">
        <?php if ($image) : ?>
            <img src="<?= esc_url($image) ?>" alt="" style="max-width: 150px; display: block; margin-bottom: 10px;">
        <?php endif; ?>
        
        <button type="button" class="button upload-image upload">Upload </button>
        <div style = "display:flex; justify-content:flex-end; width:80%; margin:10px 0 ;">
        <button type="button" class="button remove-repeater remove">Remove Field</button>
        </div>
     
    </div>
<?php
}



// Function to Render a Single Gallery Image Field
function render_gallery_image_field($image = '') { ?>
    <div class="gallery-image-field "   >
        <input type="hidden" class="gallery-image-url" name="gallery_images[]" value="<?= esc_url($image); ?>" style="width: 80%;" />
        <?php if ($image) : ?>
            <img src="<?= esc_url($image) ?>" style="width:90px;height:90px;border-radius:8px; object-fit:cover">
        <?php endif; ?>
        <button type="button" class="button remove sm-rm-btn remove-gallery-image" style = "margin:8px 0 ; display:block">Remove</button>
        <button type="button" class="button upload-gallery-image" style = "margin-bottom: 8px ">Upload</button>
   
    </div>
  
<?php
}

// Enqueue JavaScript for Media Uploader and Fields
function add_repeater_script() {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            // ADD REPEATER FIELD
            $('.add-repeater').on('click', function () {
                let index = $('#repeater-fields .repeater-field').length;
                let template = $('#repeater-template').html().replace(/REPLACE_INDEX/g, index);
                $('#repeater-fields').append(template);
            });

            // REMOVE REPEATER FIELD
            $(document).on('click', '.remove-repeater', function () {
                $(this).closest('.repeater-field').remove();
            });

            // IMAGE UPLOADER FOR REPEATER
            $(document).on('click', '.upload-image', function (e) {
                e.preventDefault();
                let button = $(this);
                let imageField = button.siblings('.image-field');
                let frame = wp.media({
                    title: 'Select Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frame.on('select', function () {
                    let attachment = frame.state().get('selection').first().toJSON();
                    imageField.val(attachment.url);
                });

                frame.open();
            });

                   // ADD GALLERY IMAGE FIELD
                   $('.add-gallery-image').on('click', function () {
                let template = $('#gallery-image-template').html();
                $('#gallery-images').append(template);
            });

            // REMOVE GALLERY IMAGE FIELD
            $(document).on('click', '.remove-gallery-image', function () {
                $(this).closest('.gallery-image-field').remove();
            });

            // IMAGE UPLOADER FOR GALLERY IMAGES
            $(document).on('click', '.upload-gallery-image', function (e) {
                e.preventDefault();
                let button = $(this);
                let imageField = button.siblings('.gallery-image-url');
                let frame = wp.media({
                    title: 'Select Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frame.on('select', function () {
                    let attachment = frame.state().get('selection').first().toJSON();
                    imageField.val(attachment.url);
                });

                frame.open();
            });
        });
    </script>
    <?php
}


// Save the Meta Box Fields
function save_section_meta_boxes($post_id) {
    if (empty($_POST)) return;

    $fields = ['subtitle', 'button_txt', 'custom_link'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, "_{$field}", sanitize_text_field($_POST[$field]));
        }
    }
 // Save Repeater Data
 if (isset($_POST['repeater'])) {
    $repeater_data = [];
    foreach ($_POST['repeater'] as $data) {
        $repeater_data[] = [
            'secondary_header' => sanitize_text_field($data['secondary_header']),
            'secondary_description' => sanitize_textarea_field($data['secondary_description']),
            'image' => esc_url($data['image']),
        ];
    }
    update_post_meta($post_id, '_repeater_data', $repeater_data);
}

    if (!empty($_POST['gallery_images']) && is_array($_POST['gallery_images'])) {
        $gallery_images = array_map('esc_url', $_POST['gallery_images']); // Ensure URLs are valid
        update_post_meta($post_id, '_gallery_images', $gallery_images); 
    } else {
        update_post_meta($post_id, '_gallery_images', []); // Ensure it's always an array
    }
    
}
add_action('save_post', 'save_section_meta_boxes');



/////////////////////////////////////////////////////////////////////////////
// for filtering posts according to its category 
function enqueue_custom_scripts() {
    wp_enqueue_script('category-filter', get_template_directory_uri() . '/category-filter.js', array('jquery'), null, true);
    wp_localize_script('category-filter', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');



// side to explore section 
function register_explore_egypt_sides() {
    $args = array(
        'label'               => 'Explore Egypt Sides',
        'public'              => true,
        'show_in_menu'        => true,
        'supports'            => ['title'], // Remove default editor
        'menu_icon'           => 'dashicons-location-alt',
    );
    register_post_type('explore_egypt_sides', $args);
}
add_action('init', 'register_explore_egypt_sides');
function add_explore_meta_boxes() {
    add_meta_box('explore_details', 'Explore Egypt Side Details',
     'render_explore_meta_box', 'explore_egypt_sides', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_explore_meta_boxes');

function render_explore_meta_box($post) {
    $header = get_post_meta($post->ID, '_header', true);
    $place = get_post_meta($post->ID, '_place', true);
    $gallery = get_post_meta($post->ID, '_gallery_images', true) ?: [];

    wp_nonce_field('save_explore_meta', 'explore_meta_nonce');
    ?>
    <div class = "fields-container">
    <h3>Header</h3>
    <input type="text" name="header" value="<?= esc_attr($header); ?>" >

    <h3>Place</h3>
    <input type="text" name="place" value="<?= esc_attr($place); ?>" >

    <h3>Gallery Images</h3>
    <div id="gallery-images">
        <?php 
        if (!empty($gallery)) {
            foreach ($gallery as $image) {
                render_gallery_image_field($image);
            }
        }
        ?>
    </div>
    <button type="button" class="button add-gallery-image upload">Add Image</button>
    </div>
    

    <!-- Hidden Template for Adding New Fields -->
    <script type="text/html" id="gallery-image-template">
        <div class="gallery-image-field " style="margin-bottom: 10px;">
            <input type="hidden" class="gallery-image-url" name="gallery_images[]" value="" style="width: 80%;" />
            <img src="" style="max-width: 100px; margin-left: 10px; display: none;">
            <button type="button" class="button upload-gallery-image">Upload</button>
            <button type="button" class="button remove-gallery-image">Remove</button>
        </div>
    </script>
    <?php
}

function enqueue_custom_admin_scripts($hook) {
    global $post;
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        if (isset($post) && $post->post_type === 'explore_egypt_sides') {
            wp_enqueue_media();
            wp_enqueue_script('custom-gallery-script', get_template_directory_uri() . '/js/custom-gallery.js', ['jquery'], null, true);
        }
    }
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_scripts');

function save_explore_meta_boxes($post_id) {
    if (!isset($_POST['explore_meta_nonce']) || !wp_verify_nonce($_POST['explore_meta_nonce'], 'save_explore_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['header'])) {
        update_post_meta($post_id, '_header', sanitize_text_field($_POST['header']));
    } else {
        delete_post_meta($post_id, '_header');
    }

    if (isset($_POST['place'])) {
        update_post_meta($post_id, '_place', sanitize_text_field($_POST['place']));
    } else {
        delete_post_meta($post_id, '_place');
    }

    if (!empty($_POST['gallery_images']) && is_array($_POST['gallery_images'])) {
        $gallery_images = array_map('esc_url', $_POST['gallery_images']); // Ensure URLs are valid
        update_post_meta($post_id, '_gallery_images', $gallery_images); 
    } else {
        update_post_meta($post_id, '_gallery_images', []); // Ensure it's always an array
    }
}
add_action('save_post', 'save_explore_meta_boxes');

function filter_posts() {
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 10,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    if ($category !== 'all') {
        $args['category_name'] = $category;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        $count = 0;
        while ($query->have_posts()) : $query->the_post();
            $count++;
            $extra_classes = ($count === 1) ? 'col-span-1 sm:col-span-2' : '';
    ?>
        <div class="post-item bg-[#F4F8F3] rounded-[20px] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden <?= $extra_classes; ?>">
            <div class="relative">
                <?php the_post_thumbnail('', ['class' => 'w-full h-[350px] object-cover']); ?>
            </div>
            <div class="p-6">
                
                <span class="bg-[#C8EC1F] text-[#095763] px-3 py-1 rounded-full text-xs font-medium">
                <?php 
                                    ob_start();
                                    the_category(', '); 
                                    $categories = ob_get_clean(); 
                                    echo strip_tags($categories); 
                  ?>
                </span>

                <h3 class="text-xl font-semibold my-2">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <p class="text-gray-600 text-sm font-weight-300">
                    <span><?php the_date('F j, Y'); ?> at <?php the_time('g:i a'); ?></span>
                </p>
                <p class="text-gray-600 text-sm leading-7 mb-6 mt-2">
                    <?php the_excerpt(); ?>
                </p>
            </div>
        </div>
    <?php
        endwhile;
    else :
        echo "<p class='text-center text-gray-500'>No posts found.</p>";
    endif;

    wp_die();
}

add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');
// add extra custom fields for blog details 
function add_custom_post_fields() {
    add_meta_box(
        'custom_post_fields', 
        'Extra Post Details', 
        'render_custom_post_fields', 
        'post', 
        'normal', 
        'high'
    );
}
add_action('add_meta_boxes', 'add_custom_post_fields');

function render_custom_post_fields($post) {
    $hero_image_id = get_post_meta($post->ID, 'hero_image', true);
    $hero_image_url = $hero_image_id ? wp_get_attachment_url($hero_image_id) : '';
    $selected_trips = get_post_meta($post->ID, 'selected_trips', true) ?: [];
    $trips = get_posts([
        'post_type'   => 'add_trip', // Custom post type for trips
        'numberposts' => -1
    ]);
    $sections = get_post_meta($post->ID, 'post_sections', true) ?: [];

    wp_nonce_field('save_custom_post_fields', 'custom_post_fields_nonce');
    ?>
<div class = "fields-container">


    <p>
        <label for="hero_image">Hero Image:</label>
        <input type="hidden" id="hero_image" name="hero_image" value="<?php echo esc_attr($hero_image_id); ?>" />
        <button type="button" class="upload-hero-image button">Upload Image</button>
        <div class="hero-preview">
            <?php if ($hero_image_url) : ?>
                <img src="<?php echo esc_url($hero_image_url); ?>" style="max-width: 100%; height: auto; margin-top: 10px;">
            <?php endif; ?>
        </div>
    </p>
    <h3>Select Related Trips</h3>
    <div>
        <?php if (!empty($trips)) : ?>
            <?php foreach ($trips as $trip) : ?>
                <label>
                    <input type="checkbox" name="selected_trips[]" value="<?php echo $trip->ID; ?>" 
                        <?php checked(in_array($trip->ID, (array)$selected_trips)); ?> />
                    <?php echo esc_html($trip->post_title); ?>
                </label><br>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No trips available.</p>
        <?php endif; ?>
    </div>

    <h3>Sections</h3>
    <div id="sections-container">
        <?php if (!empty($sections)) :
            foreach ($sections as $index => $section) :
                $image_id = $section['image'] ?? '';
                $image_url = $image_id ? wp_get_attachment_url($image_id) : '';
        ?>
                <div class="section-group">
                <label >Header:</label>
                    <input type="text" name="post_sections[<?php echo $index; ?>][heading]" placeholder="Heading" value="<?php echo esc_attr($section['heading']); ?>" class="widefat" />
                    <label >Image:</label>
                    <input type="hidden" name="post_sections[<?php echo $index; ?>][image]" class="image-id" value="<?php echo esc_attr($image_id); ?>" />
                    <button type="button" class="upload-section-image button">Upload Image</button>
                    <div class="image-preview">
                        <?php if ($image_url) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" style="max-width: 100%; height: auto; margin-top: 10px;">
                        <?php endif; ?>
                    </div>
                    <label >Description:</label>
                    <textarea name="post_sections[<?php echo $index; ?>][description]" placeholder="Description" class="widefat"><?php echo esc_textarea($section['description']); ?></textarea>
                    <button type="button" class="remove-section ">Remove</button>
                </div>
        <?php endforeach;
        endif; ?>
    </div>

    <button type="button" id="add-section">Add Section</button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupMediaUploader(button, inputField, previewContainer) {
                button.addEventListener('click', function() {
                    let frame = wp.media({
                        title: 'Select or Upload Image',
                        button: { text: 'Use this image' },
                        multiple: false
                    });

                    frame.on('select', function() {
                        let attachment = frame.state().get('selection').first().toJSON();
                        inputField.value = attachment.id;
                        previewContainer.innerHTML = `<img src="${attachment.url}" style="max-width: 100%; height: auto; margin-top: 10px;">`;
                    });

                    frame.open();
                });
            }

            let heroButton = document.querySelector('.upload-hero-image');
            let heroInput = document.getElementById('hero_image');
            let heroPreview = document.querySelector('.hero-preview');
            setupMediaUploader(heroButton, heroInput, heroPreview);

            let sectionContainer = document.getElementById('sections-container');
            let addSectionBtn = document.getElementById('add-section');

            addSectionBtn.addEventListener('click', function() {
                let index = sectionContainer.children.length;
                let sectionHTML = `
                    <div class="section-group">
                        <input type="text" name="post_sections[\${index}][heading]" placeholder="Heading" class="widefat" />
                        
                        <input type="hidden" name="post_sections[\${index}][image]" class="image-id" />
                        <button type="button" class="upload-section-image button">Upload Image</button>
                        <div class="image-preview"></div>

                        <textarea name="post_sections[\${index}][description]" placeholder="Description" class="widefat"></textarea>
                        <button type="button" class="remove-section">Remove</button>
                    </div>`;
                sectionContainer.insertAdjacentHTML('beforeend', sectionHTML);
                
                let newSection = sectionContainer.lastElementChild;
                setupMediaUploader(newSection.querySelector('.upload-section-image'), newSection.querySelector('.image-id'), newSection.querySelector('.image-preview'));
            });

            sectionContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-section')) {
                    e.target.parentElement.remove();
                }
            });

            document.querySelectorAll('.upload-section-image').forEach(button => {
                let input = button.previousElementSibling;
                let preview = button.nextElementSibling;
                setupMediaUploader(button, input, preview);
            });
        });
    </script>

    <style>
        .section-group {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
        }
        input[type="checkbox"]{
            width:20px !important;
            height:20px !important;
            border-radius:2px !important;
            transform:translateY(6px) ;
        }
        .remove-section {
            background: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 10px;
        }
    </style>
</div>
    <?php
}




function save_custom_post_fields($post_id) {
    if (!isset($_POST['custom_post_fields_nonce']) || !wp_verify_nonce($_POST['custom_post_fields_nonce'], 'save_custom_post_fields')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['hero_image'])) {
        update_post_meta($post_id, 'hero_image', intval($_POST['hero_image']));
    }

    if (isset($_POST['post_sections']) && is_array($_POST['post_sections'])) {
        $sections = [];
        foreach ($_POST['post_sections'] as $section) {
            $sections[] = [
                'heading' => sanitize_text_field($section['heading']),
                'image' => intval($section['image']),
                'description' => sanitize_textarea_field($section['description'])
            ];
        }
        update_post_meta($post_id, 'post_sections', $sections);
    }
    if (!isset($_POST['custom_post_fields_nonce']) || !wp_verify_nonce($_POST['custom_post_fields_nonce'], 'save_custom_post_fields')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save selected trips
    if (isset($_POST['selected_trips']) && is_array($_POST['selected_trips'])) {
        update_post_meta($post_id, 'selected_trips', array_map('intval', $_POST['selected_trips']));
    } else {
        delete_post_meta($post_id, 'selected_trips');
    }
}
add_action('save_post', 'save_custom_post_fields');


function create_destination_cpt() {
    register_post_type('destination',
        array(
            'labels'      => array(
                'name'          => __('Add Destinations From Here'),
                'singular_name' => __('Destination')
            ),
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-location-alt',
            'supports'    => array('title', 'editor', 'thumbnail')
        )
    );
}
add_action('init', 'create_destination_cpt');

function add_destination_meta_box() {
    add_meta_box(
        'destination_meta_box',
        __('Destination Details', 'textdomain'),
        'render_destination_meta_box',
        'destination',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_destination_meta_box');

function render_destination_meta_box($post) {
    wp_nonce_field('destination_meta_box_nonce', 'destination_meta_box_nonce');
    $hero_image = get_post_meta($post->ID, 'hero_image', true);
    $hero_desc = get_post_meta($post->ID, 'hero_desc', true);
    $top_destinations_header = get_post_meta($post->ID, 'top_destinations_header', true);
    $top_destinations_desc = get_post_meta($post->ID, 'top_destinations_desc', true);
    $top_destination = get_post_meta($post->ID, 'top_destination', true);
    $landmarks = get_post_meta(get_the_ID(), 'landmarks', true);
    $landmarks_header = get_post_meta(get_the_ID(), 'landmarks_header', true);
    $about_header = get_post_meta($post->ID, 'about_header', true);
    $about_description = get_post_meta($post->ID, 'about_description', true);
    $tourist_attractions_header = get_post_meta($post->ID, 'tourist_attractions_header', true);
    $tourist_attractions = get_post_meta($post->ID, 'tourist_attractions', true) ?: [];
    $gallery = get_post_meta($post->ID, 'destination_gallery', true) ?: [];
    $nearby_destinations = get_post_meta($post->ID, 'nearby_destinations', true) ?: [];
    $nearby_destinations_header = get_post_meta($post->ID, 'nearby_destinations_header', true);

    ?>
    <!-- Top Destinations Section -->
     <div>

     <!-- <div class = "fields-container">
    <h3>Top Destinations</h3>
    <p>
        <label>Section Header:</label>
        </p>
        <input type="text" name="top_destinations_header" value="<?php echo esc_attr($top_destinations_header); ?>" >
   
    <p>
        <label>Section Description:</label>
        </p>
        <textarea name="top_destinations_desc" rows="4" style="width:100%;"><?php echo esc_textarea($top_destinations_desc); ?></textarea>
   
    </div> -->

    
<h3>Top Destination</h3>
    <p>
        <label>
            <input type="checkbox" name="top_destination" value="1" <?php checked($top_destination, '1'); ?>> Mark as Top Destination
        </label>
    </p>

    <h3>Landmarks</h3>
<p>
    <label>Section Header:</label>
    <input type="text" name="landmarks_header" value="<?php echo esc_attr($landmarks_header); ?>" style="width:100%;">
</p>
<div id="landmarks">
    <?php foreach ($landmarks as $index => $landmark): ?>
        <div class="landmark-item">
            <input type="text" name="landmarks[<?php echo $index; ?>][caption]" value="<?php echo esc_attr($landmark['caption']); ?> " placeholder="Enter caption" class = "sm-inputs">
            <input type="hidden" name="landmarks[<?php echo $index; ?>][image]" value="<?php echo esc_attr($landmark['image']); ?>">
            <button type="button" class="upload-landmark-image button upload">Upload Image</button>
            <button type="button" class="remove-landmark button remove">Remove</button>
            <div class="landmark-preview">
                <?php if (!empty($landmark['image'])): ?>
                    <img src="<?php echo esc_url(wp_get_attachment_url($landmark['image'])); ?>" width="100">
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<button type="button" id="add-landmark" class="button">Add Landmark</button>


    <h3>Destination Gallery</h3>
    <div id="gallery-preview">
        <?php foreach ($gallery as $img_id): ?>
            <div class="gallery-item">
                <input type="hidden" name="destination_gallery[]" value="<?php echo esc_attr($img_id); ?>">
                <img src="<?php echo esc_url(wp_get_attachment_url($img_id)); ?>" width="100">
                <button type="button" class="remove-gallery-image button remove">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="upload-gallery" class="button upload">Upload Gallery Images</button>

   
<div class="fields-container">
<h3>Hero Section</h3>
    <p>
        <label>Hero Image:</label><br>
        <input type="hidden" id="hero_image" name="hero_image" value="<?php echo esc_attr($hero_image); ?>">
        <div id="hero-preview">
            <?php if ($hero_image): ?>
                <img src="<?php echo esc_url(wp_get_attachment_url($hero_image)); ?>" width="100">
            <?php endif; ?>
        </div>
        <button type="button" id="upload-hero-image" class="button upload">Upload Image</button>
        <button type="button" id="remove-hero-image" class="button remove">Remove</button>
     
    </p>
</div>

    <div class="fields-container">
    <h3>About Section</h3>
    <p>
        <label>About Header:</label>
        </p>
        <input type="text" name="about_header" value="<?php echo esc_attr($about_header); ?>" >
        <p>
        <label>About Description:</label>
        </p>
        <textarea name="about_description" rows="4" style="width:100%;"><?php echo esc_textarea($about_description); ?></textarea>
   
    </div>
  

    <div class="fields-container">
    <h3>Tourist Attractions</h3>
    <p>
        <label>Section Header:</label>
        </p>
        <input type="text" name="tourist_attractions_header" value="<?php echo esc_attr($tourist_attractions_header); ?>" style="width:100%;">
        <div id="tourist-attractions">
        <?php foreach ($tourist_attractions as $index => $attr): ?>
            <div class="attraction-item">
                <input type="text" name="tourist_attractions[<?php echo $index; ?>][caption]" value="<?php echo esc_attr($attr['caption']); ?>" placeholder="Enter caption">
                <input type="hidden" name="tourist_attractions[<?php echo $index; ?>][image]" value="<?php echo esc_attr($attr['image']); ?>">
                <button type="button" class="upload-attraction-image button upload">Upload Image</button>
                <button type="button" class="remove-attraction button remove">Remove</button>
                <div class="attraction-preview">
                    <?php if (!empty($attr['image'])): ?>
                        <img src="<?php echo esc_url(wp_get_attachment_url($attr['image'])); ?>" width="100">
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-attraction" class="button upload">Add Attraction</button>
    </div>

  
     <!--  Nearby Destinations Section -->
       <div class="fields-container">
       <h3>Nearby Destinations</h3>
    <p>
        <label for="nearby_destinations_header">Header:</label>
        </p>
        <input type="text" name="nearby_destinations_header" value="<?php echo esc_attr($nearby_destinations_header); ?>" placeholder="Enter header">
       </div>

    <!-- //  Fetch all available destinations -->
    <?php
wp_nonce_field('destination_meta_box_nonce', 'destination_meta_box_nonce');

// Get all available destinations
$args = array(
    'post_type'      => 'destination',
    'posts_per_page' => -1,
    'post_status'    => 'publish'
);
$destinations = get_posts($args);
$destination_ids = wp_list_pluck($destinations, 'ID'); // Get an array of existing destination IDs

// Get previously selected destinations
$selected_destinations = get_post_meta($post->ID, 'nearby_destinations', true);
if (!is_array($selected_destinations)) {
    $selected_destinations = [];
}

// Remove deleted destinations
$selected_destinations = array_filter($selected_destinations, function($dest_id) use ($destination_ids) {
    return in_array($dest_id, $destination_ids);
});

// Update post meta to remove non-existing destinations
update_post_meta($post->ID, 'nearby_destinations', $selected_destinations);
?>

<h3>Nearby Destinations</h3>
<p>Select nearby destinations:</p>

<div id="destination-checkboxes">
    <?php foreach ($destinations as $destination): ?>
        <label style="display:block;">
            <input type="checkbox" 
                name="nearby_destinations[]" 
                value="<?php echo esc_attr($destination->ID); ?>" 
                <?php echo in_array($destination->ID, $selected_destinations) ? 'checked' : ''; ?>
            >
            <?php echo esc_html($destination->post_title); ?>
        </label>
    <?php endforeach; ?>
</div>

<h4>Selected Destinations:</h4>
<div id="selected_destinations_box" style="border:1px solid #ddd; padding:10px; min-height:50px;" class="des-box">
    <?php 
    if (!empty($selected_destinations)) {
        foreach ($selected_destinations as $dest_id) {
            $post_title = get_the_title($dest_id);
            echo '<div class="selected-destination" data-id="' . esc_attr($dest_id) . '">' . esc_html($post_title) . '</div>';
        }
    } else {
        echo '<p>No destinations selected.</p>';
    }
    ?>
</div>



    <script>
        jQuery(document).ready(function($) {
            // Hero Image Upload
            $('#upload-hero-image').click(function(e) {
                e.preventDefault();
                var frame = wp.media({
                    title: 'Select or Upload Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#hero_image').val(attachment.id);
                    $('#hero-preview').html('<img src="' + attachment.url + '" width="100">');
                });

                frame.open();
            });

            $('#remove-hero-image').click(function() {
                $('#hero_image').val('');
                $('#hero-preview').html('');
            });


        //    landmarks 
        jQuery(document).ready(function($) {
    $('#add-landmark').click(function() {
        var index = $('#landmarks .landmark-item').length;
        var newLandmark = `
            <div class="landmark-item">
                <input type="text" name="landmarks[${index}][caption]" placeholder="Enter caption">
                <input type="hidden" name="landmarks[${index}][image]" value="">
                <button type="button" class="upload-landmark-image button">Upload Image</button>
                <button type="button" class="remove-landmark button">Remove</button>
                <div class="landmark-preview"></div>
            </div>
        `;
        $('#landmarks').append(newLandmark);
    });

    $(document).on('click', '.upload-landmark-image', function() {
        var button = $(this);
        var parent = button.closest('.landmark-item');
        var inputField = parent.find('input[type="hidden"]');
        var preview = parent.find('.landmark-preview');

        var frame = wp.media({
            title: 'Select an Image',
            button: { text: 'Use this image' },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            inputField.val(attachment.id);
            preview.html('<img src="' + attachment.url + '" width="100">');
        });

        frame.open();
    });

    $(document).on('click', '.remove-landmark', function() {
        $(this).closest('.landmark-item').remove();
    });
});


            // Add New Attraction
            $('#add-attraction').click(function() {
                var index = $('#tourist-attractions .attraction-item').length;
                var newAttraction = `
                    <div class="attraction-item">
                        <input type="text" name="tourist_attractions[${index}][caption]" placeholder="Enter caption">
                        <input type="hidden" name="tourist_attractions[${index}][image]" value="">
                        <button type="button" class="upload-attraction-image button">Upload Image</button>
                        <button type="button" class="remove-attraction button">Remove</button>
                        <div class="attraction-preview"></div>
                    </div>
                `;
                $('#tourist-attractions').append(newAttraction);
            });

            // Upload Image for Attractions
            $(document).on('click', '.upload-attraction-image', function() {
                var button = $(this);
                var parent = button.closest('.attraction-item');
                var inputField = parent.find('input[type="hidden"]');
                var preview = parent.find('.attraction-preview');

                var frame = wp.media({
                    title: 'Select an Image',
                    button: { text: 'Use this image' },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    inputField.val(attachment.id);
                    preview.html('<img src="' + attachment.url + '" width="100">');
                });

                frame.open();
            });

            // Remove Attraction
            $(document).on('click', '.remove-attraction', function() {
                $(this).closest('.attraction-item').remove();
            });

            // Upload Multiple Images for Gallery
            $('#upload-gallery').click(function(e) {
                e.preventDefault();
                var frame = wp.media({
                    title: 'Select Images',
                    button: { text: 'Add to Gallery' },
                    multiple: true
                });

                frame.on('select', function() {
                    var attachments = frame.state().get('selection').toJSON();
                    attachments.forEach(function(attachment) {
                        $('#gallery-preview').append(`
                            <div class="gallery-item">
                                <input type="hidden" name="destination_gallery[]" value="${attachment.id}">
                                <img src="${attachment.url}" width="100">
                                <button type="button" class="remove-gallery-image button">Remove</button>
                            </div>
                        `);
                    });
                });

                frame.open();
            });

            // Remove Image from Gallery
            $(document).on('click', '.remove-gallery-image', function() {
                $(this).closest('.gallery-item').remove();
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll("#destination-checkboxes input[type='checkbox']");
    const selectedBox = document.getElementById("selected_destinations_box");

    function updateSelectedBox() {
        selectedBox.innerHTML = "";
        let selectedOptions = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => ({ id: checkbox.value, text: checkbox.nextSibling.textContent.trim() }));

        if (selectedOptions.length === 0) {
            selectedBox.innerHTML = "<p>No destinations selected.</p>";
        } else {
            selectedOptions.forEach(option => {
                let div = document.createElement("div");
                div.classList.add("selected-destination");
                div.setAttribute("data-id", option.id);
                div.textContent = option.text;
                selectedBox.appendChild(div);
            });
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateSelectedBox);
    });

    // Auto remove deleted destinations from selected box
    function removeDeletedDestinations() {
        const selectedDestinations = document.querySelectorAll(".selected-destination");
        selectedDestinations.forEach(dest => {
            let id = dest.getAttribute("data-id");
            let checkbox = document.querySelector(`input[type="checkbox"][value="${id}"]`);
            if (!checkbox) {
                dest.remove();
            }
        });

        if (selectedBox.children.length === 0) {
            selectedBox.innerHTML = "<p>No destinations selected.</p>";
        }
    }

    // Run the cleanup function after DOM loads
    removeDeletedDestinations();
    updateSelectedBox(); // Initialize
});

        
    </script>

    <?php
}



function save_destination_meta_box($post_id) {
    if (!isset($_POST['destination_meta_box_nonce']) || !wp_verify_nonce($_POST['destination_meta_box_nonce'], 'destination_meta_box_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save Hero Image
    if (isset($_POST['hero_image'])) {
        update_post_meta($post_id, 'hero_image', sanitize_text_field($_POST['hero_image']));
    }

    // Save Hero Description
    if (isset($_POST['hero_desc'])) {
        update_post_meta($post_id, 'hero_desc', sanitize_textarea_field($_POST['hero_desc']));
    }

     // Save Top Destination info
    if (isset($_POST['top_destinations_header'])) {
        update_post_meta($post_id, 'top_destinations_header', sanitize_text_field($_POST['top_destinations_header']));
    }
    
    if (isset($_POST['top_destinations_desc'])) {
        update_post_meta($post_id, 'top_destinations_desc', sanitize_textarea_field($_POST['top_destinations_desc']));
    }

  // Save Top Destination Marker
  update_post_meta($post_id, 'top_destination', isset($_POST['top_destination']) ? '1' : '0');

  //Save landmarks
  if (isset($_POST['landmarks_header'])) {
    update_post_meta($post_id, 'landmarks_header', sanitize_text_field($_POST['landmarks_header']));
}
  if (isset($_POST['landmarks'])) {
    $landmarks = array_map(function($landmark) {
        return [
            'caption' => sanitize_text_field($landmark['caption']),
            'image'   => intval($landmark['image'])
        ];
    }, $_POST['landmarks']);
    update_post_meta($post_id, 'landmarks', $landmarks);
} else {
    delete_post_meta($post_id, 'landmarks');
}

  // Save About Section
  if (isset($_POST['about_header'])) {
      update_post_meta($post_id, 'about_header', sanitize_text_field($_POST['about_header']));
  }

  if (isset($_POST['about_description'])) {
      update_post_meta($post_id, 'about_description', sanitize_textarea_field($_POST['about_description']));
  }

  // Save Tourist Attractions Header
  if (isset($_POST['tourist_attractions_header'])) {
      update_post_meta($post_id, 'tourist_attractions_header', sanitize_text_field($_POST['tourist_attractions_header']));
  }

  // Save Tourist Attractions
  if (isset($_POST['tourist_attractions'])) {
      $attractions = [];
      foreach ($_POST['tourist_attractions'] as $attr) {
          $attractions[] = [
              'caption' => sanitize_text_field($attr['caption']),
              'image'   => sanitize_text_field($attr['image'])
          ];
      }
      update_post_meta($post_id, 'tourist_attractions', $attractions);
  } else {
      delete_post_meta($post_id, 'tourist_attractions'); // Remove if empty
  }

    // Save Destination Gallery (Multiple Images)
    if (isset($_POST['destination_gallery'])) {
        $gallery = array_map('sanitize_text_field', $_POST['destination_gallery']);
        update_post_meta($post_id, 'destination_gallery', $gallery);
    } else {
        delete_post_meta($post_id, 'destination_gallery'); // Remove if empty
    }
    // Save Nearby Destinations Header
    if (isset($_POST['nearby_destinations_header'])) {
        update_post_meta($post_id, 'nearby_destinations_header', sanitize_text_field($_POST['nearby_destinations_header']));
    }

 
    // Fetch existing selected destinations
    // Get previously saved destinations
$existing_destinations = get_post_meta($post_id, 'nearby_destinations', true);
if (!is_array($existing_destinations)) {
    $existing_destinations = [];
}

// Handle new selection
if (isset($_POST['nearby_destinations']) && is_array($_POST['nearby_destinations'])) {
    $new_selections = array_map('sanitize_text_field', $_POST['nearby_destinations']);
} else {
    $new_selections = []; // If nothing is selected, set it to an empty array
}

// Compare and update the meta field
if (empty($new_selections)) {
    delete_post_meta($post_id, 'nearby_destinations'); // Remove if empty
} else {
    update_post_meta($post_id, 'nearby_destinations', $new_selections);
}

    
}
add_action('save_post', 'save_destination_meta_box');


// 1. Register Custom Post Type for Tour Types
function register_tour_type_cpt() {
    $args = array(
        'label'             => 'Tour Types',
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'supports'          => array('title', 'editor', 'thumbnail'),
        'menu_icon'         => 'dashicons-palmtree',
       
    );
    register_post_type('tour_type', $args);
}
add_action('init', 'register_tour_type_cpt');

// 2. Add Meta Box for Tour Types
function add_tour_type_metabox() {
    add_meta_box(
        'tour_type_meta',
        'Tour Type Details',
        'render_tour_type_metabox',
        'tour_type',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_tour_type_metabox');

// function hide_add_new_tour_type_button() {
//     $count_posts = wp_count_posts('tour_type')->publish;
//     if ($count_posts >= 1) {
//         echo '<style>#wpbody-content .page-title-action { display: none !important; }</style>';
//     }
// }
// add_action('admin_head', 'hide_add_new_tour_type_button');

// 3. Render Meta Box Content
function render_tour_type_metabox($post) {
    $tour_types = get_post_meta($post->ID, 'tour_types', true) ?: [];
    wp_nonce_field('tour_type_nonce_action', 'tour_type_nonce');
    ?>
    <div id="tour-type-container">
        <button type="button" id="add-tour-type" class="button" style = "margin-bottom:16px;">Add Tour Type</button>
        <div id="tour-type-list">
            <?php foreach ($tour_types as $index => $tour) : ?>
                <div class="tour-type-item fields-container" style = "margin-bottom:16px;">
                    <input type="text" name="tour_types[<?php echo $index; ?>][name]" value="<?php echo esc_attr($tour['name']); ?>" placeholder="Tour Type Name">
                    <input type="hidden" class="tour-type-image" name="tour_types[<?php echo $index; ?>][image]" value="<?php echo esc_attr($tour['image']); ?>">
                    <img class="tour-type-preview" src="<?php echo esc_url($tour['image']); ?>" style="max-width: 100px; display: <?php echo $tour['image'] ? 'block' : 'none'; ?>;">
                    <button type="button" class="upload-tour-type-image button">Upload Image</button>
                    <button type="button" class="remove-tour-type button">Remove</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
    jQuery(document).ready(function($) {
        const container = $('#tour-type-list');
        $('#add-tour-type').on('click', function() {
            const index = container.children().length;
            const div = $(`
                <div class="tour-type-item">
                    <input type="text" name="tour_types[${index}][name]" placeholder="Tour Type Name">
                    <input type="hidden" class="tour-type-image" name="tour_types[${index}][image]">
                    <img class="tour-type-preview" src="" style="max-width: 100px; display: none;">
                    <button type="button" class="upload-tour-type-image button">Upload Image</button>
                    <button type="button" class="remove-tour-type button">Remove</button>
                </div>
            `);
            container.append(div);
        });
        
        container.on('click', '.remove-tour-type', function() {
            $(this).closest('.tour-type-item').remove();
        });
        
        container.on('click', '.upload-tour-type-image', function(e) {
            e.preventDefault();
            const button = $(this);
            const input = button.siblings('.tour-type-image');
            const preview = button.siblings('.tour-type-preview');
            const mediaUploader = wp.media({
                title: 'Choose an Image',
                button: { text: 'Select' },
                multiple: false
            }).on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                input.val(attachment.url);
                preview.attr('src', attachment.url).show();
            }).open();
        });
    });
    </script>
    <?php
}

// 4. Save Meta Box Data
function save_tour_type_meta($post_id) {
    if (!isset($_POST['tour_type_nonce']) || !wp_verify_nonce($_POST['tour_type_nonce'], 'tour_type_nonce_action')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['tour_types'])) {
        update_post_meta($post_id, 'tour_types', $_POST['tour_types']);
    } else {
        delete_post_meta($post_id, 'tour_types');
    }
}
add_action('save_post', 'save_tour_type_meta');

// Register Custom Post Type: Add Trip
function register_add_trip_post_type() {
    register_post_type('add_trip', array(
        'labels' => array(
            'name'          => __('Add Trips'),
            'singular_name' => __('Add Trip')
        ),
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-palmtree',
        'supports'      => array('title', 'editor', 'thumbnail'),
        'rewrite'     => array('slug' => 'trip'),
        
    ));
}
add_action('init', 'register_add_trip_post_type');

// Add Meta Boxes
function add_trip_meta_boxes() {
    add_meta_box('trip_basic_info', 'Basic Info', 'trip_basic_info_callback', 'add_trip', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_trip_meta_boxes');

// Callback Function for Basic Info Meta Box
function trip_basic_info_callback($post) {
    // Get existing values
    $trip_status   = get_post_meta($post->ID, 'trip_status', true);
    $trip_caption  = get_post_meta($post->ID, 'trip_caption', true);
    $trip_gallery = get_post_meta($post->ID, 'trip_gallery', true) ? : [];
    $destination   = get_post_meta($post->ID, 'trip_destination', true);
    $trip_price    = get_post_meta($post->ID, 'trip_price', true);
    $trip_rating   = get_post_meta($post->ID, 'trip_rating', true);
    $trip_discount = get_post_meta($post->ID, 'trip_discount', true);
    $trip_date =  get_post_meta($post->ID, 'trip_date', true);
    $trip_duration = get_post_meta($post->ID, 'trip_duration', true);
    $see_dates_btn_txt =  get_post_meta($post->ID, 'see_btn_txt', true);
    $see_dates_btn_link =  get_post_meta($post->ID, 'see_btn_link', true);
    $trip_style = get_post_meta($post->ID, 'trip_style', true);
    $book_now_link = get_post_meta($post->ID, 'book_now_link', true);
    $book_now_num = get_post_meta($post->ID, 'book_now_num', true);
   
    // Define Trip Style Options
    $trip_style_options = [
        'Adventure',
        'Culture',
        'Family',
        'Group tours',
        'Honey moon',
        'Nature',
        'Solo travelers'
    ];
    // Security nonce field
    wp_nonce_field('save_trip_meta_data_nonce', 'trip_meta_nonce');

    ?>
<div class = "fields-container" >


        <!-- Trip Style Dropdown -->
        <label for="trip_style"><strong>Trip Style:</strong></label>
    <select name="trip_style" id="trip_style" class="widefat">
        <option value="">-- Select Trip Style --</option>
        <?php foreach ($trip_style_options as $option) : ?>
            <option value="<?php echo esc_attr($option); ?>" <?php selected($trip_style, $option); ?>>
                <?php echo esc_html($option); ?>
            </option>
        <?php endforeach; ?>
    </select>

<select name="selected_tour_type">
    <option value="">Select Tour Type</option>
    <?php
    // Get the saved value for the selected tour type
    $saved_tour_type = get_post_meta(get_the_ID(), 'trip_tour_type', true);
    $saved_tour_type = trim($saved_tour_type); // Trim any extra spaces

    // Get all tour type posts
    $tour_types_query = new WP_Query(array(
        'post_type'      => 'tour_type',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ));

    if ($tour_types_query->have_posts()) {
        while ($tour_types_query->have_posts()) {
            $tour_types_query->the_post();
            $tour_type_id = get_the_ID();
            $tour_type_name = get_the_title();

            // Get stored meta field containing multiple tour types
            $stored_tour_types = get_post_meta($tour_type_id, 'tour_types', true);

            if (!empty($stored_tour_types) && is_array($stored_tour_types)) {
                foreach ($stored_tour_types as $tour) {
                    $tour_name = isset($tour['name']) ? trim(esc_html($tour['name'])) : '';

                    if (!empty($tour_name)) {
                        // Compare the saved value correctly
                        $selected = ($saved_tour_type === $tour_name) ? 'selected' : '';

                        echo '<option value="' . esc_attr($tour_name) . '" ' . $selected . '>' . esc_html($tour_name) . '</option>';
                    }
                }
            }
        }
    }
    wp_reset_postdata();
    ?>
</select>


    <label for="trip_status">Trip Status:</label>
    <input type="text" name="trip_status" value="<?php echo esc_attr($trip_status); ?>" class="widefat" />

    <label for="trip_caption">Trip Caption:</label>
    <textarea name="trip_caption" class="widefat"><?php echo esc_textarea($trip_caption); ?></textarea>

    <label for="trip_gallery">Trip Gallery:</label>
    <div id="trip_gallery_container">
    <input type="hidden" name="trip_gallery" id="trip_gallery" value="<?php echo esc_attr($trip_gallery); ?>" />
    <button type="button" class="button add_trip_gallery">Add Images</button>
    <div class="trip_gallery_preview">
    <?php
    if (!empty($trip_gallery)) {
        // Ensure $trip_gallery is a string before using explode
        $trip_gallery_string = is_array($trip_gallery) ? implode(',', $trip_gallery) : $trip_gallery;

        $gallery_ids = explode(',', $trip_gallery_string);
        
        foreach ($gallery_ids as $image_id) {
            echo '<div class="gallery-image gallery-container"  data-id="' . esc_attr($image_id) . '">';
            echo wp_get_attachment_image($image_id, 'thumbnail');
            echo '<button type="button" class="remove_trip_image button remove">Remove</button>';
            echo '</div>';
        }
    }
    ?>
</div></div>
<style>
    .trip_gallery_preview:empty {
    display: none;
}

</style>



    <label for="trip_destination">Destination:</label>
    <select name="trip_destination" class="widefat">
        <?php
        $destinations = get_posts(array('post_type' => 'destination', 'numberposts' => -1));
        foreach ($destinations as $dest) {
            echo '<option value="' . $dest->ID . '"' . selected($destination, $dest->ID, false) . '>' . $dest->post_title . '</option>';
        }
        ?>
    </select>

    <label for="trip_price">Price From:</label>
    <input type="number" name="trip_price" value="<?php echo esc_attr($trip_price); ?>" class="widefat" />

    <label for="trip_rating">Rating:</label>
    <input type="number" step="0.1" name="trip_rating" value="<?php echo esc_attr($trip_rating); ?>" class="widefat" />

    <label for="trip_discount">Discount %:</label>
    <input type="number" name="trip_discount" value="<?php echo esc_attr($trip_discount); ?>" class="widefat" />

    <label for="trip_discount">Date:</label>
    <input type="date" name="trip_date" id="trip_date" value="<?php echo esc_attr($trip_date); ?>" class="widefat"  >

    <label for="trip_duration">Trip Duration:</label>
    <input type="number" name="trip_duration" value="<?php echo esc_attr($trip_duration); ?>" class="widefat" />

    <label for="see_btn_txt">See dates and prices button text:</label>
    <input type="text" name="see_btn_txt" value="<?php echo esc_attr($see_dates_btn_txt); ?>" class="widefat" />

    <label for="see_btn_link">See dates and prices button link:</label>
    <input type="text" name="see_btn_link" value="<?php echo esc_attr($see_dates_btn_txt); ?>" class="widefat" />


    <!-- <label for="see_btn_txt">Page link for booking:</label>
    <input type="text" name="book_now_link" value="<?php echo esc_attr($book_now_link); ?>" class="widefat" />

    <label for="see_btn_link">Contact number for booking:</label>
    <input type="text" name="book_now_num" value="<?php echo esc_attr($book_now_num); ?>" class="widefat" /> -->
    </div>
    <?php
}

// Enqueue Scripts for Media Uploader
function enqueue_trip_gallery_script($hook) {
    global $post;
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        wp_enqueue_media();
        wp_enqueue_script('trip-gallery-js', get_template_directory_uri() . '/js/trip-gallery.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_trip_gallery_script');

// Save Trip Meta Box Data
function save_trip_meta_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['trip_meta_nonce']) || !wp_verify_nonce($_POST['trip_meta_nonce'], 'save_trip_meta_data_nonce')) {
        return;
    }

    // Check for autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save each field
    if (isset($_POST['trip_status'])) {
        update_post_meta($post_id, 'trip_status', sanitize_text_field($_POST['trip_status']));
    }
    if (isset($_POST['trip_caption'])) {
        update_post_meta($post_id, 'trip_caption', sanitize_textarea_field($_POST['trip_caption']));
    }
    // Update or delete the meta field
    if (isset($_POST['trip_gallery'])) {
        $trip_gallery = sanitize_text_field($_POST['trip_gallery']);
        update_post_meta($post_id, 'trip_gallery', $trip_gallery);
    } else {
        delete_post_meta($post_id, 'trip_gallery');
    }
    
    if (isset($_POST['trip_destination'])) {
        update_post_meta($post_id, 'trip_destination', intval($_POST['trip_destination']));
    }
    if (isset($_POST['trip_price'])) {
        update_post_meta($post_id, 'trip_price', floatval($_POST['trip_price']));
    }
    if (isset($_POST['trip_rating'])) {
        update_post_meta($post_id, 'trip_rating', floatval($_POST['trip_rating']));
    }
    if (isset($_POST['trip_discount'])) {
        update_post_meta($post_id, 'trip_discount', intval($_POST['trip_discount']));
    }
    if (isset($_POST['trip_date'])) {
        update_post_meta($post_id, 'trip_date', sanitize_text_field($_POST['trip_date']));
    }
    if (isset($_POST['trip_duration'])) {
        update_post_meta($post_id, 'trip_duration', sanitize_text_field($_POST['trip_duration']));
    }
    
    if (isset($_POST['see_btn_txt'])) {
        update_post_meta($post_id, 'see_btn_txt', sanitize_text_field($_POST['see_btn_txt']));
    }
    if (isset($_POST['see_btn_link'])) {
        update_post_meta($post_id, 'see_btn_link', sanitize_text_field($_POST['see_btn_link']));
    }
    if (isset($_POST['book_now_link'])) {
        update_post_meta($post_id, 'book_now_link', sanitize_text_field($_POST['book_now_link']));
    }
    if (isset($_POST['book_now_num'])) {
        update_post_meta($post_id, 'book_now_num', sanitize_text_field($_POST['book_now_num']));
    }
 
    if (isset($_POST['selected_tour_type'])) {
        update_post_meta($post_id, 'trip_tour_type', sanitize_text_field($_POST['selected_tour_type']));
    } else {
        delete_post_meta($post_id, 'trip_tour_type');
    }

     if (isset($_POST['trip_style'])) {
        update_post_meta($post_id, 'trip_style', intval($_POST['trip_style']));
    } else {
        delete_post_meta($post_id, 'trip_style');
    }
        // Save Note Section (Only one header & description)
        if (isset($_POST['note'])) {
            update_post_meta($post_id, 'note_header', sanitize_text_field($_POST['note']['header']));
            update_post_meta($post_id, 'note_description', sanitize_textarea_field($_POST['note']['description']));
        }
        
        
}
add_action('save_post_add_trip', 'save_trip_meta_data');

// Add Meta Boxes with Tabs for Trip Details
function add_trip_details_meta_boxes() {
    add_meta_box('trip_details_meta_box', 'Trip Details', 'trip_details_meta_box_callback', 'add_trip', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_trip_details_meta_boxes');

function trip_details_meta_box_callback($post) {
    // Retrieve stored values
    $overview_header    = get_post_meta($post->ID, 'overview_header', true);
    $overview_desc      = get_post_meta($post->ID, 'overview_desc', true);
    $trip_includes      = get_post_meta($post->ID, 'trip_includes', true) ?: [];
    $trip_highlights    = get_post_meta($post->ID, 'trip_highlights', true) ?: [];
    $itinerary_header   = get_post_meta($post->ID, 'itinerary_header', true);
    $itinerary_desc     = get_post_meta($post->ID, 'itinerary_desc', true);
    $map_iframe         = get_post_meta($post->ID, 'map_iframe', true);
    $days               = get_post_meta($post->ID, 'days', true) ?: [];
    // $activities         = get_post_meta($post->ID, 'activities', true) ?: [];
    $flight_details     = get_post_meta($post->ID, 'flight_details', true);
    $flight_header      = get_post_meta($post->ID, 'flight_header', true);
    $flight_description = get_post_meta($post->ID, 'flight_description', true);
    $airfare_header     = get_post_meta($post->ID, 'airfare_header', true);
    $airfare_info       = get_post_meta($post->ID, 'airfare_info', true) ?: [];

    // Security nonce
    wp_nonce_field('save_trip_details_meta_nonce', 'trip_meta_nonce');
    ?>
    
    <style>
        .trip-tabs { margin-top: 20px; }
        .trip-tab-nav { list-style: none; padding: 0; display: flex; border-bottom: 2px solid #ddd; }
        .trip-tab-nav li { margin-right: 10px; }
        .trip-tab-nav a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            background: #f7f7f7;
            border-radius: 5px 5px 0 0;
            color: #333;
        }
        .trip-tab-nav .active a { background: #0073aa; color: #fff; }
        .trip-tab-content .tab-pane { display: none; padding: 15px; border: 1px solid #ddd; border-top: none; }
        .trip-tab-content .active { display: block; }
    </style>

    <div class="trip-tabs">
        <ul class="trip-tab-nav">
            <li class="active"><a href="#overview">Overview</a></li>
            <li><a href="#itinerary">Itinerary</a></li>
            <li><a href="#flights">Flights</a></li>
            <li><a href="#prices">Prices</a></li>

        </ul>

        <div class="trip-tab-content fields-container">
            <!-- Overview Tab -->
            <div id="overview" class="tab-pane active">
                <label for="overview_header">Overview Header:</label>
                <input type="text" name="overview_header" value="<?php echo esc_attr($overview_header); ?>" class="widefat" />

                <label for="overview_desc">Overview Description:</label>
                <textarea name="overview_desc" class="widefat"><?php echo esc_textarea($overview_desc); ?></textarea>

                <label>What is the Trip Include:</label>
                <div id="trip-includes-list">
                    <?php if (!empty($trip_includes)) {
                        foreach ($trip_includes as $item) {
                            echo '<div><input type="text" name="trip_includes[]" value="' . esc_attr($item) . '" class="widefat"/><button type="button" class="remove-item">×</button></div>';
                        }
                    } ?>
                </div>
                <button type="button" id="add-include">Add Include</button>

                <label>What are the Trip Highlights:</label>
                <div id="trip-highlights-list">
                    <?php if (!empty($trip_highlights)) {
                        foreach ($trip_highlights as $highlight) {
                            echo '<div><input type="text" name="trip_highlights[]" value="' . esc_attr($highlight) . '" class="widefat"/><button type="button" class="remove-item">×</button></div>';
                        }
                    } ?>
                </div>
                <button type="button" id="add-highlight">Add Highlight</button>
            </div>

            <!-- Itinerary Tab -->
            <div id="itinerary" class="tab-pane">
        
                <label for="itinerary_header">Itinerary Header:</label>
                <input type="text" name="itinerary_header" value="<?php echo esc_attr($itinerary_header); ?>" class="widefat" />

                <label for="itinerary_desc">Itinerary Description:</label>
                <textarea name="itinerary_desc" class="widefat"><?php echo esc_textarea($itinerary_desc); ?></textarea>

                <label for="map_iframe">Google Map Embed Code:</label>
                <textarea name="map_iframe" class="widefat"><?php echo esc_textarea($map_iframe); ?></textarea>
                
                <label>Days Itinerary:</label>
<div id="days">
    <?php if (!empty($days)) {
        foreach (array_values($days) as $index => $day) { // Ensure correct indexing
    ?>
        <div class="day-item" id="day-item-<?php echo $index; ?>" data-day="<?php echo $index; ?>">
            <input type="text" name="days[<?php echo $index; ?>][header]" value="<?php echo esc_attr($day['header'] ?? ''); ?>" placeholder="Day Header" class="widefat" />
            <input type="text" name="days[<?php echo $index; ?>][title]" value="<?php echo esc_attr($day['title'] ?? ''); ?>" placeholder="Day Title" class="widefat" />
            <textarea name="days[<?php echo $index; ?>][description]" class="widefat"><?php echo esc_textarea($day['description'] ?? ''); ?></textarea>

            <input type="hidden" name="days[<?php echo $index; ?>][image]" value="<?php echo isset($day['image']) ? esc_attr($day['image']) : ''; ?>">
            <button type="button" class="upload-day-image button upload">Upload Image</button>
            <div class="day-image-preview">
                <?php if (!empty($day['image'])): ?>
                    <img src="<?php echo esc_url(wp_get_attachment_url($day['image'])); ?>" width="100">
                <?php endif; ?>
            </div>

            <label for="days[<?php echo $index; ?>][arrival_header]">Arrival on the Place (Header):</label>
            <input type="text" name="days[<?php echo $index; ?>][arrival_header]" value="<?php echo esc_attr($day['arrival_header'] ?? ''); ?>" class="widefat" />

            <label for="days[<?php echo $index; ?>][arrival_desc]">Arrival on the Place (Description):</label>
            <textarea name="days[<?php echo $index; ?>][arrival_desc]" class="widefat"><?php echo esc_textarea($day['arrival_desc'] ?? ''); ?></textarea>

            <label for="days[<?php echo $index; ?>][afternoon_header]">Afternoon (Header):</label>
            <input type="text" name="days[<?php echo $index; ?>][afternoon_header]" value="<?php echo esc_attr($day['afternoon_header'] ?? ''); ?>" class="widefat" />

            <label for="days[<?php echo $index; ?>][afternoon_desc]">Afternoon (Description):</label>
            <textarea name="days[<?php echo $index; ?>][afternoon_desc]" class="widefat"><?php echo esc_textarea($day['afternoon_desc'] ?? ''); ?></textarea>

            <label for="days[<?php echo $index; ?>][evening_header]">Evening (Header):</label>
            <input type="text" name="days[<?php echo $index; ?>][evening_header]" value="<?php echo esc_attr($day['evening_header'] ?? ''); ?>" class="widefat" />

            <label for="days[<?php echo $index; ?>][evening_desc]">Evening (Description):</label>
            <textarea name="days[<?php echo $index; ?>][evening_desc]" class="widefat"><?php echo esc_textarea($day['evening_desc'] ?? ''); ?></textarea>

            <label for="days[<?php echo $index; ?>][meals_header]">Included Meals (Header):</label>
            <input type="text" name="days[<?php echo $index; ?>][meals_header]" value="<?php echo esc_attr($day['meals_header'] ?? ''); ?>" class="widefat" />

            <label for="days[<?php echo $index; ?>][meals_desc]">Included Meals (Description):</label>
            <textarea name="days[<?php echo $index; ?>][meals_desc]" class="widefat"><?php echo esc_textarea($day['meals_desc'] ?? ''); ?></textarea>

            <label>Accommodation:</label>
               <!-- Accommodation Gallery -->
               <label>Accommodation Gallery:</label>
                <div class="accommodation-gallery">
                    <input type="hidden" name="days[<?php echo $index; ?>][accommodation][gallery]" value="<?php echo !empty($day['accommodation']['gallery']) ? esc_attr(implode(',', $day['accommodation']['gallery'])) : ''; ?>">
                    <button type="button" class="upload-accommodation-gallery button">Upload Images</button>
                    <div class="gallery-preview">
                        <?php if (!empty($day['accommodation']['gallery'])): ?>
                            <?php foreach ($day['accommodation']['gallery'] as $image_id): ?>
                                <div class="gallery-image">
                                    <img src="<?php echo esc_url(wp_get_attachment_url($image_id)); ?>" width="100">
                                    <button type="button" class="remove-gallery-image" data-id="<?php echo esc_attr($image_id); ?>">Remove</button>
                                </div>
                            <?php endforeach; ?>
                            <?php endif ?>
                            </div>
                            <label>Accommodation Title:</label>
            
                            <input type="text" name="days[<?php echo $index; ?>][accommodation][title]" value="<?php echo esc_attr($day['accommodation']['title'] ?? ''); ?>" placeholder="Accommodation Title" class="widefat" />
                            <label>Accommodation Description:</label>
            <textarea name="days[<?php echo $index; ?>][accommodation][description]" class="widefat" placeholder="Accommodation Description"><?php echo esc_textarea($day['accommodation']['description'] ?? ''); ?></textarea>
            <label>Accommodation Rate:</label>
            <input type="number" name="days[<?php echo $index; ?>][accommodation][rate]" value="<?php echo esc_attr($day['accommodation']['rate'] ?? ''); ?>" placeholder="Rating" class="widefat" />
         


                
            <label>Activities:</label>
            <div class="activities-list" id="activities-list-<?php echo $index; ?>">
                <?php if (!empty($day['activities'])) {
                    foreach ($day['activities'] as $activity_index => $activity) { ?>
                        <div class="activity-entry">
                        <input type="hidden" name="days[<?php echo $index; ?>][activities][<?php echo $activity_index; ?>][image]" value="<?php echo esc_attr($activity['image'] ?? ''); ?>">
                                <button type="button" class="upload-activity-image button">Upload Image</button>
                                <button type="button" class="remove-activity-image button">Remove</button>
                                <div class="activity-image-preview">
                                    <?php if (!empty($activity['image'])): ?>
                                        <img src="<?php echo esc_url(wp_get_attachment_url($activity['image'])); ?>" width="100">
                                        <?php endif  ?>
                                    </div>
                                    <input type="text" name="days[<?php echo $index; ?>][activities][<?php echo $activity_index; ?>][header]" value="<?php echo esc_attr($activity['header'] ?? ''); ?>" placeholder="Activity Header" class="widefat" />
                            <input type="text" name="days[<?php echo $index; ?>][activities][<?php echo $activity_index; ?>][title]" value="<?php echo esc_attr($activity['title'] ?? ''); ?>" placeholder="Activity Title" class="widefat" />
                            <input type="text" name="days[<?php echo $index; ?>][activities][<?php echo $activity_index; ?>][status]" value="<?php echo esc_attr($activity['status'] ?? ''); ?>" placeholder="Activity Status" class="widefat" />
                            <input type="text" name="days[<?php echo $index; ?>][activities][<?php echo $activity_index; ?>][price]" value="<?php echo esc_attr($activity['price'] ?? ''); ?>" placeholder="Activity Price" class="widefat" />
                            <textarea name="days[<?php echo $index; ?>][activities][<?php echo $activity_index; ?>][description]" class="widefat"><?php echo esc_textarea($activity['description'] ?? ''); ?></textarea>
                            <button type="button" class="remove-activity">Remove Activity</button>
                            <button type="button" class="add-activity">Add Activity</button>
                        </div>
                <?php } } ?>
         
            </div>
                                    </div>
        
            <button type="button" class="remove-day">Remove Day</button>
          
           
        </div>
    
    <?php } } ?>
    <button type="button" id="add-day" class="add-day">Add Day</button> 

                                    </div>  
                                   
                                             </div> 
                                    
                                    
                                    
            <!-- Flights Tab -->
            <div id="flights" class="tab-pane">
                <label for="flight_header">Flight Header:</label>
                <input type="text" name="flight_header" value="<?php echo esc_attr($flight_header); ?>" class="widefat" />

                <label for="flight_description">Flight Description:</label>
                <textarea name="flight_description" class="widefat"><?php echo esc_textarea($flight_description); ?></textarea>

                <label for="airfare_header">Airfare Header:</label>
                <input type="text" name="airfare_header" value="<?php echo esc_attr($airfare_header); ?>" class="widefat" />

                <label>Airfare Info:</label>
                <div id="airfare-info-list">
                    <?php if (!empty($airfare_info)) {
                        foreach ($airfare_info as $info) {
                            echo '<div><input type="text" name="airfare_info[]" value="' . esc_attr($info) . '" class="widefat"/><button type="button" class="remove-item">×</button></div>';
                        }
                    } ?>
                </div>
                <button type="button" id="add-airfare">Add Airfare Info</button>
            </div>

            <!-- Prices Tab -->
            <div id="prices" class="tab-pane">
    <h3>Trip Prices</h3>
    <table class="widefat">
        <thead>
            <tr>
                <th>Number of Adults</th>
                <th>Standard Accommodations</th>
                <th>Deluxe Accommodations</th>
                <th>Ultra Deluxe Accommodations</th>
                <th>Luxury Accommodations</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody id="price-table-body">
            <?php 
            $trip_prices = get_post_meta($post->ID, 'trip_prices', true) ?: [];
            if (!empty($trip_prices)) {
                foreach ($trip_prices as $index => $price) { ?>
                    <tr>
                        <td><input type="number" name="trip_prices[<?php echo $index; ?>][num_adults]" value="<?php echo esc_attr($price['num_adults'] ?? ''); ?>" /></td>
                        <td><input type="text" name="trip_prices[<?php echo $index; ?>][standard]" value="<?php echo esc_attr($price['standard'] ?? ''); ?>" /></td>
                        <td><input type="text" name="trip_prices[<?php echo $index; ?>][deluxe]" value="<?php echo esc_attr($price['deluxe'] ?? ''); ?>" /></td>
                        <td><input type="text" name="trip_prices[<?php echo $index; ?>][ultra_deluxe]" value="<?php echo esc_attr($price['ultra_deluxe'] ?? ''); ?>" /></td>
                        <td><input type="text" name="trip_prices[<?php echo $index; ?>][luxury]" value="<?php echo esc_attr($price['luxury'] ?? ''); ?>" /></td>
                        <td><button type="button" class="remove-price">×</button></td>
                    </tr>
                <?php }
            } ?>
        </tbody>
    </table>
    <button type="button" id="add-price">Add Price</button>

    <!-- About Prices Section -->
    <h3>About Prices</h3>
    <div id="about-prices-container">
        <?php 
        $about_prices = get_post_meta($post->ID, 'about_prices', true) ?: [];
        if (!empty($about_prices)) {
            foreach ($about_prices as $index => $about) { ?>
                <div class="about-price-item">
                    <input type="text" name="about_prices[<?php echo $index; ?>][header]" placeholder="Header" value="<?php echo esc_attr($about['header'] ?? ''); ?>" />
                    <textarea name="about_prices[<?php echo $index; ?>][description]" placeholder="Description"><?php echo esc_textarea($about['description'] ?? ''); ?></textarea>
                    <button type="button" class="remove-about-price">×</button>
                </div>
            <?php }
        } ?>
    </div>
    <button type="button" id="add-about-price">Add About Price</button>

    <!-- Privacy Policy Section -->
    <h3>Privacy Policy</h3>
    <div id="privacy-policy-container">
        <?php 
        $privacy_policy = get_post_meta($post->ID, 'privacy_policy', true) ?: [];
        if (!empty($privacy_policy)) {
            foreach ($privacy_policy as $index => $policy) { ?>
                <div class="privacy-policy-item">
                    <input type="text" name="privacy_policy[<?php echo $index; ?>][header]" placeholder="Header" value="<?php echo esc_attr($policy['header'] ?? ''); ?>" />
                    <textarea name="privacy_policy[<?php echo $index; ?>][description]" placeholder="Description"><?php echo esc_textarea($policy['description'] ?? ''); ?></textarea>
                    <button type="button" class="remove-privacy-policy">×</button>
                </div>
            <?php }
        } ?>
    </div>
    <button type="button" id="add-privacy-policy">Add Privacy Policy</button>

    <!-- Note Section -->
    <h3>Note</h3>
    <div>
        <input type="text" name="note[header]" placeholder="Header" value="<?php echo esc_attr(get_post_meta($post->ID, 'note_header', true) ?? ''); ?>" />
        <textarea name="note[description]" placeholder="Description"><?php echo esc_textarea(get_post_meta($post->ID, 'note_description', true) ?? ''); ?></textarea>
    </div>
</div>


    
    </div>
        
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Tab switching functionality
            document.querySelectorAll(".trip-tab-nav a").forEach(tab => {
                tab.addEventListener("click", function(e) {
                    e.preventDefault();

                    // Remove active class from all tabs and panes
                    document.querySelectorAll(".trip-tab-nav li").forEach(li => li.classList.remove("active"));
                    document.querySelectorAll(".trip-tab-content .tab-pane").forEach(pane => pane.classList.remove("active"));

                    // Add active class to clicked tab and corresponding pane
                    this.parentElement.classList.add("active");
                    document.querySelector(this.getAttribute("href")).classList.add("active");
                });
            });

            // Add/remove list items dynamically
            function addListItem(buttonId, listId, inputName) {
                document.getElementById(buttonId).addEventListener("click", function() {
                    let container = document.getElementById(listId);
                    let div = document.createElement("div");
                    div.innerHTML = '<input type="text" name="'+inputName+'[]" class="widefat"/> <button type="button" class="remove-item">×</button>';
                    container.appendChild(div);
                });
            }

            function removeListItem(event) {
                if (event.target.classList.contains("remove-item")) {
                    event.target.parentElement.remove();
                }
            }

            addListItem("add-include", "trip-includes-list", "trip_includes");
            addListItem("add-highlight", "trip-highlights-list", "trip_highlights");
            addListItem("add-airfare", "airfare-info-list", "airfare_info");
            document.addEventListener("click", removeListItem);
        });
    </script>
        <script>
       document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("add-day").addEventListener("click", function () {
        let container = document.getElementById("days");
        let index = container.children.length;

        let div = document.createElement("div");
        div.className = "day-item";
        div.setAttribute("data-day", index); // Set the day index

        div.innerHTML = `
            <input type="text" name="days[${index}][header]" placeholder="Day Header" class="widefat" />
            <input type="text" name="days[${index}][title]" placeholder="Day Title" class="widefat" />
            <textarea name="days[${index}][description]" class="widefat" placeholder="Day Description"></textarea>

            <label>Upload Image:</label>
            <input type="hidden" name="days[${index}][image]" value="">
            <button type="button" class="upload-day-image button upload">Upload Image</button>
            <div class="day-image-preview"></div>

            <label>Accommodation:</label>
               <label>Accommodation Gallery:</label>
            <div class="accommodation-gallery">
                <input type="hidden" name="days[${index}][accommodation][gallery]" value="" />
                <button type="button" class="upload-accommodation-gallery button">Upload Images</button>
                <div class="gallery-preview"></div>
            </div>
            <input type="text" name="days[${index}][accommodation][title]" placeholder="Accommodation Title" class="widefat" />
            <textarea name="days[${index}][accommodation][description]" class="widefat" placeholder="Accommodation Description"></textarea>
            <input type="number" name="days[${index}][accommodation][rate]" placeholder="Rating" class="widefat" />

            <div>
                <label for="days[${index}][arrival_header]">Arrival on the Place (Header):</label>
                <input type="text" name="days[${index}][arrival_header]" class="widefat" />

                <label for="days[${index}][arrival_desc]">Arrival on the Place (Description):</label>
                <textarea name="days[${index}][arrival_desc]" class="widefat"></textarea>

                <label for="days[${index}][afternoon_header]">Afternoon (Header):</label>
                <input type="text" name="days[${index}][afternoon_header]" class="widefat" />

                <label for="days[${index}][afternoon_desc]">Afternoon (Description):</label>
                <textarea name="days[${index}][afternoon_desc]" class="widefat"></textarea>

                <label for="days[${index}][evening_header]">Evening (Header):</label>
                <input type="text" name="days[${index}][evening_header]" class="widefat" />

                <label for="days[${index}][evening_desc]">Evening (Description):</label>
                <textarea name="days[${index}][evening_desc]" class="widefat"></textarea>

                <label for="days[${index}][meals_header]">Included Meals (Header):</label>
                <input type="text" name="days[${index}][meals_header]" class="widefat" />

                <label for="days[${index}][meals_desc]">Included Meals (Description):</label>
                <textarea name="days[${index}][meals_desc]" class="widefat"></textarea>
            </div>

            <div id="activities-list-${index}" class="activities-list"></div>
            <button type="button" class="add-activity" data-day="${index}">Add Activity</button>
            <button type="button" class="remove-day">Remove Day</button>
        `;

        container.appendChild(div);
    });

    // Event delegation for dynamically added "Add Activity" buttons
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("add-activity")) {
            let dayItem = event.target.closest(".day-item");
            let dayIndex = dayItem.getAttribute("data-day");

            if (dayIndex === null) {
                console.error("No activity list found for day", dayIndex);
                return;
            }

            let activitiesList = dayItem.querySelector(".activities-list");
            let activityIndex = activitiesList.querySelectorAll(".activity-entry").length;

            let newActivity = document.createElement("div");
            newActivity.classList.add("activity-entry");
            newActivity.innerHTML = `
                    <input type="hidden" name="days[${dayIndex}][activities][${activityIndex}][image]" value="">
            <button type="button" class="upload-activity-image button">Upload Image</button>
            <button type="button" class="remove-activity-image button">Remove</button>
            <div class="activity-image-preview"></div>
                 <input type="text" name="days[${dayIndex}][activities][${activityIndex}][header]" placeholder="Activity Header" class="widefat" />
                   <input type="text" name="days[${dayIndex}][activities][${activityIndex}][title]" placeholder="Activity Title" class="widefat" />
                <input type="text" name="days[${dayIndex}][activities][${activityIndex}][status]" placeholder="Status" class="widefat" />
               <input type="number" name="days[${dayIndex}][activities][${activityIndex}][price]" placeholder="Price" class="widefat" />
                <textarea name="days[${dayIndex}][activities][${activityIndex}][description]" class="widefat"></textarea>
               
                <button type="button" class="remove-activity">Remove Activity</button>
            `;

            activitiesList.appendChild(newActivity);
        }
    });

    // Remove Activity
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-activity")) {
            event.target.closest(".activity-entry").remove();
        }
    });

    // Remove Day Functionality
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-day")) {
            event.target.closest(".day-item").remove();
        }
    });
    // Upload Image Functionality (Fix jQuery dependency issue)
    jQuery(document).on('click', '.upload-day-image', function() {
        var button = jQuery(this);
        var parent = button.closest('.day-item');
        var inputField = parent.find('input[type="hidden"]');
        var preview = parent.find('.day-image-preview');

        var frame = wp.media({
            title: 'Select an Image',
            button: { text: 'Use this image' },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            inputField.val(attachment.id);
            preview.html('<img src="' + attachment.url + '" width="100">');
        });

        frame.open();
    });

 
});

document.addEventListener("DOMContentLoaded", function () {
// Upload Accommodation Gallery Images
document.addEventListener("click", function (e) {
        if (e.target.classList.contains("upload-accommodation-gallery")) {
            e.preventDefault();

            let button = e.target;
            let parent = button.closest(".accommodation-gallery");
            let inputField = parent.querySelector('input[type="hidden"]');
            let previewContainer = parent.querySelector(".gallery-preview");

            // Get existing image IDs from input field (if any)
            let existingIDs = inputField.value ? inputField.value.split(",").map(id => id.trim()) : [];

            let frame = wp.media({
                title: "Select Images",
                button: { text: "Use these images" },
                multiple: true,
            });

            frame.on("select", function () {
                let selection = frame.state().get("selection");

                selection.each(function (attachment) {
                    let imageID = attachment.id;

                    // Avoid duplicates
                    if (!existingIDs.includes(imageID.toString())) {
                        existingIDs.push(imageID.toString());

                        // Append Image Preview
                        let div = document.createElement("div");
                        div.className = "gallery-image";
                        div.innerHTML = `
                            <img src="${attachment.attributes.url}" width="100">
                            <button type="button" class="remove-gallery-image" data-id="${imageID}">Remove</button>
                        `;
                        previewContainer.appendChild(div);
                    }
                });

                // Store Image IDs in Hidden Input
                inputField.value = existingIDs.join(",");
            });

            frame.open();
        }
    });

    // Remove Gallery Image
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-gallery-image")) {
            let button = e.target;
            let parent = button.closest(".accommodation-gallery");
            let inputField = parent.querySelector('input[type="hidden"]');
            let imageID = button.getAttribute("data-id");

            // Remove the image from the preview
            button.closest(".gallery-image").remove();

            // Update the hidden input field
            let currentIDs = inputField.value.split(",").filter(id => id !== imageID);
            inputField.value = currentIDs.join(",");
        }
    });
});

    </script>

        <script>
    
    // Image Upload Logic
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("upload-activity-image")) {
            e.preventDefault();

            let button = e.target;
            let parent = button.closest(".activity-entry");
            let inputField = parent.querySelector('input[type="hidden"]');
            let preview = parent.querySelector(".activity-image-preview");

            let frame = wp.media({
                title: "Select an Image",
                button: { text: "Use this image" },
                multiple: false,
            });

            frame.on("select", function () {
                let attachment = frame.state().get("selection").first().toJSON();
                inputField.value = attachment.id; // Save image ID
                preview.innerHTML = `<img src="${attachment.url}" width="100">`; // Update preview
            });

            frame.open();
        }
    });

      // Upload Image Functionality (Fix jQuery dependency issue)
      jQuery(document).on('click', '.upload-day-image', function() {
        var button = jQuery(this);
        var parent = button.closest('.day-item');
        var inputField = parent.find('input[type="hidden"]');
        var preview = parent.find('.day-image-preview');

        var frame = wp.media({
            title: 'Select an Image',
            button: { text: 'Use this image' },
            multiple: false
        });

        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            inputField.val(attachment.id);
            preview.html('<img src="' + attachment.url + '" width="100">');
        });

        frame.open();
    });

 


    // Remove Image
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-activity-image")) {
            let parent = e.target.closest(".activity-entry");
            parent.querySelector('input[type="hidden"]').value = ""; // Clear hidden input
            parent.querySelector(".activity-image-preview").innerHTML = ""; // Clear preview
        }
    });

    // Remove Activity
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-activity")) {
            e.target.closest(".activity-entry").remove();
        }
    });


    </script>

<script>
jQuery(document).ready(function($) {
    $('#add-price').on('click', function() {
        var index = $('#price-table-body tr').length;
        var newRow = `
            <tr>
                <td><input type="number" name="trip_prices[${index}][num_adults]" /></td>
                <td><input type="text" name="trip_prices[${index}][standard]" /></td>
                <td><input type="text" name="trip_prices[${index}][deluxe]" /></td>
                <td><input type="text" name="trip_prices[${index}][ultra_deluxe]" /></td>
                <td><input type="text" name="trip_prices[${index}][luxury]" /></td>
                <td><button type="button" class="remove-price">×</button></td>
            </tr>
        `;
        $('#price-table-body').append(newRow);
    });

    $(document).on('click', '.remove-price', function() {
        $(this).closest('tr').remove();
    });
});
</script>
<script> 
document.addEventListener("DOMContentLoaded", function() {
    function addField(containerId, className, fieldName) {
        let container = document.getElementById(containerId);
        let index = container.children.length;
        let div = document.createElement("div");
        div.classList.add(className);
        div.innerHTML = `
            <input type="text" name="${fieldName}[${index}][header]" placeholder="Header" />
            <textarea name="${fieldName}[${index}][description]" placeholder="Description"></textarea>
            <button type="button" class="remove-field">×</button>
        `;
        container.appendChild(div);
    }

    function removeField(event) {
        if (event.target.classList.contains("remove-field")) {
            event.target.parentElement.remove();
        }
    }

    document.getElementById("add-about-price").addEventListener("click", function() {
        addField("about-prices-container", "about-price-item", "about_prices");
    });

    document.getElementById("add-privacy-policy").addEventListener("click", function() {
        addField("privacy-policy-container", "privacy-policy-item", "privacy_policy");
    });

    document.body.addEventListener("click", removeField);
});

</script>
    <?php
}

// Save Trip Details
function save_trip_details_meta($post_id) {
    if (!isset($_POST['trip_meta_nonce']) || !wp_verify_nonce($_POST['trip_meta_nonce'], 'save_trip_details_meta_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
     // Save each field
     if (isset($_POST['trip_status'])) {
        update_post_meta($post_id, 'trip_status', sanitize_text_field($_POST['trip_status']));
    }
    if (isset($_POST['trip_caption'])) {
        update_post_meta($post_id, 'trip_caption', sanitize_textarea_field($_POST['trip_caption']));
    }
    // Update or delete the meta field
    if (isset($_POST['trip_gallery'])) {
        $trip_gallery = sanitize_text_field($_POST['trip_gallery']);
        update_post_meta($post_id, 'trip_gallery', $trip_gallery);
    } else {
        delete_post_meta($post_id, 'trip_gallery');
    }
    
    
    
    
    if (isset($_POST['trip_destination'])) {
        update_post_meta($post_id, 'trip_destination', intval($_POST['trip_destination']));
    }
    if (isset($_POST['trip_price'])) {
        update_post_meta($post_id, 'trip_price', floatval($_POST['trip_price']));
    }
    if (isset($_POST['trip_rating'])) {
        update_post_meta($post_id, 'trip_rating', floatval($_POST['trip_rating']));
    }
    if (isset($_POST['trip_discount'])) {
        update_post_meta($post_id, 'trip_discount', intval($_POST['trip_discount']));
    }
    if (isset($_POST['trip_date'])) {
        update_post_meta($post_id, 'trip_date', sanitize_text_field($_POST['trip_date']));
    }
    if (isset($_POST['trip_duration'])) {
        update_post_meta($post_id, 'trip_duration', sanitize_text_field($_POST['trip_duration']));
    }
    if (isset($_POST['see_btn_txt'])) {
        update_post_meta($post_id, 'see_btn_txt', sanitize_text_field($_POST['see_btn_txt']));
    }
    if (isset($_POST['see_btn_link'])) {
        update_post_meta($post_id, 'see_btn_link', sanitize_text_field($_POST['see_btn_link']));
    }
    if (isset($_POST['book_now_link'])) {
        update_post_meta($post_id, 'book_now_link', sanitize_text_field($_POST['book_now_link']));
    }
    if (isset($_POST['book_now_num'])) {
        update_post_meta($post_id, 'book_now_num', sanitize_text_field($_POST['book_now_num']));
    }
    if (isset($_POST['trip_style'])) {
        update_post_meta($post_id, 'trip_style', sanitize_text_field($_POST['trip_style']));
    } else {
        delete_post_meta($post_id, 'trip_style');
    }
 
    if (isset($_POST['selected_tour_type'])) {
        update_post_meta($post_id, 'trip_tour_type', sanitize_text_field($_POST['selected_tour_type']));
    } else {
        delete_post_meta($post_id, 'trip_tour_type');
    }
     // Save Overview Details
     if (isset($_POST['overview_header'])) {
        update_post_meta($post_id, 'overview_header', sanitize_text_field($_POST['overview_header']));
    }
    if (isset($_POST['overview_desc'])) {
        update_post_meta($post_id, 'overview_desc', sanitize_textarea_field($_POST['overview_desc']));
    }
    if (isset($_POST['trip_includes'])) {
        update_post_meta($post_id, 'trip_includes', array_map('sanitize_text_field', $_POST['trip_includes']));
    }
    if (isset($_POST['trip_highlights'])) {
        update_post_meta($post_id, 'trip_highlights', array_map('sanitize_text_field', $_POST['trip_highlights']));
    }
    // Save itinerary 
    if (isset($_POST['itinerary_header'])) {
        update_post_meta($post_id, 'itinerary_header', sanitize_text_field($_POST['itinerary_header']));
    }
    if (isset($_POST['itinerary_desc'])) {
        update_post_meta($post_id, 'itinerary_desc', sanitize_text_field($_POST['itinerary_desc']));
    }
    if (isset($_POST['map_iframe'])) {
        update_post_meta($post_id, 'map_iframe', sanitize_text_field($_POST['map_iframe']));
    }
    if (isset($_POST['activities'])) {
        update_post_meta($post_id, 'days', array_map('sanitize_text_field', $_POST['days']));
    }
    if (isset($_POST['days'])) {
        $days = array_map(function ($day) {
            return [
                'header'       => sanitize_text_field($day['header'] ?? ''),
                'title'        => sanitize_text_field($day['title'] ?? ''),
                'description'  => sanitize_textarea_field($day['description'] ?? ''),
                'image'        => intval($day['image'] ?? 0),
    
                // Directly save these fields instead of nesting them
                'arrival_header'   => sanitize_text_field($day['arrival_header'] ?? ''),
                'arrival_desc'     => sanitize_textarea_field($day['arrival_desc'] ?? ''),
    
                'afternoon_header' => sanitize_text_field($day['afternoon_header'] ?? ''),
                'afternoon_desc'   => sanitize_textarea_field($day['afternoon_desc'] ?? ''),
    
                'evening_header'   => sanitize_text_field($day['evening_header'] ?? ''),
                'evening_desc'     => sanitize_textarea_field($day['evening_desc'] ?? ''),
    
                'meals_header'     => sanitize_text_field($day['meals_header'] ?? ''),
                'meals_desc'       => sanitize_textarea_field($day['meals_desc'] ?? ''),
    
                // Accommodation
                'accommodation' => [
                    'title'       => sanitize_text_field($day['accommodation']['title'] ?? ''),
                    'description' => sanitize_textarea_field($day['accommodation']['description'] ?? ''),
                    'rate'        => isset($day['accommodation']['rate']) ? intval($day['accommodation']['rate']) : null,
                    'gallery'     => isset($day['accommodation']['gallery']) 
                        ? array_map('intval', explode(',', $day['accommodation']['gallery'])) 
                        : []
                ],
                
                            // Activities
            'activities' => isset($day['activities']) ? array_map(function ($activity) {
                return [
                    'header' => sanitize_text_field($activity['header'] ?? ''),
                    'status' => sanitize_text_field($activity['status'] ?? ''),
                    'title'  => sanitize_text_field($activity['title'] ?? ''),
                    'description' => sanitize_textarea_field($activity['description'] ?? ''),
                    'image'  => intval($activity['image'] ?? 0),
                    'price'  => sanitize_text_field($activity['price'] ?? '')
                ];
            }, $day['activities']) : []
        ];

      
        }, $_POST['days']);
    
        update_post_meta($post_id, 'days', $days);
    } else {
        delete_post_meta($post_id, 'days');
    }
    if (isset($day['accommodation']['gallery'])) {
        $existing_gallery = get_post_meta($post_id, "days_{$index}_accommodation_gallery", true);
        $new_gallery = explode(',', $day['accommodation']['gallery']);
    
        // Merge and remove duplicates
        $merged_gallery = array_unique(array_merge((array) $existing_gallery, $new_gallery));
    
        update_post_meta($post_id, "days_{$index}_accommodation_gallery", $merged_gallery);
    }
    

    if (isset($_POST['trip_prices'])) {
        $trip_prices = array_map(function ($price) {
            return [
                'num_adults'   => isset($price['num_adults']) ? intval($price['num_adults']) : 0,
                'standard'     => isset($price['standard']) ? sanitize_text_field($price['standard']) : '',
                'deluxe'       => isset($price['deluxe']) ? sanitize_text_field($price['deluxe']) : '',
                'ultra_deluxe' => isset($price['ultra_deluxe']) ? sanitize_text_field($price['ultra_deluxe']) : '',
                'luxury'       => isset($price['luxury']) ? sanitize_text_field($price['luxury']) : '',
            ];
        }, $_POST['trip_prices']);
    
        update_post_meta($post_id, 'trip_prices', $trip_prices);
    } else {
        delete_post_meta($post_id, 'trip_prices');
    }
    
    // Save About Prices
    if (isset($_POST['about_prices'])) {
        $about_prices = array_map(function ($about) {
            return [
                'header'       => isset($about['header']) ? sanitize_text_field($about['header']) : '',
                'description'  => isset($about['description']) ? sanitize_textarea_field($about['description']) : '',
            ];
        }, $_POST['about_prices']);
    
        update_post_meta($post_id, 'about_prices', $about_prices);
    } else {
        delete_post_meta($post_id, 'about_prices');
    }
    
    // Save Privacy Policy
    if (isset($_POST['privacy_policy'])) {
        $privacy_policy = array_map(function ($policy) {
            return [
                'header'       => isset($policy['header']) ? sanitize_text_field($policy['header']) : '',
                'description'  => isset($policy['description']) ? sanitize_textarea_field($policy['description']) : '',
            ];
        }, $_POST['privacy_policy']);
    
        update_post_meta($post_id, 'privacy_policy', $privacy_policy);
    } else {
        delete_post_meta($post_id, 'privacy_policy');
    }
    
    // Save Note Section (Only one header & description)
    if (isset($_POST['note'])) {
        update_post_meta($post_id, 'note_header', sanitize_text_field($_POST['note']['header']));
        update_post_meta($post_id, 'note_description', sanitize_textarea_field($_POST['note']['description']));
    }
    
    
    
     // Save Flights Details
    update_post_meta($post_id, 'flight_header', sanitize_text_field($_POST['flight_header'] ?? ''));
    update_post_meta($post_id, 'flight_description', sanitize_textarea_field($_POST['flight_description'] ?? ''));
    update_post_meta($post_id, 'airfare_header', sanitize_text_field($_POST['airfare_header'] ?? ''));
    update_post_meta($post_id, 'airfare_info', array_map('sanitize_text_field', $_POST['airfare_info'] ?? []));
}

add_action('save_post_add_trip', 'save_trip_details_meta');

function custom_admin_styles() {
    echo '
    <style>
       body.wp-admin {
            background:#F0F7F7;
;

        }
        #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
            background-color: #06414A !important; 
            width: 250px !important;
        }

        #wpcontent, #wpfooter {
            margin-left: 250px !important;
        }
    </style>
    ';
}
add_action("admin_head", "custom_admin_styles");

function custom_admin_toolbar_styles() { ?>
    <style>
        #wpadminbar {
            background-color: #06414A !important;
        }
    </style>
<?php }
add_action('admin_head', 'custom_admin_toolbar_styles');

function custom_login_logo() { ?>
    <style>
        .login h1 a {
            background-image:url('<?php echo get_template_directory_uri(); ?>/images/logo_fotr.png') !important; /* Replace with your logo URL */
            background-size: contain !important;
            width: 100% !important;
            height: 80px !important;
        }
        /* Set the background color of the entire login page */
body.login {
    background: linear-gradient(180deg, #276C76 16.67%, #BAD0B4 100%);

}

/* Style the login form container */
#login {
    background:#276C76; /* White background */
    padding: 20px;
    border-radius: 20px; /* Rounded corners */
    border:none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Subtle drop shadow */
    width:430px;

    margin: 120px auto !important;
}
@media(max-width:992px){
    #login {

    width:320px !important;
 
    
    margin: 120px auto !important;
} 
}
#login label , #login p  , #login .backtoblog , #login a{
    color: #fff !important;
}
#loginform , .login form{
    background: transparent !important; 
    border:none !important;
    
}
.login .button.wp-hide-pw .dashicons {
    color: #06414A;
}
/* Style the input fields */
#loginform input[type="text"],
#loginform input[type="password"] {
    border-radius: 8px; /* Rounded corners for inputs */
    border: 1px solid #ccc;
    
}
.login .message, .login .notice, .login .success{
    background:transparent !important;
    border-left: 4px solid #C8E677 !important;
    box-shadow: none !important;
}

/* Style the login button */
#wp-submit {
    background-color: #C8E677 ; 
    color: #06414A;
    border-radius: 8px;
    transition:0.5s all ;
    border: none;
    min-width:140px;
    min-height:10px !important;
    font-weight:700;
    font-size:16px;
}

#wp-submit:hover {
  opacity:0.7;
}
    </style>
<?php }
add_action('login_head', 'custom_login_logo');

function custom_admin_logo() { ?>
    <style>
        #wp-admin-bar-wp-logo > .ab-item .ab-icon {
            background-image: url('<?php echo get_template_directory_uri(); ?>/images/logo_fotr.png') !important;
            background-size: contain !important;
        }
        
    </style>
<?php }
add_action('admin_head', 'custom_admin_logo');

function custom_admin_logo() { ?>
    <style>
        #wp-admin-bar-wp-logo > .ab-item .ab-icon {
            background-image: url('<?php echo get_template_directory_uri(); ?>/images/logo_fotr.png') !important;
            background-size: contain !important;
        }
        
    </style>
<?php }
add_action('admin_head', 'custom_admin_logo');

function custom_styles() { ?>
    <style>
     .fields-container  input ,  .fields-container textarea  , .fields-container select {
    border: 1px solid #ccc !important;
    border-radius: 8px !important;
    outline: none !important;
    width:90% !important;
    margin-bottom: 16px !important;
    padding: 4px !important;
    
}
.fields-container label {
    display:block;
    font-weight:700;
    font-size:16px;
    margin-bottom:10px;
}
  .sm-inputs{
    border: 1px solid #ccc !important;
    border-radius: 4px !important;
    outline: none !important;
    width:40% !important;
    margin-bottom: 16px !important;
    padding: 4px !important;
    
}
.fields-container button {
    margin-bottom:16px !important;
}
.upload{
    /* background-color:#276C76 !important; */
    /* color:#fff !important ; */
}
.remove {
    /* background-color: #FF0000 !important; */
    /* color:#fff !important ; */
}
.upload , .remove{
    border:none !important;
    min-width: 100px !important;
    padding:4px !important;
}
.remove.sm-rm-btn{
    min-width: 60px !important;
}
.fields-container img {
    width:90px !important;
    height:90px !important;
    object-fit:cover !important;
}
.gallery-container{
    display:flex !important;
    gap:8px !important;
}
.fields-container img , .gallery-container img{
    width:90px !important;
    height:90px !important;
    object-fit:cover !important;
    border-radius:8px !important;
    margin-bottom:10px !important;
}
.des-box {
    display:flex;
    gap:10px;
}
.selected-destination {
    border-radius: 4px !important;
    padding: 8px 12px !important;
    color:#276C76 !important;
    background-color: #C8E677 !important;
    font-weight:bold;
    height:20px;
    font-size:14px;
    margin-bottom:10px;

}
/* #wpadminbar {
    display: none !important;
} */
    </style>
<?php }
add_action('admin_head', 'custom_styles');


function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'remove_wp_logo', 999);

function fix_admin_bar_visibility() {
    if (is_admin_bar_showing()) {
        echo '<style>#wpadminbar { display: none !important; }</style>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function () {
                    setTimeout(function () {
                        let adminBar = document.getElementById("wpadminbar");
                        if (adminBar) {
                            adminBar.style.setProperty("display", "block", "important");
                        }
                    }, 100);
                });
              </script>';
    }
}
add_action('wp_head', 'fix_admin_bar_visibility');


function use_custom_trip_template($single) {
    global $post;

    if ($post->post_type == 'add_trip') {
        if (file_exists(get_template_directory() . '/single-trip.php')) {
            return get_template_directory() . '/single-trip.php';
        }
    }
    return $single;
}
add_filter('single_template', 'use_custom_trip_template');



// FILTER MAHMOUD
function filter_trips() {
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : (get_query_var('paged') ? get_query_var('paged') : 1);

    $args = array(
        'post_type'      => 'add_trip', // Ensure we're only fetching trips
        'posts_per_page' => 4,
        'paged'          => $paged,
        'post_status'    => 'publish',
        'meta_query'     => array(),
    );

    // إضافة البحث بالعنوان - جديد
    if (!empty($_POST['trip_search']) || !empty($_GET['trip_search'])) {
        $search_term = !empty($_POST['trip_search']) ? sanitize_text_field($_POST['trip_search']) : sanitize_text_field($_GET['trip_search']);
        $args['s'] = $search_term;
    }

    // فلتر الوجهة
// فلتر الوجهة
if (!empty($_POST['destination'])) {
    $args['meta_query'][] = array(
        'key'     => 'trip_destination',
        'value'   => $_POST['destination'],
        'compare' => 'IN',
    );
} elseif (!empty($_GET['destination_filter'])) {
    $destination_slug = sanitize_text_field($_GET['destination_filter']);
    
    // البحث عن الوجهة باستخدام slug
    $destination_args = array(
        'post_type'      => 'destination',
        'name'           => $destination_slug, // بنبحث بالـ slug
        'posts_per_page' => 1,
        'post_status'    => 'publish',
    );
    
    $destination_query = new WP_Query($destination_args);
    
    if ($destination_query->have_posts()) {
        $destination_query->the_post();
        $destination_id = get_the_ID();
        wp_reset_postdata();
        
        $args['meta_query'][] = array(
            'key'     => 'trip_destination',
            'value'   => $destination_id,
            'compare' => '=',
        );
    }
}

    // فلتر نوع الرحلة
    if (!empty($_POST['trip_style'])) {
        $args['meta_query'][] = array(
            'key'     => 'trip_style',
            'value'   => $_POST['trip_style'],
            'compare' => 'IN',
        );
    } elseif (!empty($_GET['trip_style'])) {
        $args['meta_query'][] = array(
            'key'     => 'trip_style',
            'value'   => $_GET['trip_style'],
            'compare' => 'IN',
        );
    }

    // فلتر المدة
    $duration_values = !empty($_POST['duration']) ? $_POST['duration'] : (!empty($_GET['duration']) ? $_GET['duration'] : '');
    if (!empty($duration_values)) {
        $duration_query = array('relation' => 'OR');
        
        // التعامل مع المدة سواء كانت سلسلة أو مصفوفة
        $duration_array = is_array($duration_values) ? $duration_values : array($duration_values);
        
        foreach ($duration_array as $duration) {
            switch ($duration) {
                case 'less_10':
                    $duration_query[] = array(
                        'key' => 'trip_duration',
                        'value' => 10,
                        'compare' => '<',
                        'type' => 'NUMERIC'
                    );
                    break;
                case '10_20':
                    $duration_query[] = array(
                        'key' => 'trip_duration',
                        'value' => array(10, 20),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    );
                    break;
                case '20_30':
                    $duration_query[] = array(
                        'key' => 'trip_duration',
                        'value' => array(20, 30),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    );
                    break;
                case 'more_30':
                    $duration_query[] = array(
                        'key' => 'trip_duration',
                        'value' => 30,
                        'compare' => '>',
                        'type' => 'NUMERIC'
                    );
                    break;
            }
        }
        $args['meta_query'][] = $duration_query;
    }

    // فلتر السعر
    $price_values = !empty($_POST['price']) ? $_POST['price'] : (!empty($_GET['price']) ? $_GET['price'] : '');
    if (!empty($price_values)) {
        $price_query = array('relation' => 'OR');
        
        // التعامل مع السعر سواء كان سلسلة أو مصفوفة
        $price_array = is_array($price_values) ? $price_values : array($price_values);
        
        foreach ($price_array as $price) {
            switch ($price) {
                case 'less_100':
                    $price_query[] = array(
                        'key' => 'trip_price',
                        'value' => 100,
                        'compare' => '<',
                        'type' => 'NUMERIC'
                    );
                    break;
                case '100_300':
                    $price_query[] = array(
                        'key' => 'trip_price',
                        'value' => array(100, 300),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    );
                    break;
                case '300_500':
                    $price_query[] = array(
                        'key' => 'trip_price',
                        'value' => array(300, 500),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    );
                    break;
                case 'more_500':
                    $price_query[] = array(
                        'key' => 'trip_price',
                        'value' => 500,
                        'compare' => '>',
                        'type' => 'NUMERIC'
                    );
                    break;
            }
        }
        $args['meta_query'][] = $price_query;
    }

    // فلتر التاريخ
    $date_value = !empty($_POST['trip_date']) ? $_POST['trip_date'] : (!empty($_GET['trip_date']) ? $_GET['trip_date'] : '');
    if (!empty($date_value)) {
        $args['meta_query'][] = array(
            'key'     => 'trip_date',
            'value'   => $date_value,
            'compare' => '=',
            'type'    => 'DATE'
        );
    }

    // إذا كان لدينا أكثر من شرط بحث، نضيف العلاقة المنطقية بينهم
    if (count($args['meta_query']) > 1) {
        $args['meta_query']['relation'] = 'AND';
    }

    // الترتيب
    $sort_by = !empty($_POST['sort_by']) ? $_POST['sort_by'] : (!empty($_GET['sort_by']) ? $_GET['sort_by'] : '');
    if (!empty($sort_by)) {
        if ($sort_by === 'price_asc') {
            $args['meta_key'] = 'trip_price';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
        } elseif ($sort_by === 'price_desc') {
            $args['meta_key'] = 'trip_price';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
        } elseif ($sort_by === 'rating_high') {
            $args['meta_key'] = 'trip_rating';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
        } elseif ($sort_by === 'rating_low') {
            $args['meta_key'] = 'trip_rating';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
        } elseif ($sort_by === 'discount_high') {
            $args['meta_key'] = 'trip_discount';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
        } elseif ($sort_by === 'discount_low') {
            $args['meta_key'] = 'trip_discount';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
        }
    }
      
    $trips_query = new WP_Query($args);
    display_trips($trips_query);

    wp_die(); // مهم جداً في دوال AJAX
}

add_action('wp_ajax_filter_trips', 'filter_trips');
add_action('wp_ajax_nopriv_filter_trips', 'filter_trips');



function custom_query_vars($vars) {
    $vars[] = 'destination';
    $vars[] = 'trip_date';
    $vars[] = 'duration';
    $vars[] = 'price';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars');

function custom_rewrite_rules() {
    add_rewrite_rule(
        '^trips/([0-9]+)/?$',
        'index.php?pagename=trips&destination=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_rewrite_rules');

function add_query_vars($vars) {
    $vars[] = 'destination';
    return $vars;
}
add_filter('query_vars', 'add_query_vars');

function sort_trips() {
    $args = array(
        'post_type'      => 'add_trip',
        'posts_per_page' => 5,
        'post_status'    => 'publish',
    );

    // Sorting Feature
    if (!empty($_POST['sort_by'])) {
        if ($_POST['sort_by'] === 'price_asc') {
            $args['meta_key'] = 'trip_price';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
        } elseif ($_POST['sort_by'] === 'price_desc') {
            $args['meta_key'] = 'trip_price';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
        } elseif ($_POST['sort_by'] === 'rating_high') {
            $args['meta_key'] = 'trip_rating';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
        } elseif ($_POST['sort_by'] === 'rating_low') {
            $args['meta_key'] = 'trip_rating';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
        } elseif ($_POST['sort_by'] === 'discount_high') {
            $args['meta_key'] = 'trip_discount';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
        } elseif ($_POST['sort_by'] === 'discount_low') {
            $args['meta_key'] = 'trip_discount';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
        }
    }

    $trips_query = new WP_Query($args);
    
    display_trips($trips_query);

    
    // Pagination
    $total_pages = $trips_query->max_num_pages;
    if ($total_pages > 1) {
        echo '<div class="pagination">';
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<button class="page-btn" data-page="' . $i . '">' . $i . '</button>';
        }
        echo '</div>';
    }

    wp_reset_postdata();
    $output = ob_get_clean();
    echo $output;
    wp_die();
}
add_action('wp_ajax_sort_trips', 'sort_trips');
add_action('wp_ajax_nopriv_sort_trips', 'sort_trips');

function render_pagination($query) {
    if ($query->max_num_pages <= 1) {
        return; // لا داعي لإظهار الباجينيشن إذا كانت هناك صفحة واحدة فقط
    }

    $current_page = max(1, get_query_var('paged', 1));
    if (isset($_POST['paged'])) {
        $current_page = intval($_POST['paged']);
    }

    echo '<div id="pagination" class="pagination-container mt-8 flex justify-center items-center space-x-2 rtl:space-x-reverse">';
    
    // زر الصفحة السابقة
    if ($current_page > 1) {
        echo '<a href="#" data-page="' . ($current_page - 1) . '" class="pagination-link w-10 h-10 flex items-center justify-center rounded-md border border-gray-200 text-[#138EA0] font-medium hover:bg-gray-50">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>';
        echo '</a>';
    }

    // أرقام الصفحات
    $total_pages = $query->max_num_pages;
    $range = 2; // عدد الصفحات التي سيتم عرضها قبل وبعد الصفحة الحالية

    // عرض الصفحات الأولى دائمًا
    if ($current_page > $range + 1) {
        echo '<a href="#" data-page="1" class="pagination-link w-10 h-10 flex items-center justify-center rounded-md border border-gray-200 text-[#138EA0] font-medium hover:bg-gray-50 ">1</a>';
        
        if ($current_page > $range + 2) {
            echo '<span class="px-2">...</span>';
        }
    }

    // عرض الصفحات المحيطة بالصفحة الحالية
    for ($i = max(1, $current_page - $range); $i <= min($total_pages, $current_page + $range); $i++) {
        if ($i == $current_page) {
            echo '<span class="w-10 h-10 flex items-center justify-center rounded-md border bg-[#138EA0] border-gray-200 text-white font-medium hover:bg-gray-50">' . $i . '</span>';
        } else {
            echo '<a href="#" data-page="' . $i . '" class="pagination-link w-10 h-10 flex items-center justify-center rounded-md border border-gray-200 text-[#138EA0] font-medium hover:bg-gray-50">' . $i . '</a>';
        }
    }

    // عرض الصفحات الأخيرة دائمًا
    if ($current_page < $total_pages - $range) {
        if ($current_page < $total_pages - $range - 1) {
            echo '<span class="px-2">...</span>';
        }
        
        echo '<a href="#" data-page="' . $total_pages . '" class="pagination-link w-10 h-10 flex items-center justify-center rounded-md border border-gray-200 text-[#138EA0] font-medium hover:bg-gray-50">' . $total_pages . '</a>';
    }

    // زر الصفحة التالية
    if ($current_page < $total_pages) {
        echo '<a href="#" data-page="' . ($current_page + 1) . '" class="pagination-link w-10 h-10 flex items-center justify-center rounded-md border border-[#138EA0] text-[#138EA0] hover:bg-[#138EA0] hover:text-white transition-colors">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>';
        echo '</a>';
    }

    echo '</div>';

    // إضافة سكريبت JavaScript للتعامل مع النقر على أزرار الباجينيشن
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // تعريف متغير ajaxurl للواجهة الأمامية
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        
        // استهداف جميع روابط الباجينيشن المتاحة في DOM
        const handlePaginationLinks = function() {
            document.querySelectorAll('.pagination-link').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // الحصول على رقم الصفحة
                    const page = this.getAttribute('data-page');
                    if (!page) return;
                    
                    // تحديث عنوان URL لمساعدة وظيفة "الرجوع" في المتصفح
                    const params = new URLSearchParams(window.location.search);
                    params.set('paged', page);
                    const newUrl = `${window.location.pathname}?${params.toString()}`;
                    history.pushState({ page }, '', newUrl);
                    
                    // عرض مؤشر التحميل
                    const loadingIndicator = document.getElementById('loading-indicator');
                    if (loadingIndicator) {
                        loadingIndicator.style.display = 'block';
                    }
                    
                    // إرسال طلب AJAX للحصول على الرحلات الجديدة
                    const formData = new FormData();
                    formData.append('action', 'filter_trips'); // إضافة action مطلوب للـ AJAX
                    formData.append('paged', page);
                    
                    // إضافة البيانات من نموذج الفلترة إذا كان موجوداً
                    const filterForm = document.getElementById('trip-filter-form');
                    if (filterForm) {
                        // جمع البيانات من نموذج الفلترة
                        const formElements = filterForm.elements;
                        for (let i = 0; i < formElements.length; i++) {
                            const element = formElements[i];
                            
                            // التعامل مع checkbox المحددة فقط أو العناصر الأخرى
                            if ((element.type === 'checkbox' && element.checked) || element.type !== 'checkbox') {
                                // التعامل مع المصفوفات (مثل اسماء العناصر التي تنتهي بـ [])
                                if (element.name.endsWith('[]')) {
                                    formData.append(element.name, element.value);
                                } else {
                                    formData.set(element.name, element.value);
                                }
                            }
                        }
                    }
                    
                    // إضافة معيار الترتيب إذا كان موجوداً
                    const sortSelect = document.getElementById('sort_by');
                    if (sortSelect) {
                        formData.append('sort_by', sortSelect.value);
                    }
                    
                    // إرسال طلب AJAX
                    fetch(ajaxurl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        // إخفاء مؤشر التحميل
                        if (loadingIndicator) {
                            loadingIndicator.style.display = 'none';
                        }
                        
                        // تحديث محتوى النتائج
                        const resultsContainer = document.getElementById('trip-results');
                        if (resultsContainer) {
                            resultsContainer.innerHTML = data;
                            
                            // إعادة تهيئة Swiper للصور الجديدة
                            if (typeof initializeSwipers === 'function') {
                                setTimeout(() => {
                                    initializeSwipers();
                                    
                                    // إعادة ربط أحداث النقر على روابط الباجينيشن الجديدة
                                    handlePaginationLinks();
                                }, 200);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching trips:', error);
                        
                        // إخفاء مؤشر التحميل
                        if (loadingIndicator) {
                            loadingIndicator.style.display = 'none';
                        }
                    });
                });
            });
        };
        
        // تشغيل الدالة لتفعيل روابط الباجينيشن الحالية
        handlePaginationLinks();
    });
    </script>
    <?php
}









function display_trips($trips_query) {
    if ($trips_query->have_posts()) :
        while ($trips_query->have_posts()) : $trips_query->the_post();
            // $price = get_post_meta(get_the_ID(), 'trip_price', true);
            // $discount = get_post_meta(get_the_ID(), 'trip_discount', true);
            // $final_price = $price - ($price * ($discount / 100));
            ?>

<?php
$trip_id = get_the_ID();
$link =  get_permalink(get_the_ID());
$trip_title = get_the_title();
$trip_status =  get_post_meta($trip_id, 'trip_status', true);
$trip_caption = get_post_meta($trip_id, 'trip_caption', true);
$trip_gallery = get_post_meta($trip_id, 'trip_gallery', true);
$trip_gallery = is_array($trip_gallery) ? $trip_gallery : (is_string($trip_gallery) ? explode(',', $trip_gallery) : []);
if (!empty($trip_gallery)) {
$trip_gallery = array_map('intval', $trip_gallery); // Ensure valid attachment IDs
}

// Fetch image URLs
$trip_gallery_urls = [];
foreach ($trip_gallery as $image_id) {
$image_url = wp_get_attachment_image_url($image_id, 'full');
if ($image_url) {
$trip_gallery_urls[] = $image_url;
}
}

$trip_price = get_post_meta($trip_id, 'trip_price', true);
$trip_rating = get_post_meta($trip_id, 'trip_rating', true);
$trip_duration = get_post_meta($trip_id, 'trip_duration', true);

$per_page = 4; // Number of trips per page
$current_page = isset($_POST['paged']) ? max(1, intval($_POST['paged'])) : (isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1);

$offset = ($current_page - 1) * $per_page;

// Arguments for WP_Query
$args = [
    'post_type'      => 'add_trip',
    'posts_per_page' => $per_page,
    'paged'          => $current_page,
];

$query = new WP_Query($args);

?>
<div class=" pt-6">
            <div class="trip-card bg-white rounded-2xl overflow-hidden shadow-md border border-gray-100 w-full max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row">
        <!-- Left side - Image with swiper -->
        <div class="md:w-2/5 w-full h-[300px] md:h-[100%] relative">
            <!-- Swiper for images -->
            <div class="swiper-container w-full h-full swiper">
                <div class="swiper-wrapper" style = " height:100% !important;">
                <?php foreach ($trip_gallery_urls as $url) : ?>
                       
                    <div class="swiper-slide">
              
                        <img style = "width:100%; height:100%;object-fit:cover;" src="<?php echo esc_url($url) ?>" alt="<?php echo esc_html($trip_title)?>" class="w-full h-full object-cover">
                    </div>
                      <?php endforeach ?>
                </div>
                
                <!-- Best seller badge -->
                <div class="absolute top-4 left-4 z-10">
                    <span class="bg-[#C8E677] text-[#095763] px-3 py-1 rounded-full text-xs font-medium"><?php echo esc_html($trip_status)?></span>
                </div>
                
                <!-- Rating badge -->
                <div class="absolute top-4 right-4 z-10">
                    <div class="flex items-center bg-white/80 backdrop-blur-[2px] px-2 py-1 rounded-full">
                        <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-xs font-medium"><?php echo esc_html($trip_rating)  ?></span>
                    </div>
                </div>
                
                <!-- Slide counter
                <div class="absolute bottom-4 right-4 z-10">
                    <div class="px-2 py-1 rounded-xl bg-gray-100 opacity-75 flex items-center justify-around text-xs">
                        <span class="current-slide">1</span>/<span class="total-slides"><?php echo count($trip_gallery_urls)?></span>
                    </div>
                </div> 
                
                <!-- Navigation buttons -->
                <button class="swiper-button-prev absolute left-2  z-10 bg-white/70 w-8 h-8 rounded-full flex items-center justify-center hover:bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button class="swiper-button-next absolute right-2  z-10 bg-white/70 w-8 h-8 rounded-full flex items-center justify-center hover:bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Right side - Content -->
         <a href="<?php echo $link ?>">
        <div class="md:w-3/5 w-full ps-6 pe-6 pt-6">
            <h3 class="text-xl font-semibold mb-2 text-[#095763]"><?php echo esc_html($trip_title)?></h3>
            <p class="text-gray-600 mb-6 text-sm"><?php echo esc_html(mb_strimwidth($trip_caption, 0, 120, ''))?></p>
            
            <!-- Days info -->
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 8V12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                </svg>
                <span class="text-gray-600 text-sm">Duration: <?php echo esc_html($trip_duration)?> Day</span>
            </div>
            
            <!-- Price info -->
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
                    <path d="M15 9.5C15 8.11929 13.6569 7 12 7C10.3431 7 9 8.11929 9 9.5C9 10.8807 10.3431 12 12 12C13.6569 12 15 13.1193 15 14.5C15 15.8807 13.6569 17 12 17C10.3431 17 9 15.8807 9 14.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 7V5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 19V17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span class="text-gray-600 text-sm">Start from: <span class="font-medium"><?php echo esc_html($trip_price)?>$</span></span>
            </div>
            
            <!-- Book now button -->
            <div class="flex justify-end ">
                <a href="<?php echo $link ?>" class="text-[#095763] font-medium flex items-center gap-2 group">
                    <span>Book now</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
                    </a>
            <!-- <div id="trip-results" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <p class="text-center text-gray-500">Loading trips...</p>
            </div> -->
        </div>
    </div>
                    </div>
            <?php
               endwhile;

               // Call the pagination function here
               render_pagination($trips_query);
               
               wp_reset_postdata();
           else :
               echo '<p>No trips found.</p>';
           endif;
     
    ?>
    
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    
    <?php
    wp_die();
   
    ?>

<?php
}






function flush_rewrite_on_save() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}
add_action('after_switch_theme', 'flush_rewrite_on_save');
// for top toolbar problem 
function preload_fonts() {
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=YourFont:wght@400;700&display=swap" as="style">';
}
add_action('wp_head', 'preload_fonts');

// trips filter page content 
function create_trip_filter_page_content_cpt() {
    $labels = array(
        'name' => 'Trips Content',
        'singular_name' => 'Trip Content ',
        'menu_name' => 'Trip Content',
        'name_admin_bar' => 'Trip Content',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Trip Content',
        'new_item' => 'New Trip Content',
        'edit_item' => 'Edit Trip Content',
        'view_item' => 'View Trip Content',
        'all_items' => 'All Trip Contents',
        'search_items' => 'Search Trip Contents',
        'not_found' => 'No Trip Contents found.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false, // No archive page needed
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor'),
        'menu_icon'          => 'dashicons-admin-page', // Custom icon in the dashboard
    );

    register_post_type('Trips Content', $args);
}

add_action('init', 'create_trip_filter_page_content_cpt');

function filter_trips_ajax() {
    $destination = isset($_POST['destination']) ? sanitize_text_field($_POST['destination']) : '';
    $trip_date = isset($_POST['trip_date']) ? sanitize_text_field($_POST['trip_date']) : '';
    $duration = isset($_POST['duration']) ? sanitize_text_field($_POST['duration']) : '';
    $price = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : '';

    $args = array(
        'post_type' => 'trip',
        'posts_per_page' => -1,
    );

    $meta_query = array('relation' => 'AND');

    if (!empty($destination)) {
        $args['meta_query'][] = array(
            'key'   => 'destination',
            'value' => $destination,
            'compare' => '=',
        );
    }

    if (!empty($trip_date)) {
        $args['meta_query'][] = array(
            'key'   => 'trip_date',
            'value' => $trip_date,
            'compare' => '=',
        );
    }

    if (!empty($duration)) {
        $args['meta_query'][] = array(
            'key'   => 'duration',
            'value' => $duration,
            'compare' => '=',
        );
    }

    if (!empty($price)) {
        $args['meta_query'][] = array(
            'key'   => 'price',
            'value' => $price,
            'compare' => '=',
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <div class="trip-item">
                <h3><?php the_title(); ?></h3>
                <p><?php the_excerpt(); ?></p>
            </div>
            <?php
        }
    } else {
        echo '<p>No trips found.</p>';
    }

    wp_die();
}
add_action('wp_ajax_filter_trips', 'filter_trips_ajax');
add_action('wp_ajax_nopriv_filter_trips', 'filter_trips_ajax');


?>