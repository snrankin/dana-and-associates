<?php get_header(); ?>
<div id="main-content" class="section-wrapper d-none">
	<div class="section-inner">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="content-wrapper">
						<div class="content-item">
							<h1 class="display-2 text-center">Search:</h1>
						</div>
						<div class="content-item">
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="content-wrapper">
						<div class="content-item">
							<h2 class="text-center">More Resources</h2>
						</div>
						<div class="content-item">
							<?php echo do_shortcode('[resources_menu]'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_component_template('cta');

get_footer(); ?>