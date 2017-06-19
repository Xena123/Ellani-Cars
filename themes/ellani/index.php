<!-- index.php -->
<?php get_header(); ?>

		<!-- Begin Page Content -->
    <!-- Begin Main Content -->
		<main class="c-main-content o-wrap--full-width u-min-height-100">
      <div class="u-relative">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
       
         <section class="c-slider">
  
          <article class="o-content-block-wrap">
            <div class="c-content-block__banner-img" style="background-image: url('<?php the_post_thumbnail_url(); ?>')""></div>
            <div class="o-background u-overlay--dark"></div>
          </article>

          <?php endwhile; endif; wp_reset_postdata(); ?>

        </section>
        
      </div>
      <section class="o-wrap--padding-100 u-padding-top-30 u-padding-bottom-40">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <header class="u-text-center u-background--transparent u-text-white">
        <?php edit_post_link(); ?>
          <h1 class="u-inline-block u-uppercase u-underline u-padding-bottom-15 u-margin-bottom-20"><?php the_title(); ?></h1>
          
        </header>
        <?php endwhile; endif; wp_reset_postdata(); ?>
        <!-- End Slider Section -->

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    		<article class="o-wrap--padding-100 u-padding-top-30 u-padding-bottom-40">
          <div class="o-content">
      			<?php the_content(); ?>
          </div>
    		</article>

        <?php endwhile; endif; ?>
      </section>
		</main>
    <!-- End Main Content -->


		<!-- End Page Content -->
<?php get_footer(); ?>
