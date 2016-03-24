<?php
/**
 * @package YouWaffle_Widget
 * @version 1.6
 */
/*
Plugin Name: Assignment 3
Plugin URI: http://phoenix.sheridanc.on.ca/~ccit3437/
Description: This plugin was created for Assignment 3 of CCT460.
Author: Ralph Fawaz, Stefania Diaz, Zohair Hussain
Version: 1.0
Author URI: http://www.utm.utoronto.ca/
*/

?>
<?php 



class ShowCustomPost extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
		'classname' => 'widget_postblock',
		'description' => __( 'Posts the 6 latest posts in the "You Waffle Posts" post page.') );
		parent::__construct('show_custompost', __('Custom Post', 'youwaffle'), $widget_ops);
	}


	public function widget ( $args, $instance ) { 
		
    

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query();
$wp_query->query('post_type=YouWafflePost&posts_per_page=6' . '&paged=' . $paged);
?>

<?php if ($wp_query->have_posts()) : ?>

	<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		<div id="grid"> 
		  <?php the_post_thumbnail('thumbnail'); ?></a> 	
		</div>
	   </article>

	<?php endwhile; ?>
<?php endif; 
    
	}

}


add_action( 'widgets_init', function(){
     register_widget( 'ShowCustomPost' );
});


function custompost() {

	register_post_type( 'YouWafflePost',
		array(
			'labels' => array(
				'name' => __( 'You Waffle Posts' ),
				'singular_name' => __( 'You Waffle Post' )
			),
			'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);
}
add_action( 'init', 'custompost' );

?>