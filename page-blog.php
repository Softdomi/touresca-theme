<?php
   $_yellow = "#C8EC1F";
   $_primary = "#095763";
   $_primary_two = "#074C56";
   ?>
   <style>
        /* start common styles */
        .swiper-slide {
    height: auto !important;
    min-height: 100% !important; 
}

        .btn {
            height: 48px;
            border-radius: 24px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            padding: 0 5px;
            border: none;
            
        }
        
        
        .btn-secondary {
            background-color: #E0EAEB;
            color:
            <?= $_primary ?>
            ;
            
        }
        .btn-primary,
        .btn-secondary:hover {
            background-color:
            <?= $_yellow ?>
            ;
            color:
                <?= $_primary ?>
            ;
        }
        /* .tab-link {
    display: grid !important;
    grid-template-columns: repeat(8, minmax(0, 1fr)) !important;
} */
    </style>
<!-- add header to the page  -->
<?php get_template_part('template-parts/header'); ?>

<?php

$blog_sections = get_posts(array(
    'post_type' => 'blog_sections', 
    'posts_per_page' => -1, // Get all sections
    'orderby' => 'menu_order', // Optional: Order by menu order or any other attribute
    'order' => 'ASC',
));
?>
<!-- // Check if there are any blogs sections -->
<?php if (!empty($blog_sections)): ?>
    <?php foreach ($blog_sections as $section): ?>
    


                <!-- blog Hero Section -->
    <section class="bg-gradient-to-b from-[#105B66] to-[#BAD0B4] py-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
            <h1 class="font-['Berkshire_Swash'] text-[#C8E677] text-[40px] mb-2 md:text-6xl md:mb-8"> 
                 <?php echo esc_html(get_the_title($section->ID)); ?></h1>
                 <?php
                  $content = get_post_field('post_content', $section->ID);
                  if (!empty(trim($content))): ?>
                    
                     <div class="text-white text[24px] max-w-6xl" style="line-height:30.4px;">
                     <?php echo strip_tags(apply_filters('the_content', $content), '<strong><em><ul><li><ol><br>'); ?>
                  </div>
                    <?php endif; ?>
                
    
  
          
                    <div class="tab-link grid grid-cols-2 sm:grid-cols-3 md:grid-cols-8 gap-2 mt-8">
    <!-- "All" Button -->
    <button class="filter-btn btn btn-secondary btn-primary" data-category="all">All</button>

    <?php
    $categories = get_categories(array(
        'orderby' => 'name', 
        'order'   => 'ASC'
    ));

    foreach ($categories as $category): ?>
        <button class="filter-btn btn btn-secondary" data-category="<?php echo esc_attr($category->slug); ?>">
            <?php echo esc_html($category->name); ?>
        </button>
    <?php endforeach; ?>
</div>

    </div> </div>
    </section>
           

    <?php endforeach; ?>
<?php else: ?>
    <p>No header sections found.</p>
<?php endif; ?>




<section class="max-w-7xl px-4 sm:px-6 lg:px-0 mx-auto relative my-12">
    <!-- Grid Layout -->
    <div id="posts-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        // الحصول على رقم الصفحة الحالية باستخدام معلمة pgn بدلاً من paged
        $current_page = isset($_GET['pgn']) ? intval($_GET['pgn']) : 1;
        
        // Custom Query for Posts
        $query = new WP_Query(array(
            'post_type'      => 'post', 
            'posts_per_page' => 5,
            'paged'          => $current_page, // استخدام المتغير الجديد
            'orderby'        => 'date',
            'order'          => 'DESC'
        ));

        if ($query->have_posts()) :
            $count = 0;
            while ($query->have_posts()) : $query->the_post();
                $count++;
                $extra_classes = ($count === 1) ? 'col-button-1 sm:col-span-2' : '';
        ?>
                <div class="bg-[#F4F8F3] rounded-[20px] shadow-[0_2px_8px_rgba(0,0,0,0.08)] overflow-hidden <?= $extra_classes; ?>">
                    <a href="<?php the_permalink(); ?>">
                        <div class="relative">
                            <?php the_post_thumbnail('', ['class' => 'w-full h-[350px] object-cover']); ?>
                        </div>
                        <div class="p-6">
                            <span class="bg-[<?= $_yellow ?>] text-[<?= $_primary ?>] px-3 py-1 rounded-full text-xs font-medium ">
                                <?php 
                                    ob_start();
                                    the_category(', '); 
                                    $categories = ob_get_clean(); 
                                    echo strip_tags($categories); 
                                ?>
                            </span>

                            <h3 class="text-xl font-semibold my-2">
                                <a href="<?php the_permalink(); ?>">
                                    <?php      $title = get_the_title();
            echo (mb_strlen($title) > 30) ? mb_substr($title, 0, 30)  : $title;
        ?>
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm font-weight-300">
                                <span><?php the_date('F j, Y'); ?> at <?php the_time('g:i a'); ?></span>
                            </p>
                            <p class="text-gray-600 text-sm leading-7 mb-6 mt-2">
                                <?php 
                                  
                                      ob_start();
                                      the_excerpt();
                                      $content = ob_get_clean();
                                      $content = strip_tags($content);
                                      echo (mb_strlen($content) > 30) ? mb_substr($content, 0, 40) . '....' : $content;
                               
                                ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="text-[<?= $_primary ?>] text-sm underline">
                                    Read more
                                </a>
                        </div>
                    </a>
                </div>
        <?php
            endwhile;
        endif;
        wp_reset_postdata();
        ?>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center flex-col items-center mt-8">
        <!-- Pagination Info -->
        <p class="text-gray-600 text-sm mb-4">
            <?php 
                $total_posts = $query->found_posts;
                $posts_per_page = $query->query_vars['posts_per_page'];
                $start_post = ($current_page - 1) * $posts_per_page + 1;
                $end_post = min($start_post + $posts_per_page - 1, $total_posts);
                echo "Showing {$start_post}–{$end_post} of {$total_posts} posts";
            ?>
        </p>

        <nav class="flex space-x-2">
        <?php 
        // باجينيشن بسيط باستخدام معلمة pgn
        $total_pages = $query->max_num_pages;
        
        if ($total_pages > 1) {
            // زر السابق
            if ($current_page > 1) {
                echo '<a href="?pgn=' . ($current_page - 1) . '" class="page-numbers"><span class="px-3 py-1 border border-gray-300 text-gray-500 rounded-md hover:bg-gray-100">&lt;</span></a>';
            }
            
            // أرقام الصفحات
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $current_page) {
                    echo '<span class="page-numbers current"><span class="page-number px-3 py-1 border border-gray-300 bg-teal-600 text-white rounded-md">' . $i . '</span></span>';
                } else {
                    echo '<a href="?pgn=' . $i . '" class="page-numbers"><span class="page-number px-3 py-1 border border-gray-300 text-gray-500 rounded-md hover:bg-gray-100">' . $i . '</span></a>';
                }
            }
            
            // زر التالي
            if ($current_page < $total_pages) {
                echo '<a href="?pgn=' . ($current_page + 1) . '" class="page-numbers"><span class="px-3 py-1 border border-gray-300 text-gray-500 rounded-md hover:bg-gray-100">&gt;</span></a>';
            }
        }
        ?>
        </nav>
    </div>
</section>



<style>
    .page-numbers span {
        padding: 4px 12px !important;
        border: 1px solid #D1D5DB !important; 
        color: #6B7280 !important; 
        border-radius: 6px !important; 
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        transition: background-color 0.3s ease-in-out !important;
        min-width: 40px !important; 
        min-height: 32px !important; 
        text-align: center !important;
        line-height: 24px !important;

    }
    .page-numbers.current span{
        background-color: #095763 !important ;
        border-color:#095763 !important;
        color: #fff !important;
    }
</style>

<!-- add scroll to top button  -->
<?php get_template_part('template-parts/scroll-to-top'); ?>
<!-- add footer to the page  -->
<?php get_template_part('template-parts/footer'); ?>

<script>
        document.addEventListener('DOMContentLoaded', () => {
            // Handle buttons with ".tab-link button"
            document.querySelectorAll('.tab-link button').forEach(button => {
                button.addEventListener('click', function (e) {

                    // Remove 'btn-primary' class from all links
                    document.querySelectorAll('.tab-link button').forEach(button => {
                        button.classList.remove('btn-primary');
                    });

                    // Add 'btn-primary' class to the clicked link
                    this.classList.add('btn-primary');
                });
            });

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".filter-btn");
    const postsContainer = document.getElementById("posts-container");

    buttons.forEach((button) => {
        button.addEventListener("click", function () {
            let category = this.getAttribute("data-category");

            // Send AJAX request
            fetch(myAjax.ajaxurl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({
                    action: "filter_posts",
                    category: category,
                }),
            })
                .then((response) => response.text())
                .then((data) => {
                    postsContainer.innerHTML = data;
                })
                .catch((error) => console.error("Error fetching posts:", error));
        });
    });
});

    </script>