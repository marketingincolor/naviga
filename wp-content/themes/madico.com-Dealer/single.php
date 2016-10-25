<?php get_header(); ?>

	<div class="splash span12">
		<?php include( 'banner.php'); ?>
	</div>
</div>
<div class="row-fluid">
	<?php show_breadcrumb(); ?>

	<div class="span12">
		<div class="row-fluid">
			<div class="span8">
				<?php the_post(); ?>
				<h1 class="post-title"><?php the_title(); ?></h1>
				<ul class="postinfo clearfix">
					<li class="authordata"><?php the_time('M j, Y'); ?></li>
				</ul>
				<div class="cms">
					<?php the_content(); ?>
				</div>
				<?php comments_template(); ?>
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
