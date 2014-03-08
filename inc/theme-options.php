<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

// Einstellungen registrieren (http://codex.wordpress.org/Function_Reference/register_setting)
function theme_options_init(){
	register_setting( 'oblivion_options', 'oblivion_theme_options', 'oblivion_validate_options' );
}

// Seite in der Dashboard-Navigation erstellen
function theme_options_add_page() {
	// Seitentitel, Titel in der Navi, Berechtigung zum Editieren (http://codex.wordpress.org/Roles_and_Capabilities) , Slug, Funktion
	add_theme_page('Theme-Options', 'Theme-Options', 'edit_theme_options', 'theme-options', 'oblivion_theme_options_page' );
}

// Optionen-Seite erstellen
function oblivion_theme_options_page() {
	global $select_options, $radio_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false; ?>

	<div class="wrap">

		<!-- Titel -->
		<?php screen_icon(); ?><h2><?php _e('oblivion Theme-Options','oblivion'); ?></h2> 

		<!-- Message -->
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade">
			<p><strong><?php _e('Settings saved!','oblivion'); ?></strong></p>
		</div>
		<?php endif; ?>

		<!-- Settings -->
		<form method="post" action="options.php">
			<?php settings_fields( 'oblivion_options' ); ?>
			<?php $options = get_option( 'oblivion_theme_options' ); ?>

			<h3><?php _e('Graphics','oblivion'); ?></h3>
			<p><?php printf(__('Choose an Image from your <a target="_blank" href="%s/wp-admin/upload.php">Library</a> or <a target="_blank" href="%s/wp-admin/media-new.php">upload</a> a new one.','oblivion'), get_home_url(), get_home_url()); ?></p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Logo</th>
					<td>
						<input id="oblivion_theme_options[logo]" class="regular-text" type="text" name="oblivion_theme_options[logo]" value="<?php esc_attr_e( $options['logo'] ); ?>" />
						<?php if($options['logo'] == TRUE) : ?>
							<img style="max-width: 240px; vertical-align: top;margin: 0 0 0 20px;" src="<?php esc_attr_e( $options['logo'] ); ?>" alt="" />
						<?php endif; ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Icon</th>
					<td>
						<input id="oblivion_theme_options[icon]" class="regular-text" type="text" name="oblivion_theme_options[icon]" value="<?php esc_attr_e( $options['icon'] ); ?>" />
						<?php if($options['icon'] == TRUE) : ?>
							<img style="max-width: 72px; vertical-align: top;margin: 0 0 0 20px;" src="<?php esc_attr_e( $options['icon'] ); ?>" alt="" />
						<?php endif; ?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Touch Icon</th>
					<td>
						<input id="oblivion_theme_options[touch-icon]" class="regular-text" type="text" name="oblivion_theme_options[touch-icon]" value="<?php esc_attr_e( $options['touch-icon'] ); ?>" />
						<?php if($options['touch-icon'] == TRUE) : ?>
							<img style="max-width: 44px; vertical-align: top;margin: 0 0 0 20px;" src="<?php esc_attr_e( $options['touch-icon'] ); ?>" alt="" />
						<?php endif; ?>
					</td>
				</tr>
			</table>

			<h3><?php _e('Frontpage','oblivion'); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Side Posts</th>
					<td>
						<input id="oblivion_theme_options[sideposts]" class="short-text" type="text" name="oblivion_theme_options[sideposts]" value="<?php esc_attr_e( $options['sideposts'] ); ?>" /> <span class="description"> <?php _e('set category ID (only one ID)','oblivion'); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Youtube</th>
					<td><input id="oblivion_theme_options[youtube]" class="regular-text" type="text" name="oblivion_theme_options[youtube]" value="<?php esc_attr_e( $options['youtube'] ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Twitter</th>
					<td><input id="oblivion_theme_options[twitter]" class="regular-text" type="text" name="oblivion_theme_options[twitter]" value="<?php esc_attr_e( $options['twitter'] ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Facebook</th>
					<td><input id="oblivion_theme_options[facebook]" class="regular-text" type="text" name="oblivion_theme_options[facebook]" value="<?php esc_attr_e( $options['facebook'] ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Google +</th>
					<td><input id="oblivion_theme_options[google]" class="regular-text" type="text" name="oblivion_theme_options[google]" value="<?php esc_attr_e( $options['google'] ); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Newsletter</th>
					<td><input id="oblivion_theme_options[newsletter]" class="regular-text" type="text" name="oblivion_theme_options[newsletter]" value="<?php esc_attr_e( $options['newsletter'] ); ?>" /></td>
				</tr>
			</table>

			<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save','oblivion'); ?>" /></p>
		</form>
	</div>
<?php }

function oblivion_validate_options($input) {
	// $input['copyright'] = wp_filter_nohtml_kses( $input['copyright'] );
	return $input;
}

?>