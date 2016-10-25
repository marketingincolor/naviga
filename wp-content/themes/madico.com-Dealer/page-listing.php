<?php
/**
 * Template Name: Dealer Listing
 *
 * Page template to show Dealer Listing Pages
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
			<div class="span6">
				<?php the_post(); ?>
				<h1 class="post-title"><?php the_title(); ?></h1>

				<div class="cms">
					<?php the_content(); ?>
				</div>

			</div><!--// end #main -->

			<div class="NOTsidebar span6">
				<?php get_sidebar(); ?>
			</div><!--// end #sidebar -->
		</div>
	</div><!--// end #columns -->

</div><!--// end #page -->
</div><!--// end #container -->
</div><!--// end #background -->
</div><!--// end #content -->

<?php get_footer(); ?>
