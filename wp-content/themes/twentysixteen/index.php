<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php 

			$location = get_egw_member_location();

			$a = array (
				'post_status' => 'publish',
				'order'       => 'DESC',
				'tag'         => $location,

			);

			
			$b = array(
				
				//Type & Status Parameters
				'post_type'      => 'post',
				'post_status'    => 'publish',
				
				//Order & Orderby Parameters
				'order'          => 'DESC',
				'orderby'        => 'date',
				
				//Taxonomy Parameters
				'tax_query' => array(
				'relation'  => 'AND',
					array(
						'taxonomy'         => 'post_tag',
						'field'            => 'name',
						'terms'            =>  get_egw_branches(),
						'operator'         => 'NOT IN'
					),
				),
				
			);
		
		
		
		// $args = filter_posts_by_village_location_query();
		$a = new WP_Query($a); 	
		echo '<pre><h3>Query A</h3>';
		print_r($a->posts);
		echo '</pre>';
		
		$b = new WP_Query($b);
		echo '<pre><h3>Query B</h3>';
		print_r($b->posts);
		echo '</pre>';

		
		// $my_query = new WP_Query();
		// $my_query->posts =  array_merge( $a->posts, $b->posts ); 

		echo '<pre><h3>Final Query</h3>';
		// print_r($my_query);
		echo '</pre>';

		?>

		<?php 

			// foreach($my_query->posts as $post) : 
  	// 		setup_postdata( $post ); 
  	// 		get_template_part( 'template-parts/content', get_post_format() ); 

  	// 		endforeach; 
  		?>
		
		
		<?php if ( have_posts() ) : ?>


			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php



			// Start the loop.
			while ( have_posts() ) : the_post(); 

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				
	
				
				get_template_part( 'template-parts/content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentysixteen' ),
				'next_text'          => __( 'Next page', 'twentysixteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
