<?php 
/**
 * 404 - Page Not Found
 */
get_header(); 
?>

	<div class="splash">
		<?php include( 'banner.php'); ?>
	</div>
	
	<?php show_breadcrumb(); ?>
	
	<div id="columns" class="events">
	
		<div class="main">
			<?php the_post(); ?>
			<h1 class="post-title">This page is missing&hellip;</h1>

			<div class="cms">
				<h2>We're very sorry, but this page doesn't exist or has been moved.</h2>
				<ol>
					<li>Please make sure you have the right URL.</li>
					<li>If you still can't find what you're looking for, try using the search form below.</li>
				</ol>
				<p>We're sorry for any inconvenience.</p>
				<?php get_search_form(); ?>
			</div>
		</div>

		<div class="sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div><!--// end #columns -->

</div>

</div>
</div>
</div>

<?php get_footer(); ?>