<?php

/**
 * The template for displaying the footer
 */

global $welderpro_option; 

?>
<!-- footer -->
	<footer class="mover">
		<?php
				if (   is_active_sidebar( 'footer-area-1'  )



		or is_active_sidebar( 'footer-area-2' )



		or is_active_sidebar( 'footer-area-3'  )



		or is_active_sidebar( 'footer-area-4' )



	) { ?>
		<div class=" up-footer">
			<div class="container">
 <?php get_sidebar('footer');?>				
			</div>
		</div>
		<?php } ?>
	</footer> <!-- /footer -->
		<!-- #bottom-bar -->
	<?php if($welderpro_option['footer_text']) { ?>
	<section id="bottom-bar" class="mover copyright">
		<div class="container">
			<div class="row">
				<!-- .copyright -->
				<div class="copyright pull-left">
					<p><?php echo wp_kses( $welderpro_option['footer_text'], wp_kses_allowed_html('post') ); ?></p> 
				</div> <!-- /.copyright -->
				<!-- .credit -->
				<div class="credit pull-right">
					<p><?php echo esc_html($welderpro_option['created_text']); ?> </p>
				</div> <!-- /.credit -->
			</div>
		</div> 
	</section><!-- /#bottom-bar -->
	
<?php } ?>

<a class="icons-arrow-up7" id="top" href="#wrap"></a>
<?php wp_footer(); ?>
</div>
</body>
</html>