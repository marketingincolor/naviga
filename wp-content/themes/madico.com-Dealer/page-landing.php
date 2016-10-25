<?php
/**
 * Template Name: Landing Page FULL
 * Landing page template without a sidebar
 */
get_header(); ?>

	<div class="splash span12">
		<?php include( 'banner.php'); ?>
	</div>
</div>
<div class="row-fluid">
	<?php show_breadcrumb(); ?>
	<div class="span12">
		<div class="row-fluid">
			<div class="span12">
				<?php the_post(); ?>
				<h1><?php the_title(); ?></h1>

				<div class="cms">
					<?php the_content(); ?>
				</div>
			</div>
			<!--<div class="sidebar"></div>-->
		</div>
	</div>

</div><!--// end #page -->
</div><!--// end #container -->
</div><!--// end #background -->
</div><!--// end #content -->

<?php get_footer(); ?>
