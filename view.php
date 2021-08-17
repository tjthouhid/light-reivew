    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/font-awesome.min.css",__FILE__ );?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/bootstrap.min.css",__FILE__ );?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/style.css",__FILE__ );?>" />
    <script type="text/javascript" src="<?php echo plugins_url("js/jquery.js",__FILE__ );?>"></script>
    <script type="text/javascript" src="<?php echo plugins_url("js/bootstrap.min.js",__FILE__ );?>"></script>
    <?php 
        
        $current_url = home_url( add_query_arg( array(), $wp->request ) );
       
        
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".close_h3").on('click', function(event) {
                event.preventDefault();
                $(".hide_h3").fadeOut('slow');

            });
            $(".category_list").click(function(event) {
                event.preventDefault();
                var slug = $(this).data('slug');
                $('.filter_text').text(slug);
                var term_id = $(this).data('term_term_slugid');
                var url="<?php echo plugins_url();?>";
                var newHREF='<?php echo $current_url;?>/'+slug;
                
                $.ajax({
                    url: url+'/light-review/action.php',
                    type: 'POST',
                    dataType: 'html',
                    data: {term_slug: slug},
                })
                .done(function(html) {
                    history.pushState('', slug, newHREF);
                    $("#review-list").html(html);
                    $(".review-cat-left-banner").text(slug);
                    console.log("success");
                })
                .fail(function() {
                    console.log("error");
                });
                
            });
        });
    </script>
    <section id="review" class="review-section">

            <div class="row">
                <div class="col-md-3">
                    <h4 class="hide_h3">Choose Filters: <span class="filter_text">All reviews</span><span class="text-danger close_h3">X</span></h4>

                    <h4>Filter By:</h4>
                    <?php 
                        //$categories =  get_categories();
                        $args = array(
                            'taxonomy'      => array( 'reviews-category' ), // taxonomy name
                            'orderby'       => 'id', 
                            'order'         => 'ASC',
                            'hide_empty'    => false,
                            "parent" => 0
                        ); 

                        $categories = get_terms( $args );
                        
                        echo '<nav class="navigation"><ul class="mainmenu">';
                        foreach  ($categories as $category) {
                          echo '<li><a href="#" class="category_list" data-slug="'.$category->slug.'" data-term_id="'.$category->term_id.'"  data-toggle="collapse" data-target="#submenu'.$category->term_id.'" aria-expanded="false">'. $category->name .'</a>';
                            $term_id = $category->term_id;
                            $taxonomy_name = 'reviews-category';
                            $term_children = get_term_children( $term_id, $taxonomy_name );
                            echo '<ul class="nav collapse" id="submenu'.$term_id.'" role="menu">';
                            foreach ( $term_children as $child ) {
                                $term = get_term_by( 'id', $child, $taxonomy_name );
                                echo '<li><a href="' . get_term_link( $child, $taxonomy_name ) . '" class="category_list" data-slug="'.$term->slug.'" data-term_id="'.$term->term_id.'">' . $term->name . '</a></li>';
                            }
                            echo '</ul></li>';
                        }
                        echo '</ul></nav>';
                    ?>
                </div>
                <div class="col-md-8">
                    
                    <!-- Start review items -->
                    <ul id="review-list">
                        <?php
                            while($review_query->have_posts()) : $review_query->the_post(); 
                            global $post;
                            $post_featured_image = light_review_get_featured_image(get_the_ID(),'thumbinal');
                            $content = get_the_excerpt();
                        ?>
                        <li>
                            <div class="col-md-12 review-item">
                                <div class="col-md-6 image_section">
                                    <a class="img_text" href="<?php the_permalink(); ?>"><img src="<?php echo $post_featured_image; ?>" class="img-responsive review_img" alt="" />
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
                                 
                        <?php endwhile; ?>                  
                    </ul>
                    <!-- End review items -->
                </div>
                
            </div>
    </section>

