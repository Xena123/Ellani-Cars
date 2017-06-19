

<!-- Gallery Main Image -->
	<?php if( have_rows('gallery') ): ?>

	<ul class="slides slider-for">

	<?php while( have_rows('gallery') ): the_row();

		$image_id = get_sub_field('image');
		$image_size = 'large';
		$image_array = wp_get_attachment_image_src( $image_id, $image_size );
		$image_url = $image_array[0];
	?>
		<img src="<?php echo $image_url; ?>">

	<?php endwhile; ?>

	</ul>

	<?php endif; ?>

<!-- Gallery Navigation -->
	<?php if( have_rows('gallery') ): ?>

	<ul class="slider-nav c-gallery__wrapper o-content-block-wrap">

	<?php while( have_rows('gallery') ): the_row();

		$image_id = get_sub_field('image');
		$image_size = 'medium';
    $image_array = wp_get_attachment_image_src( $image_id, $image_size );
    $image_url = $image_array[0];

	?>
		<div class="c-gallery__single-image">
			<div class="c-content-block__img c-content-block__gallery-img">
				<img src="<?php echo $image_url; ?>">
			</div>
		</div>
	<?php endwhile; ?>

	</ul>

	<?php endif; ?>
