 
  <!-- Begin Single Slider Section -->
  
  <section class="c-slider single-slider">
  
  <?php
    $args = array (
      'post_type' => 'slider',
      'posts_per_page' => -1,
      'orderby' => 'date',
      'order' => 'DESC',
    );
    $slider = new WP_Query( $args );
    if ($slider->have_posts()) : while ($slider->have_posts()) : $slider->the_post();
  ?>

  <article class="o-content-block-wrap">
    
    <div class="c-content-block__slider-img" style="background-image: url('<?php the_post_thumbnail_url(); ?>')"></div>
    
  </article>

  <?php endwhile; endif; wp_reset_postdata(); ?>

  </section>
  </div>
	<!-- End Single Slider Section -->
