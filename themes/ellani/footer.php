    		<?
        $_menu_object = wp_get_nav_menu_object( 3 );
        $nav_menu_selected_title = $_menu_object->name;
        
        ?>
        <footer class="c-footer">
	    		<div class="o-wrap--padding-100 u-padding-top-30 u-padding-bottom-30">
		      		<div class="c-footer__title">
			      		<img src="<?php echo home_url();?>/wp-content/themes/ellani/img/logos/logo_2.png">
			      	</div>
              <section class="u-flex u-flex-space-between">
                <nav class="c-footer-menu c-footer-section">
                <h3><?php echo $nav_menu_selected_title; ?></h3>
                  <?php
                    $args = array(
                      'menu' => 'Links',
                      'theme_location' => 'footer-menu',
                      'container' => '',
                      'container_class' => '',
                      'menu_class' => '',
                      'menu_id' => '',
                      'depth' => 0
                    );
                    wp_nav_menu( $args );
                  ?>
                </nav>
                <article class="c-footer-section">
                <?php if ( is_active_sidebar( 'footer-area-1' ) ) : ?>
                  
                  <?php dynamic_sidebar( 'footer-area-1' ); ?>
                  
                <?php endif; ?>
                </article>
                <article class="c-footer-section">
                <?php if ( is_active_sidebar( 'footer-area-2' ) ) : ?>
                  
                  <?php dynamic_sidebar( 'footer-area-2' ); ?>
                  
                <?php endif; ?>
                </article>
                <article class="c-footer-section">
                <?php if ( is_active_sidebar( 'footer-area-3' ) ) : ?>
                  
                  <?php dynamic_sidebar( 'footer-area-3' ); ?>
                  
                <?php endif; ?>
                </article>
              </section>
            </div>
    		</footer>
    		<?php wp_footer(); ?> 
    	</body>
    </html>
		<!-- End Site Footer -->
