
				<article class="nugget-block">
				<?php edit_post_link(); ?>
				<?php if ( has_post_thumbnail() ): ?>
					<figure class="nugget-block__image">
						<?php the_post_thumbnail(); ?>
					</figure>
				<?php endif; ?>
					<main class="nugget-block__content">
						<h3><?php the_title(); ?></h3>
						<?php the_content(); ?>
					</main>
				</article>