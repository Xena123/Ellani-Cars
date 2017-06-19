<div class="">
	<div class="c-single-vehicle__fact-group-wrap u-margin-bottom-15">
		<header class="c-single-vehicle__fact-group-header-1 u-blue-background u-flex--init u-flex-space-between u-flex-center u-padding-20 u-text-white">
			<h2 class="u-uppercase">Key Facts</h2>
			<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_up.png" class="c-caret-down c-caret-down-1">
			<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_down.png" class="c-caret-up">
		</header>
		<div class="c-single-vehicle__fact-group c-single-vehicle__fact-group-1 u-padding-20 u-flex u-flex-space-between u-flex-top u-uppercase u-background--grey">
			<div class="c-sgl-vehicle__sgl-fact__with-img u-flex--init u-padding-bottom-10">
				<div class="u-inline-block u-margin-right-10 u-width-30--init">
					<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/year.png" class="">
				</div>
				<div class="">
					<h5 class="u-padding-bottom-5">Model Year</h5>
					<h5 class="u-fw-600"><?php the_field('year'); ?></h5>
				</div>
			</div>
			<div class="c-sgl-vehicle__sgl-fact__with-img u-flex--init u-padding-bottom-10">
				<div class="u-inline-block u-margin-right-10 u-width-30--init">
					<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/fuel_type.png" class="">
				</div>
				<div class="">
					<h5 class="u-padding-bottom-5">Fuel Type</h5>
					<h5 class="u-fw-600"><?php the_field('fuel'); ?></h5>
				</div>
			</div>
			<div class="c-sgl-vehicle__sgl-fact__with-img u-flex--init u-padding-bottom-10">
				<div class="u-inline-block u-margin-right-10 u-width-30--init">
					<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/mileage.png" class="">
				</div>
				<div class="">
					<h5 class="u-padding-bottom-5">Mileage</h5>
					<h5 class="u-fw-600"><?php the_field('mileage'); ?></h5>
				</div>
			</div>
			<div class="c-sgl-vehicle__sgl-fact__with-img u-flex--init u-padding-bottom-10">
				<div class="u-inline-block u-margin-right-10 u-width-30--init">
					<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/transmission.png" class="">
				</div>
				<div class="">
					<h5 class="u-padding-bottom-5">Transmission</h5>
					<h5 class="u-fw-600"><?php the_field('transmission'); ?></h5>
				</div>
			</div>
			<div class="c-sgl-vehicle__sgl-fact__with-img u-flex--init">
				<div class="u-inline-block u-margin-right-10 u-width-30--init">
					<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/engine.png" class="">
				</div>
				<div class="">
					<h5 class="u-padding-bottom-5">Engine Size</h5>
					<h5 class="u-fw-600"><?php the_field('engine'); ?>L</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="c-single-vehicle__fact-group-wrap u-margin-bottom-15">
		<header class="c-single-vehicle__fact-group-header c-single-vehicle__fact-group-header-2 u-blue-background u-flex--init u-flex-center u-flex-space-between u-padding-20 u-text-white">
			<h2 class="u-uppercase">Running Costs</h2>
			<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_up.png" class="c-caret-up">
			<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_down.png" class="c-caret-down c-caret-down-2">
		</header>
		<div class="c-single-vehicle__fact-group c-single-vehicle__fact-group-2 u-flex-top u-uppercase u-background--grey u-padding-20">
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Urban mpg</h5>
				<h5 class="u-fw-600"><?php the_field('urban_mpg'); ?> mpg</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Extra Urban mpg</h5>
				<h5 class="u-fw-600"><?php the_field('extra_urban_mpg'); ?> mpg</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Average mpg</h5>
				<h5 class="u-fw-600"><?php the_field('average_mpg'); ?> mpg</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">CO2 emissions</h5>
				<h5 class="u-fw-600"><?php the_field('co2_emissions'); ?> g/km</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Annual Tax</h5>
				<h5 class="u-fw-600">£<?php the_field('annual_tax'); ?></h5>
			</div>
		</div>
	</div>
	<div class="c-single-vehicle__fact-group-wrap u-margin-bottom-15">
		<header class="c-single-vehicle__fact-group-header c-single-vehicle__fact-group-header-3 u-blue-background u-padding-20 u-text-white u-flex--init u-flex-space-between u-flex-center">
			<h2 class="u-uppercase">Performance</h2>
			<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_up.png" class="c-caret-up">
			<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_down.png" class="c-caret-down c-caret-down-3" >
		</header>
		<div class="c-single-vehicle__fact-group c-single-vehicle__fact-group-3 u-uppercase u-background--grey u-padding-20">
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Engine power</h5>
				<h5 class="u-fw-600"><?php the_field('engine_power'); ?> bhp</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase">Engine size</h5>
				<h5 class="u-fw-600"><?php the_field('engine_size'); ?> cc</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Brochure Engine size</h5>
				<h5 class="u-fw-600"><?php the_field('brochure_engine_size'); ?> litres</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Acceleration (0-60mph)</h5>
				<h5 class="u-fw-600"><?php the_field('acceleration'); ?> seconds</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Top speed</h5>
				<h5 class="u-fw-600"><?php the_field('top_speed'); ?> mph</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">Drivetrain</h5>
				<h5 class="u-fw-600"><?php the_field('drivetrain'); ?></h5>
			</div>
		</div>
	</div>
	<div class="c-single-vehicle__fact-group-wrap--last">
		<header class="c-single-vehicle__fact-group-header c-single-vehicle__fact-group-header-4 u-blue-background u-padding-20 u-text-white u-flex--init u-flex-space-between u-flex-center">
			<h2 class="u-uppercase">Practicality</h2>
			<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_up.png" class="c-caret-up">
			<img src="<?php echo home_url(); ?>/wp-content/themes/ellani/img/icons/caret_down.png" class="c-caret-down c-caret-down-4">
		</header>
		<div class="c-single-vehicle__fact-group c-single-vehicle__fact-group-4 u-uppercase u-background--grey u-padding-20">
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">No. of Doors</h5>
				<h5 class="u-fw-600"><?php the_field('no_of_doors'); ?> bhp</h5>
			</div>
			<div class="c-single-vehicle__single-fact u-flex-column">
				<h5 class="u-uppercase u-padding-bottom-5">No. of Seats</h5>
				<h5 class="u-fw-600"><?php the_field('no_of_seats'); ?> cc</h5>
			</div>
		</div>
	</div>
</div>