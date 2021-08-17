<?php 
define('WP_USE_THEMES', false);  
require_once('../../../wp-load.php');
$term_slug = $_POST['term_slug'];
if ($term_slug) {
    $args = array(  
        'post_type' => 'light-review', 
        'paged' => $paged, 
        'posts_per_page' => -1, 
        'tax_query' => array( 
            array( 
                'taxonomy' => 'reviews-category', //or tag or custom taxonomy
                'field' => 'slug', 
                'terms' => $term_slug 
            ) 
        )
    );

   $review_query = new \WP_Query($args);
}
    
?>
<?php
if($review_query->have_posts()){
    while($review_query->have_posts()) : $review_query->the_post(); 
                global $post;
                $post_featured_image = light_review_get_featured_image(get_the_ID(),'thumbinal');
                $content = get_the_excerpt();
                // $content = apply_filters('the_content', $content);
                // $content = str_replace(']]>', ']]&gt;', $content);

                 
            ?>
             <li>
                            <div class="col-md-12 review-item">
                                <div class="col-md-6 image_section">
                                    <a class="img_text" href="<?php the_permalink(); ?>>"><img src="<?php echo $post_featured_image; ?>" class="img-responsive review_img" alt="" />
                                        <span class="review-cat-left-banner">Buying guide</span></a>
                                    <p><a href="<?php the_permalink(); ?>" class="btn btn-block btn-info">more info</a></p>
                                </div>
                                
                                <div class="col-md-6 review_caption">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <hr>
                                    <p><?php echo $content; ?></p>
                                </div>
                            </div>
                        </li>
                     
<?php 
       endwhile;
}else{
    echo '<li><div class="col-md-12 review-item"><p class="text-danger">Reviews not found.</p></li></div>';
}
?>