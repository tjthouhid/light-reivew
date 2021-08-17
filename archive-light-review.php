<?php
/* Template Name: Light Reviews  */
get_header();


$args = array(
		'post_type' => 'light-review',
		'post_status' => 'publish',
		'order' => "ASC",
		'orderby' => "ID",
		'posts_per_page' => -1
);

$review_query = new WP_Query($args);
?>

<link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/font-awesome.min.css",__FILE__ );?>" />
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/bootstrap.min.css",__FILE__ );?>" />
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/style.css",__FILE__ );?>" />
<script type="text/javascript" src="<?php echo plugins_url("js/jquery.js",__FILE__ );?>"></script>
<script type="text/javascript" src="<?php echo plugins_url("js/bootstrap.min.js",__FILE__ );?>"></script>
<?php 
    global $wp;
    $current_url = home_url( add_query_arg( array(), $wp->request ) );
?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".category_list").click(function(event) {
            event.preventDefault();
            var slug = $(this).data('slug');
            var term_id = $(this).data('term_id');
            var url="<?php echo plugins_url();?>";
            var newHREF='<?php echo $current_url;?>/'+slug;
            
            $.ajax({
                url: url+'/light-review/action.php',
                type: 'POST',
                dataType: 'html',
                data: {term_id: term_id},
            })
            .done(function(html) {
                history.pushState('', slug, newHREF);
                $("#review-list").html(html);
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            });
            
        });
    });
</script>
<section id="review" class="review-section">
    <div class="container">

        <div class="row">
            <div class="col-md-3">
                <h4>Filter By:</h4>
                <?php 
                    $categories =  get_categories();
                    echo '<ul class="categories">';
                    foreach  ($categories as $category) {
                      echo '<li class="category_list" data-slug="'.$category->slug.'" data-term_id="'.$category->term_id.'"><a href="#">'. $category->cat_name .'</a></li>';
                    }
                    echo '</ul>';
                ?>
            </div>
            <div class="col-md-8">
                
                <!-- Start review items -->
                <ul id="review-list">
                    <?php
                        while($review_query->have_posts()) : $review_query->the_post(); 
                        global $post;
                        $post_featured_image = light_review_get_featured_image(get_the_ID(),'thumbinal');
                        $content = get_the_content();   
                    ?>
                    <li>
                        <div class="col-md-12 review-item">
                            <div class="col-md-6 image_section">
                                <a href="<?php echo home_url();?>/<?php echo $post->post_name?>"><img src="<?php echo $post_featured_image; ?>" class="img-responsive review_img" alt="" /></a>
                                <p><a href="" class="btn btn-block btn-info">more info</a></p>
                            </div>
                            
                            <div class="col-md-6 review_caption">
                                <h3><a href="<?php echo home_url();?>/<?php echo $post->post_name?>"><?php the_title(); ?></a></h3>
                                <hr>
                                <p><?php echo $content; ?></p>
                            </div>
                        </div>
                    </li>
                             
                    <?php endwhile; ?>                  
                </ul>
                <!-- End review items -->
            </div>
            
        </div>
    </div>
</section>
<?php get_footer(); ?>

