<!--     <link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/font-awesome.min.css",__FILE__ );?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url("css/style.css",__FILE__ );?>" />
    <script type="text/javascript" src="<?php echo plugins_url("js/jquery.js",__FILE__ );?>"></script>
 <!-- Start Blog Page Section -->
        <section id="review" class="review-section">
        <div class="container">

            <div class="row">
                
                <!-- Start Blog Body Section -->
                    
                <!-- Start Blog post -->
            <div class="col-md-12">
            <?php 
                while(have_posts()) : the_post();
            ?>
            <div class="">
                <div class="post-img">
                  <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('',array('class' => ' img-responsive')); ?></a>
                </div>
                <h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                
                <p class="post-content"><?php the_content(); ?></p>
            </div>

            <?php endwhile; ?>

            <!-- End Blog Post -->
            </div>

        <!-- End Blog Body Section -->
                
                
            </div>
        </div>
    </section> -->