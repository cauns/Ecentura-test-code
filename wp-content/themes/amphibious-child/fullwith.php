<?php
/*
 Template Name: Full With
 */
 get_header(); ?>
 <div class="site-content-inside">
		<div class="container">
			<div class="row">

				<div id="primary" class="content-area col-16 col-sm-16 col-md-16 col-lg-16 col-xl-16 ">
					<main id="main" class="site-main">

						<div id="post-wrapper" class="post-wrapper post-wrapper-single post-wrapper-single-page">
						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'template-parts/content', 'page' ); ?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || '0' != get_comments_number() ) :
									comments_template();
								endif;
							?>

						<?php endwhile; // end of the loop. ?>
						</div><!-- .post-wrapper -->

					</main><!-- #main -->
				</div><!-- #primary -->

				

			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .site-content-inside -->

<?php get_footer(); ?>