<?php /* Template Name: Home */ ?>
<?php get_header(); ?>

				<div class="REMOVEsplash">

				</div>

				<div id="REMOVEhome-banner">

				</div>

			</div><!-- end #page -->
		</div><!-- end #container -->
	</div><!-- end #background -->
</div><!-- end #content -->

<div id="home-form">
	<div class="container">
		<div class="row-fluid">
			<div class="span-12 directory-selector">
				<?php echo 'Insert Directory Form Shortcode/PHP in template HERE'; ?>
			</div>
		</div>
	</div>
</div>

<div id="content" notid="REMOVEhome-sections">
	<div id="REMOVEhome-sections-wrapper" class="sections">
		<div class="container">
			<div class="cms row-fluid">
				<div class="span-12">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div><!-- end #home-sections -->
</div>

<?php get_footer(); ?>
