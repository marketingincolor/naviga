<?php
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

	<div class="splash span12">
		<?php include( 'banner.php'); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">

		<div class="row-fluid">
			<div class="span8">

			<h1>Blog<?php if( $paged != 1 ) echo ' &ndash; Page ' . $paged; ?></h1>

				<div class="cms">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<div <?php post_class('clearfix excerpt'); ?> id="post-<?php the_ID(); ?>">

						<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>

						<ul class="postinfo clearfix">
							<li class="authordata"><?php the_time('M j, Y'); ?><!-- at <?php the_time() ?>--></li>
						</ul>

						<div class="entry clearfix">
							<?php the_excerpt();?>
						</div><!--// end #entry -->

					</div><!--// end #post-<?php the_ID(); ?> -->

					<?php endwhile; ?>

						<?php madico_pagination(); ?>

					<?php else : ?>

						<h2 class="title">Oops</h2>
						<p>Looks like something is missing...</p>

					<?php endif; ?>
				</div>
			</div>

			<div class="NOTsidebar span4">
				<?php get_sidebar(); ?>
			</div>

		</div>
	</div>

</div><!--// end #page -->
</div><!--// end #container -->
</div><!--// end #background -->
</div><!--// end #content -->

<?php get_footer(); ?>
