<?php get_header() ?>



<section class="blogs">
  <div class="container">
    <?php   single_cat_title() ?>

    <div class="row">
  
      <?php
      if(have_posts()){
        while(have_posts()){
          the_post() ?>
          <div class="col-sm-6 ">
          <div class="main-post">
           
            <h3 class = "post-title">
              <a href=" the_permaLink();"> 
                <?php the_title(); ?>
              </a>
            </h3>
            <span class="post-author"> <i class="fa-solid fa-user"></i> <?php  the_author_posts_link()?> </span>
            <span class="post-date"> <i class="fa-solid fa-calendar-days"></i> <?php the_date( 'F j, Y' );?> at <?php the_time('g:i a')?></span>
            <span class="post-comments"><i class="fa-solid fa-comment"></i>  <?php comments_popup_link('0 Comments' , '1 Comment' , '% Comments' , 'Comments-disabled') ?></span>
            <?php  
            the_post_thumbnail('' , ['class'=> 'img-responsive  img-thumbnail' ])
            ?>
            <p class="post-content">
              <!-- <?php the_content('Read More...'); ?> -->
              <?php the_content('Read More'); ?>
            </p>
            <hr>
            <p class="categories"> <i class="fa-solid fa-tag"></i> <?php the_category(' , ')?></p>
            <p class="tags">
              <?php 
              if(has_tag()){
                the_tags();
              }
              else {
                echo 'No tags';
              }
              
              ?>
            </p>
         
          </div>
          </div>
          <?php
        
      }
    
      }
      echo "<div class= 'post-pagination '>";
      if(get_previous_posts_link()){
        previous_posts_link('<i class="fa-solid fa-angle-left"></i>');
      }
      else{
        echo "<span class = 'prev-icon'> <i class='fa-solid fa-angle-left'></i> </span>";
      }
      if(get_next_posts_link()){
        next_posts_link('<i class="fa-solid fa-angle-right"></i>');
      }
      else{
        echo "<span class = 'next-icon'> <i class='fa-solid fa-angle-right'></i> </span>";
      }
    
    echo"</div>";
      
    ?>
 
    </div>
  </div>
</section>

<?php get_footer() ?>
