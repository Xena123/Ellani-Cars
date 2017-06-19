<!-- page-vehicles.php -->
<!-- Category page for Vehicles Custom Post Type -->
<?php
/* Template Name: Vehicle Category Page */
?>

<?php get_header(); ?>

<main class="o-wrap--full-width">

  <div class="u-relative">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <header class="c-banner-header o-text-overlay u-text-center u-background--transparent u-text-white">
      <?php edit_post_link(); ?>
      <h1 class="u-text-white u-uppercase u-underline u-padding-bottom-15 u-margin-bottom-20"><?php the_title(); ?></h1>
      <div class="o-content u-padding-bottom-30 u-padding-sides-30 u-letter-spacing-225"><?php the_content(); ?></div>
    </header>

    <section class="c-slider">

      <article class="o-content-block-wrap">
        <div class="c-content-block__slider-img" style="background-image: url('<?php the_post_thumbnail_url(); ?>')"></div>
        <div class="o-background u-overlay--dark"></div>
      </article>

      <?php endwhile; endif; wp_reset_postdata(); ?>

    </section>
  </div>


	<!-- Begin Main Section -->
  <?php get_template_part('includes/category-vehicle_info'); ?>
  <!-- End Main Section -->

</main>

<?php get_footer(); ?>
