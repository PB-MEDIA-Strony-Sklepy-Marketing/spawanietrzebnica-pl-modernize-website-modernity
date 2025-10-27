<?php
get_header(); ?>

<!-- subheader begin -->

<section class="rich-header">            
    	<div class="container">
        <h1 class="page-title">
           <?php if($welderpro_option['blog_title'])
             echo esc_html($welderpro_option['blog_title']);
            else
            esc_html_e('Blogs', 'welderpro'); ?>
            
         </h1>
		<?php welderpro_breadcrumbs(); ?>
    	</div>
</section>

<!-- subheader close -->

<!-- content begin -->

<div id="content" class="blog-section">

    <div class="container">

        <div class="row">

            <div class="col-md-8 blog-box white-left">

                <div class="blog-list">

                 <?php if(have_posts()) : ?>  



                  <?php 

                  while (have_posts()) : the_post();

                  get_template_part( 'content', get_post_format() ) ;   // End the loop

                  endwhile;
                  
                  ?>


                <?php else: ?>



                    <h1><?php esc_html_e('Nothing Found Here!','welderpro'); ?></h1>



                <?php endif; ?>



                </div>



                <div class="pagination text-center ">

                    <ul class="pagination-list">

                        <?php echo welderpro_pagination(); ?>

                    </ul>

                </div>

            </div>



            <div class="col-md-4">

                <?php get_sidebar();?>

            </div>

        </div>

    </div>

</div>

<!-- content close -->

<?php get_footer(); ?>

