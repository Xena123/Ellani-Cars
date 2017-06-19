<!-- page-find-us.php -->
<?php get_header(); ?>
<?php
$my_postid = 10;//This is page id or post id
$content_post = get_post($my_postid);
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
?>
<main class="o-wrap--full-width">
	<div class="u-relative">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	  <header class="c-banner-header o-text-overlay u-text-center u-background--transparent u-text-white">
	    <h1 class="u-text-white u-uppercase u-underline u-padding-bottom-15 u-margin-bottom-20"><?php echo get_the_title(10); ?></h1>

	    <div class="u-padding-bottom-30 u-padding-sides-30 u-letter-spacing-225"><?php echo $content; ?></div>
	    <a href="<?php echo home_url(); ?>/the-ellani-selection" class="u-border-button u-padding-button-10-15">
	      <p class="u-uppercase u-inline-block">View Our Full Stock List</p>
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
<!-- Begin Main Section -->
<section class="u-flex u-flex-start">
	
	<aside class="o-content-block-half-width u-padding-right-60">
		<div id="map"></div>
	    <script>
	      function initMap() {
	        var uluru = {lat: 51.618215, lng: -2.668508};
	        var map = new google.maps.Map(document.getElementById('map'), {
	          zoom: 15,
	          center: uluru,
	          scrollwheel: false
	        });
	        var marker = new google.maps.Marker({
	          position: uluru,
	          map: map
	        });
	      }
	    </script>
	    <script async defer
	    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhnWioMIaLl5AXCllZKpo26fRX2FfYIDU&callback=initMap">
	    </script>
	</aside>
	<aside class="u-padding-left-15 u-padding-bottom-15 o-content-block-half-width u-padding-right-60 u-padding-top-35">
		<div class="u-flex u-flex-start u-flex-space-between u-padding-bottom-20">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="o-content-block-half-width">
				<h2 class="u-uppercase u-padding-bottom-50 u-fw-600">Where We Are</h2>
				<ul>
					<li class="u-padding-bottom-5 u-uppercase u-text-dark-grey u-fw-600">Ellani Cars</li>
					<li class="u-padding-bottom-5 u-uppercase u-text-dark-grey u-fw-600">Unit 8 Severnlink</li>
					<li class="u-padding-bottom-5 u-uppercase u-text-dark-grey u-fw-600">Chepstow</li>
					<li class="u-padding-bottom-50 u-uppercase u-text-dark-grey u-fw-600">NP16 6UN</li>

					<h2 class="u-uppercase u-padding-bottom-40 u-fw-600">Contact</h2>
					<li class="u-padding-bottom-5 u-uppercase u-text-dark-grey u-fw-600">Office No.</li>
					<li class="u-padding-bottom-20 u-uppercase u-text-dark-grey u-fw-200">01291 623 562</li>
					<li class="u-padding-bottom-5 u-uppercase u-text-dark-grey u-fw-600">Mobile No.</li>
				</ul>
			</div>
			<div class="o-content-block-half-width">
				<h2 class="u-uppercase u-padding-bottom-50 u-fw-600">Opening Times</h2>
				<ul class="u-text-dark-grey u-uppercase">
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-600">Monday </li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-200">09:00 - 18:00</li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-600">Tuesday </li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-200">09:00 - 18:00</li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-600">Wednesday </li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-200">09:00 - 18:00</li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-600">Thursday </li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-200">09:00 - 18:00</li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-600">Friday </li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-200">09:00 - 18:00</li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-600">Saturday </li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-200">09:00 - 17:00</li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-600">Sunday </li>
					<li class="u-padding-bottom-30 u-width-50 u-inline-block u-fw-200">10:00 - 16:00</li>
				</ul>
			</div>
		</div>
		<?php endwhile; endif; wp_reset_postdata(); ?>
		<div class="c-find-us-form">
			<header class="u-blue-background u-width-100 u-text-center u-text-white u-flex--init u-flex-center u-flex-justify-center">
				<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/mail_white.png" class="c-find-us-form__header-img u-padding-right-15">
				<h5 class="u-uppercase u-letter-spacing-125 u-font-size--16">Enquiry Form</h5>
			</header>
			<?php edit_post_link(); ?>
			<?php the_content();?>
			
		</div>


	</aside>
	
</section>
<!-- End Main Section -->   

</main>

<?php get_footer(); ?>