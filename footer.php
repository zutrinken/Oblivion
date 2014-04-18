		<div id="footer">
			<div class="inner">
				<nav id="footer-navigation" role="navigation">
					<h2 class="visuallyhidden"><?php _e('Navigation','oblivion'); ?></h2>
					<?php wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'fallback_cb' => 'FALSE',
							'walker' => new My_Walker_Nav_Menu()
						)
					); ?>
					<div class="clear"></div>
				</nav>
			</div>
		</div>
		<script type="text/javascript">
			window.onload = function () {
				jQuery(function($) {
					$('#loading').fadeOut(500, function() {
						$(this).hide();
					});
					$('a').click(function() {
						if($(this).attr('href').indexOf(window.location.protocol + '//' + window.location.host) === 0) {
							$('#loading').fadeIn(500);
						}
					});
				});
			};
		</script>
		<?php wp_footer(); ?>
	</body>
</html>