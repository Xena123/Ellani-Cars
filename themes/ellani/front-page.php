<!-- front-page.php -->
<?php get_header('home'); ?>

	<!-- Begin Page Content -->
  <!-- Begin Main Content -->
	<main class="o-wrap--full-width">
  <div class="u-relative">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      
      <header class="c-banner-header o-text-overlay u-text-center u-background--transparent u-text-white">
        <?php edit_post_link(); ?>
        <h1 class="u-text-white u-uppercase u-underline u-padding-bottom-15 u-margin-bottom-20"><?php the_title(); ?></h1>
        <div class="u-padding-bottom-30 u-padding-sides-30 u-letter-spacing-225"><?php the_content(); ?></div>
        <a href="<?php echo home_url(); ?>/the-ellani-selection" class="u-border-button u-padding-button-10-15">
          <p class="u-uppercase u-inline-block">View Our Full Stock List</p>
          <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_right.png" class="u-inline-block u-padding-left-15">
        </a>
      </header>

      <?php endwhile; endif; ?>
      <div class="o-background u-overlay--dark"></div>
    <?php get_template_part('includes/banner-slider'); ?>
    
    <!-- End Slider Section -->
    <?php get_template_part('includes/front-page_vehicles'); ?>
		
	</main>
  <!-- End Main Content -->


	<!-- End Page Content -->
<?php get_footer(); ?>
