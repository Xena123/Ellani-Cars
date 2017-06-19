<!-- single-vehicles.php -->
<?php get_header(); ?>
<?php
$my_postid = 97;//This is page id or post id
$content_post = get_post($my_postid);
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
?>
<main class="o-wrap--full-width">
  <!-- <div class="u-relative">
    <header class="c-banner-header o-text-overlay u-text-center u-background--transparent u-text-white">
      
      <h1 class="u-text-white u-uppercase u-underline u-padding-bottom-10 u-margin-bottom-15"><?php echo get_the_title(97); ?></h1>

      <div class="u-padding-bottom-20"><?php echo $content; ?></div>
      
    </header>

    
  </div> -->
    <!-- End Banner Slider Section -->

    <!-- Begin Main Content Section -->
  <section class="o-wrap--padding-100 u-padding-top--130 u-padding-bottom-50">
    <article class="o-wrap--with-sidebar">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <header class="u-flex--init u-flex-center u-padding-top--12 u-padding-bottom-15">
      <?php edit_post_link(); ?>
      <h1 class="u-text-black u-uppercase u-inline-block u-uppercase u-margin-right-40"><?php the_title(); ?></h1>
      <h1 class="c-single-vehicle--price u-blue-background u-text-white u-inline-block">£<?php the_field('price'); ?></h1>
    </header>

    <?php endwhile; endif; wp_reset_postdata(); ?>

    <?php get_template_part('includes/single-vehicle_gallery'); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div class="">
        <header class="u-flex--init u-flex-center u-padding-top-30 u-padding-bottom-15">
          <?php edit_post_link(); ?>
          <h1 class="u-text-black u-uppercase u-inline-block u-uppercase u-margin-right-40"><?php the_title(); ?></h1>
          <h1 class="c-single-vehicle--price u-blue-background u-text-white u-inline-block">£<?php the_field('price'); ?></h1>
        </header>
    
        <div class="o-content u-padding-bottom-20">
          <?php the_content(); ?>
        </div>
        <div class="u-flex--init--1000 u-flex-space-between u-padding-bottom-20">
          <a href="#" class="c-single-vehicle__link-wrap u-flex--init u-flex-center u-padding-top-and-bottom-5">
            <div class="c-single-vehicle__link-img u-inline-block u-margin-right-10">
              <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/link_book.png" class="">
            </div>
            <span class="u-uppercase">Book Test Drive</span>
          </a>
          <a href="#" class="c-single-vehicle__link-wrap u-flex--init u-flex-center u-padding-top-and-bottom-5">
            <div class="c-single-vehicle__link-img u-inline-block u-margin-right-10">
              <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/link_insurance.png" class="">
            </div>
            <span class="u-uppercase">Insurance Quote</span>
          </a>
          <a href="#" class="c-single-vehicle__link-wrap u-flex--init u-flex-center u-padding-top-and-bottom-5">
            <div class="c-single-vehicle__link-img u-inline-block u-margin-right-10">
              <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/link_history.png" class="">
            </div>
            <span class="u-uppercase">Check Its History</span>
          </a>
        </div>

        <?php get_template_part('includes/single-vehicle_info'); ?>

    </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>
  </article>
  <!-- Begin Form Section -->
  <aside class="o-wrap--sidebar">
    <div class="c-vehicle-form">
      <header class="u-blue-background u-flex--init u-flex-center u-header-padding">
        <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/enquire.png" class="u-height-100 u-margin-right-20">
        <p class="u-font-size--16 u-text-white u-uppercase">Enquire about Vehicle</p>
      </header>
      <?php Ninja_Forms()->display( 1 ); ?>
    </div>
  </aside>
    <!-- End Form Section -->
</section>
</main>
<!-- End Main Content Section -->


<?php get_footer(); ?>
