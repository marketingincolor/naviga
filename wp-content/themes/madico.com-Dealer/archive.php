<?php get_header(); ?>

	<div class="splash" id="archive-splash">
		<?php include( 'banner.php'); ?>
	</div>

	<div id="columns">
		<div class="main">
					
		<?php $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; ?>
		<h1 class="breadcrumb"><?php single_cat_title(); if( $paged != 1 ) echo ' &ndash; Page ' . $paged; ?></h1>
		
		<div class="cms">
<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>

			<div <?php post_class('clearfix excerpt'); ?> id="post-<?php the_ID(); ?>">
				<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				
				<ul class="postinfo clearfix">
					<li class="authordata"><?php the_time( get_option('date_format') ); ?></li>
				</ul>
				
				<div class="entry clearfix">
					<?php the_excerpt();?>
				</div><!--// end #entry -->
			</div><!--// end #post-XX -->

<?php endwhile; ?>
			<?php madico_pagination(); ?>
<?php else : ?>
			<h2 class="title">Nothing found</h2>
			<p>No posts have been found&hellip;</p>
<?php endif; ?>

		</div>
		
		</div>

		<div class="sidebar">
			<?php get_sidebar(); ?>
		</div>

	</div>

</div>

</div>
</div>
</div>

<?php get_footer(); ?>