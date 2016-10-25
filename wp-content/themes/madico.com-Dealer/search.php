<?php get_header(); ?>

	<div class="splash">
		<?php include( 'banner.php'); ?>
	</div><!--// end .splash -->
	
	<div class="breadcrumbs">
		<?php 
		// Search Count
		$allsearch = &new WP_Query("s=$s&showposts=-1"); 
		echo intval($allsearch->post_count) . ' ';
		_e('search results found for:'); 
		wp_reset_query();
		?>
	</div><!--// end .breadcrumbs -->

	<div id="columns">
	
	<div class="main search-results">
	
		<h1>&ldquo;<?php echo apply_filters('the_title', __($s) ); ?>&rdquo;</h1>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="entry">
			<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="entry-summary">
				<?php // Relevanssi search
				if (function_exists('relevanssi_the_excerpt')) { 
					relevanssi_the_excerpt(); 
				} else { 
					the_excerpt();
				} ?>
			</div><!-- .entry-summary -->
			<p class="permalink"><a href="<?php the_permalink(); ?>"><?php echo urldecode( get_permalink() ); ?></a></p>
		</div>
 
<?php endwhile; ?>
		
		<?php madico_pagination(); ?>

<?php else: ?>

		<h2>Sorry, nothing matched your search criteria.</h2>
		<p>Please feel free to try again!<p/>
		<p><?php include('searchform.php'); ?></p>
 
<?php endif; ?>
     
	</div><!-- end .main -->

	<div class="sidebar">
		<?php get_sidebar(); ?>
	</div>
		
	</div><!--// end #columns -->
	</div><!--// end #page -->

</div><!--// end #container -->
</div><!--// end #background -->
</div><!--// end #content -->

<?php get_footer(); ?>