<?php 

	/**
		* Plugin Name: Wordpress Light Review
		* Plugin URI: http://www.thecreativex.com/light-review
		* Description: This is plugin for creating user review.
		* Version: 1.0.1
		* Author: juman
		* Author URI: https://www.tjthoouhid.me
		* License: A "Slug" license name e.g. GPL12
	**/
	/**
	* Registers a new post type
	* @uses $wp_post_types Inserts new testimonal post type object into the list
	* @param 
	* @return true
	*/

	function light_review_post_type_register(){

		$labels = array(
			'name'                => __( 'Light review', 'thecreativex-light-review' ),
			'singular_name'       => __( 'Light review', 'thecreativex-light-review' ),
			'add_new'             => _x( 'Add New review', 'thecreativex-light-review', 'thecreativex-light-review' ),
			'add_new_item'        => __( 'Add New review', 'thecreativex-light-review' ),
			'edit_item'           => __( 'Edit review', 'thecreativex-light-review' ),
			'new_item'            => __( 'New review', 'thecreativex-light-review' ),
			'view_item'           => __( 'View review', 'thecreativex-light-review' ),
			'search_items'        => __( 'Search reviews', 'thecreativex-light-review' ),
			'not_found'           => __( 'No reviews found', 'thecreativex-light-review' ),
			'not_found_in_trash'  => __( 'No reviews found in Trash', 'thecreativex-light-review' ),
			'parent_item_colon'   => __( 'review:', 'thecreativex-light-review' ),
			'menu_name'           => __( 'review', 'thecreativex-light-review' ),
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'description',
			//'taxonomies'          => array('category'),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 25.5,
			'menu_icon'           => null,
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			//'register_meta_box_cb' => 'add_light_review_meta',
			'supports'            => array(
				'title', 'thumbnail','page-attributes','editor'
				)
		);

		register_post_type( 'light-review', $args );

		register_taxonomy(
		        'reviews-category',
		        'light-review',
		        array(
		            'label' => __( 'Category' ),
		            'rewrite' => array( 'slug' => 'reviews-category' ),
		            'hierarchical' => true,
		        )
		    );

	}
	add_action('init','light_review_post_type_register');


    function light_review_get_featured_image($post_ID,$size) {
	    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
	    if ($post_thumbnail_id) {
	        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, $size);
	        return $post_thumbnail_img[0];
	    }
	}
	

	include 'create-shortcode.php';
    

	function wpse_288373_register_submenu_page() {
	    add_submenu_page('edit.php?post_type=light-review', 'Review settings', 'Settings', "manage_options", 'settings', 'wpse_288373_review_settings', '');
	}

	add_action('admin_menu', 'wpse_288373_register_submenu_page');

	/**
	 * Register submenu page
	 *
	 * Function is used by add_submenu_page function
	 */
	function wpse_288373_review_settings() {
	    echo "<p>use [light_review] as shortcode.</p>";
	}


	function add_query_vars($aVars) {
	$aVars[] = "new_reviews_cat"; // represents the name of the product category as shown in the URL
	return $aVars;
	}
	 
	// hook add_query_vars function into query_vars
	add_filter('query_vars', 'add_query_vars');

	function add_rewrite_rules($aRules) {
	$aNewRules = array('reviews/([^/]+)/?$' => 'index.php?pagename=reviews&new_reviews_cat=$matches[1]');
	$aRules = $aNewRules + $aRules;
	return $aRules;
	}
	 
	// hook add_rewrite_rules function into rewrite_rules_array
	add_filter('rewrite_rules_array', 'add_rewrite_rules');

	/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/
 
add_filter( 'template_include', 'rc_tc_template_chooser');
 
/*
|--------------------------------------------------------------------------
| PLUGIN FUNCTIONS
|--------------------------------------------------------------------------
*/
 
/**
 * Returns template file
 *
 * @since 1.0
 */
 
function rc_tc_template_chooser( $template ) {
 
    // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'testimonial' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return rc_tc_get_template_hierarchy( 'single' );
    }
 
}
?>