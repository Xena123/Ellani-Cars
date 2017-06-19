<?php
	global $post;
	$class = "band band--home band--even";
	if ($i == 0) {
		$class = "band band--home band--odd band--first-pipe";
		$pipeClass = "pipe pipe--odd pipe--start";
	}
	elseif ( $i%2 == 0 ) {
		$pipeClass = "pipe pipe--odd";
	}
	else {
		$pipeClass = "pipe pipe--even";
	}
?>
<section class="<?php echo $class; ?>">
	<div class="<?php echo $pipeClass; ?>">
		<div class="circle circle--start"></div>
		<div class="line-end"></div>
		<div class="circle circle--end"></div>
		<div class="button"></div>
	</div>

	<div class="band__content">
		<article class="content-block content-block--left-image content-block--read-more">
			<figure class="content-block__imagewrap">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icons/phone.png" height="121" width="123" class="alignleft">
			</figure>
			<header class="content-block__header">
				<?php edit_post_link(); ?>
				<h1><?php the_title(); ?></h1>
			</header>
			<div class="content-block__content">
				<?php the_content(); ?>
			</div>
			<div class="readmore-block">
				<a href="<?php the_field('url'); ?>" class=" [ readmore button-link ] full-width"><?php echo ( get_field('label') != "") ? get_field('label') : 'Read More'; ?></a>
			</div>
		</article>

		<div class="row">
			<?php fanaticBlock( $post->ID . "small-nuggets" , 'home-nuggets' , -1 , 'nugget' ); ?>
		</div>
	</div>

</section>
