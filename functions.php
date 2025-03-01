<?php

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

function custom_styles() { ?>
    <style>
     .fields-container  input ,  .fields-container textarea{
    border: 1px solid #ccc !important;
    border-radius: 8px !important;
    outline: none !important;
    width:60% !important;
    margin-bottom: 16px !important;
    padding: 4px !important;
    
}
  .sm-inputs{
    border: 1px solid #ccc !important;
    border-radius: 4px !important;
    outline: none !important;
    width:40% !important;
    margin-bottom: 16px !important;
    padding: 4px !important;
    
}
.upload{
    background-color:#276C76 !important;
    color:#fff !important ;
}
.remove {
    background-color: #FF0000 !important;
    color:#fff !important ;
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



?>
<!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    window.addEventListener("load", function () {
        const adminBar = document.getElementById("wpadminbar");
        if (adminBar) {
            adminBar.style.display = "block"; // Show toolbar after full load
        }
    });
});

</script> -->
<?php 
// include customizer file 
// posts
// 1-the post thumbnail it does not exist in all themes
// 2-to add it to my see we do the following 
// to add thumbnail to the post
add_theme_support( 'post-thumbnails' ); 
require_once get_template_directory() . "./inc/customizer.php";
// tp enqueue your styles files 
function add_styles(){
    // to add css files we use wp_enqueue_style 
    // wp_enqueue_style("tailwind" ,  get_template_directory_uri() . '/src/output.css' );
    // Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0', 'all');
    wp_enqueue_style('tailwindcss', 'https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css', array(), null , false);
    wp_enqueue_style('fontawesome' , get_template_directory_uri() . '/css/all.min.css');

    wp_enqueue_style('dashboard-css-file' , get_template_directory_uri() . '/css/dashboard-style.css' ,  array(), time(), 'all');
    wp_enqueue_style('main-css-file' , get_template_directory_uri() . '/css/main.css' ,  array(), time(), 'all');
}
/////////////////////////////////////////////////////////////////////////////////////////////
// tp enqueue your scripts files 
function add_script(){
    wp_enqueue_script('tailwind-js', 'https://cdn.tailwindcss.com', array(), null, true);
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
    <div id="gallery-container" style = "display:flex; gap:8px">
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
$pages = ["home" , "destinations"  , "blog" , "about" , "faq" , "contact" ];
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
function remove_trash_option($actions, $post) {
    $custom_post_types = ["home", "destinations", "blog", "about", "faq", "contact"];

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
    <h3>Gallery Images</h3>
    <div id="gallery-images gallery-container" >
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
        <button type="button" class="button remove sm-rm-btn remove-gallery-image" style = "margin:8px 0">Remove</button>
        <!-- <button type="button" class="button upload-gallery-image">Upload</button> -->
   
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

     <div class = "fields-container">
    <h3>Top Destinations</h3>
    <p>
        <label>Section Header:</label>
        </p>
        <input type="text" name="top_destinations_header" value="<?php echo esc_attr($top_destinations_header); ?>" >
   
    <p>
        <label>Section Description:</label>
        </p>
        <textarea name="top_destinations_desc" rows="4" style="width:100%;"><?php echo esc_textarea($top_destinations_desc); ?></textarea>
   
    </div>

    
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
  
      // Get previously selected destinations
      $selected_destinations = get_post_meta($post->ID, 'nearby_destinations', true);
      if (!is_array($selected_destinations)) {
          $selected_destinations = [];
      }

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
    <div id="selected_destinations_box" style="border:1px solid #ddd; padding:10px; min-height:50px;" class = "des-box">
        <?php 
        if (!empty($selected_destinations)) {
            foreach ($selected_destinations as $dest_id) {
                $post_title = get_the_title($dest_id);
                echo '<div class = "selected-destination" data-id="' . esc_attr($dest_id) . '">' . esc_html($post_title) . '</div>';
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
            const selectBox = document.getElementById("nearby_destinations");
            const selectedBox = document.getElementById("selected_destinations_box");

            function updateSelectedBox() {
                selectedBox.innerHTML = "";
                let selectedOptions = Array.from(selectBox.selectedOptions);
                if (selectedOptions.length === 0) {
                    selectedBox.innerHTML = "<p>No destinations selected.</p>";
                } else {
                    selectedOptions.forEach(option => {
                        let p = document.createElement("p");
                        p.textContent = option.textContent;
                        p.setAttribute("data-id", option.value);
                        selectedBox.appendChild(p);
                    });
                }
            }

            selectBox.addEventListener("change", updateSelectedBox);

            document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll("#destination-checkboxes input[type='checkbox']");
            const selectedBox = document.getElementById("selected_destinations_box");

            function updateSelectedBox() {
                selectedBox.innerHTML = "";
                let selectedOptions = Array.from(checkboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.nextSibling.textContent.trim());

                if (selectedOptions.length === 0) {
                    selectedBox.innerHTML = "<p>No destinations selected.</p>";
                } else {
                    selectedOptions.forEach(option => {
                        let p = document.createElement("p");
                        p.textContent = option;
                        selectedBox.appendChild(p);
                    });
                }
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateSelectedBox);
            });

            updateSelectedBox(); // Initialize with already selected destinations
        });
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
    $existing_destinations = get_post_meta($post_id, 'nearby_destinations', true);
    if (!is_array($existing_destinations)) {
        $existing_destinations = [];
    }

    // Handle new selection
    if (isset($_POST['nearby_destinations']) && is_array($_POST['nearby_destinations'])) {
        $new_selections = array_map('sanitize_text_field', $_POST['nearby_destinations']);

        // Merge old and new values without duplicates
        $final_selections = array_unique(array_merge($existing_destinations, $new_selections));

        update_post_meta($post_id, 'nearby_destinations', $final_selections);
    } else {
        delete_post_meta($post_id, 'nearby_destinations'); // Remove if empty
    }
    
}
add_action('save_post', 'save_destination_meta_box');


// trip custom post type 

// Register Custom Post Types
function register_trip_post_types() {
    // Register Trips Post Type
    register_post_type('trip', array(
        'labels' => array(
            'name' => __('Trips'),
            'singular_name' => __('Trip')
        ),
        'public' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-palmtree',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true
    ));

    // Register Tour Types Post Type
    register_post_type('tour_type', array(
        'labels' => array(
            'name' => __('Tour Types'),
            'singular_name' => __('Tour Type')
        ),
        'public' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-admin-site',
        'supports' => array('title', 'editor'),
        'show_in_rest' => true
    ));
}
add_action('init', 'register_trip_post_types');

// Add Meta Boxes for Trip Details
function add_trip_meta_boxes() {
    add_meta_box('trip_basic_info', 'Basic Info', 'trip_basic_info_callback', 'trip', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_trip_meta_boxes');

function trip_basic_info_callback($post) {
  
    wp_nonce_field('save_trip_meta_data_nonce', 'trip_meta_nonce');

    $trip_status = get_post_meta($post->ID, 'trip_status', true);
    $trip_caption = get_post_meta($post->ID, 'trip_caption', true);
    $trip_gallery = get_post_meta($post->ID, 'trip_gallery', true);
    $destination = get_post_meta($post->ID, 'trip_destination', true);
    $trip_price = get_post_meta($post->ID, 'trip_price', true);
    $trip_rating = get_post_meta($post->ID, 'trip_rating', true);
    $trip_discount = get_post_meta($post->ID, 'trip_discount', true);
    $trip_duration = get_post_meta($post->ID, 'trip_duration', true);
    ?>

<input type="hidden" name="trip_meta_nonce" value="<?php echo wp_create_nonce('save_trip_meta_data_nonce'); ?>" />
    <label for="trip_status">Trip Status:</label>
    <input type="text" name="trip_status" value="<?php echo esc_attr($trip_status); ?>" class="widefat" />

    <label for="trip_caption">Trip Caption:</label>
    <textarea name="trip_caption" class="widefat"><?php echo esc_textarea($trip_caption); ?></textarea>

    <label for="trip_gallery">Trip Gallery:</label>
    <input type="text" name="trip_gallery" value="<?php echo esc_attr($trip_gallery); ?>" class="widefat" />

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

    <label for="trip_duration">Trip Duration:</label>
    <input type="text" name="trip_duration" value="<?php echo esc_attr($trip_duration); ?>" class="widefat" />
    <?php
}

// Save Meta Box Data
function save_trip_meta_data($post_id) {
    if (!isset($_POST['trip_meta_nonce']) || !wp_verify_nonce($_POST['trip_meta_nonce'], 'save_trip_meta_data_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (!current_user_can('edit_post', $post_id)) return;

 
    // ... other update_post_meta() calls ...


    if (!isset($_POST['trip_status'])) return;
    update_post_meta($post_id, 'trip_status', sanitize_text_field($_POST['trip_status']));
    update_post_meta($post_id, 'trip_caption', sanitize_textarea_field($_POST['trip_caption']));
    update_post_meta($post_id, 'trip_gallery', esc_url($_POST['trip_gallery']));
    update_post_meta($post_id, 'trip_destination', intval($_POST['trip_destination']));
    update_post_meta($post_id, 'trip_price', floatval($_POST['trip_price']));
    update_post_meta($post_id, 'trip_rating', floatval($_POST['trip_rating']));
    update_post_meta($post_id, 'trip_discount', intval($_POST['trip_discount']));
    update_post_meta($post_id, 'trip_duration', sanitize_text_field($_POST['trip_duration']));
}
add_action('save_post', 'save_trip_meta_data');


?>
