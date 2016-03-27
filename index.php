<<<<<<< HEAD
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

//This creates a widget that looks at the day of the week and posts something based on the day. Code based off of: http://stackoverflow.com/questions/6450539/display-php-object-depending-on-day-of-the-week

class OnLocationWhereAreWe extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
		'classname' => 'widget_weekday',
		'description' => __( 'Tells you where we are on what day of the week.') );
		parent::__construct('on_location', __('On Location', 'youwaffle'), $widget_ops);
	}


	public function widget ( $args, $instance ) { 
		
    
    $d=date("D");
    if ($d=="Mon")
      echo "We are at UTSG today!"; 
    elseif ($d=="Tue")
      echo "We are at UTM today!"; 
    elseif ($d=="Wed")
      echo "We are at UTSG today!"; 
    elseif ($d=="Thu")
      echo "We are at UTM today!"; 
    elseif ($d=="Fri")
      echo "We are at UTSC today!"; 
    elseif ($d=="Sat")
      echo "We are closed"; 
    elseif ($d=="Sun")
      echo "We are closed"; 
    else
      echo "Have a nice day!";
    
	}

}

add_action( 'widgets_init', function(){
     register_widget( 'OnLocationWhereAreWe' );
});


?>
<?php 


//This creates a widget that shows the 6 latest posts from the custom post type 'YouWafflePost'. This code is based from Lab 2.

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

// Create custom post type. Info found: https://codex.wordpress.org/Post_Types
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

// Shortcode displays latest 6 posts
function latest_custom ( $atts) {
		extract( shortcode_atts(
			$wp_query = new WP_Query();
			$wp_query->query('post_type=YouWafflePost', 
			'posts_per_page=6',
			)'order=DESC',
			), $atts );
			
		return '<div class="ShowCustomPost">';
}
add_shortcode('latest_custom', 'latest_custom');

?>