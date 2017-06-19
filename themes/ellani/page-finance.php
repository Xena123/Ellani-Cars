<!-- page-finance.php -->
<?php get_header(); ?>

	<!-- Begin Page Content -->
  <!-- Begin Main Content -->
	<main class="o-wrap--full-width">
    <div class="u-relative">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <header class="c-banner-header o-text-overlay u-text-center u-background--transparent u-text-white">
        <?php edit_post_link(); ?>
        <h1 class="u-text-white u-uppercase u-underline u-padding-bottom-15 u-margin-bottom-15"><?php the_title(); ?></h1>
        <div class="u-padding-bottom-30 u-letter-spacing-225"><?php the_content(); ?></div>
        <a href="<?php echo home_url(); ?>/find-us" class="u-border-button u-padding-button-40">
          <p class="u-uppercase u-inline-block">Get in Touch Today</p>
          <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_right.png" class="u-inline-block u-padding-left-15">
        </a>
      </header>

      <section class="c-slider">
  
      <article class="o-content-block-wrap">
        <div class="c-content-block__slider-img" style="background-image: url('<?php the_post_thumbnail_url(); ?>')""></div>
        <div class="o-background u-overlay--dark"></div>
      </article>

      <?php endwhile; endif; wp_reset_postdata(); ?>

      </section>
    </div>
  
    <!-- End Slider Section -->

    <header class="u-blue-background u-flex--init u-flex-center u-flex-justify-center u-padding-20">
      <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/finance.png" class="u-padding-right-15">
      <h5 class="u-text-white u-uppercase">Ellani Finance Form</h5>
    </header>

    <section class="o-wrap--padding-150 u-padding-top-35">
      <!-- <div class="u-flex--init u-flex-space-around u-font-size-20 u-padding-bottom-40">
        <h3 href="#" class="u-uppercase u-fw-600">Contact</h3>
        <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_right_blk.png" class="">
        <h3 href="#" class="u-uppercase u-fw-600">Address</h3>
        <img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_right_blk.png" class="">
        <h3 href="#" class="u-uppercase u-fw-600">Employment</h3>
      </div> -->

      <?php echo do_shortcode('[ninja_form id=7]'); ?>

      <article class="u-border-top u-padding-top-20 u-padding-bottom-40">
        <div class="">
          <p>We are acting as a credit broker and not a lender. We can introduce you to a number of carefully selected credit providers who may be able 
          to offer you finance for your vehicle. We are only able to offer finance products from these providers and a commission may be received for 
          this introduction. Finance available subject to status. Terms and conditions apply. 18s and over. Guarantee and/or Indemnities may be required. 
          Other finance offers may be available but cannot be used in conjunction with this offer. Representative Examples are for illustrative purposes only. 
          Address: Ellani Cars, , 33 Clifton Road, Bristol, BS6 8RN. Authorised and regulated by the Financial Conduct Authority. Firm Reference Number: FRN724892</p>
        </div>
      </article>
    </section>
  </main>
  <!-- End Main Content -->


  <!-- End Page Content -->
<?php get_footer(); ?>
