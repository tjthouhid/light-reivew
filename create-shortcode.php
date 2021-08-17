<?php 
	function light_review_shortcode($atts){
		$atts = shortcode_atts(array(

				'posts_per_page' => -1,
				'order' => 'ASC',
				'orderby' => 'ID'

			),$atts,'light_review_something');
		global $wp;
		if(isset($wp->query_vars['new_reviews_cat'])) {
		 $sMsdsCat = urldecode($wp->query_vars['new_reviews_cat']);
			$args = array(
					'post_type' => 'light-review',
					'post_status' => 'publish',
					'order' => $atts['order'],
					'orderby' => $atts['orderby'],
					'posts_per_page' => $atts['posts_per_page'],
					'tax_query' => array( // NOTE: array of arrays!
					        array(
					            'taxonomy' => 'reviews-category',
					            'field'    => 'slug',
					            'terms'    => $sMsdsCat
					          
					        )
					    )
			);
		}else{
		  $args = array(
		  		'post_type' => 'light-review',
		  		'post_status' => 'publish',
		  		'order' => $atts['order'],
		  		'orderby' => $atts['orderby'],
		  		'posts_per_page' => $atts['posts_per_page']
		  );
		}

		
		
		$review_query = new WP_Query($args);
		//echo "<pre>";
		//print_r($review_query);

		include dirname(__FILE__).'/view.php';
	}
	add_shortcode('light_review','light_review_shortcode');
?>