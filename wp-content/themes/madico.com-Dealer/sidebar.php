<?php
global $post, $section, $sf_page_id, $wf_page_id, $sf_category_id, $wf_category_id, $language;
$cat = get_query_var('cat');
?>
<ul>
	<?php
	/*if ( $sidebar_nav = madico_sidebar_nav() )
		echo $sidebar_nav;*/
	?>

	<?php //if( function_exists('madico_related_links') ) madico_related_links(); ?>

    <?php
    // Dynamic sidebars
	/*if ( is_page($wf_page_id) || ( isset($post->ancestors) && in_array($wf_page_id, $post->ancestors) ) ) {
		if ( !is_page('contact') )
            dynamic_sidebar('Window Film Pages');
	}
	elseif ( is_page($sf_page_id) || ( isset($post->ancestors) && in_array($sf_page_id, $post->ancestors) ) ) {
		dynamic_sidebar('Specialty Film Pages');
	}
	elseif ( is_page() )  {
		dynamic_sidebar('General Page');
	}
	else {
		dynamic_sidebar('Blog');
	}*/
	?>

	<?php
	    //dynamic_sidebar('Window Film Pages');
	?>
</ul>

<div class="NOTsidebar NOTcolumns">

	<div id="secondary" class="secondary NOTcolumns">

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div id="widget-area" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<div id="widget-area" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
			<div id="widget-area" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-3' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>

	</div><!-- .secondary -->
</div>
