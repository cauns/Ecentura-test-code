<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Amphibious
 */
?>

	</div><!-- #content -->
<?php if ( is_active_sidebar( 'widget_footer_top' ) ) : ?>
    <?php dynamic_sidebar( 'widget_footer_top' ); ?>
<?php endif; ?>
	<footer id="colophon" class="site-footer">
		<!-- footer column -->
		<?php if ( is_active_sidebar( 'widget_footer' ) ) : ?>
			<div class="container">
			<div class="row">
			<?php dynamic_sidebar( 'widget_footer' ); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php
		// Site Info
		get_template_part( 'template-parts/site-info' );
		?>
	</footer><!-- #colophon -->

</div><!-- #page .site-wrapper -->

<div class="overlay-effect"></div><!-- .overlay-effect -->

<?php wp_footer(); ?>
</body>
</html>
