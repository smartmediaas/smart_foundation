<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package smart_foundation
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer row" role="contentinfo">
		<div class="site-info columns medium-12">
			<?php do_action( 'smart_credits' ); ?>
			<?php _e('Built on WordPress by', 'smart'); ?> <a href="http://smartmedia.no/" title="Smart Media" target="_blank">Smart Media AS</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<script>
	jQuery(document).ready(function($) {
		$(window).on('resize load', function() {
			$(document).foundation({
				topbar: {
					sticky_class: "sticky-topbar",
					custom_back_text: true,
					back_text: "<?php _e('Back', 'smart'); ?>",
					scrolltop: false,
					mobile_show_parent_link: true,
				},
				// offcanvas: {},
			});
		});
	});
</script>

<?php wp_footer(); ?>

</body>
</html>
