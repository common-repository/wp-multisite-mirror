<?php
/*
Plugin Name: Mirror Multi Sites (MMS)
Plugin URI: https://github.com/kien/wordpress-multisites-mirror
Description: Mirroring sites between different WP Multisite setups. <a href="plugins.php?page=mms_settings_page">Configuration page</a>. <strong>Deactivate this plugin before creating new subsite(s)</strong>.
Version: 0.2
Author: Kien N
Author URI: http://designtomarkup.com
 */
function table_prefix_switch() {
	global $wpdb, $table_prefix;
	
	// store original tables
	$options = $wpdb->options;
	$users = $wpdb->users;
	$usermeta = $wpdb->usermeta;
	$blogs = $wpdb->blogs;
	$blog_versions = $wpdb->blog_versions;
	$site = $wpdb->site;
	$sitemeta = $wpdb->sitemeta;
	$signups = $wpdb->signups;
	$sitecategories = $wpdb->sitecategories;
	$registration_log = $wpdb->registration_log;
	
	// switch table_prefix and blog_id
	$ms_site_prefix = get_option('ms_site_prefix');
	$ms_site_id = get_option('subsite_site_id');
	if (empty($ms_site_prefix)) {
		$wpdb->set_prefix('wp_');
		$table_prefix = 'wp_';
	} else {
		$wpdb->set_prefix($ms_site_prefix);
		$table_prefix = $ms_site_prefix;
	}
	// skip changing blog_id on selected pages
	if (!empty($ms_site_id)
		&& !strpos($_SERVER['REQUEST_URI'], 'users.php')
		&& !strpos($_SERVER['REQUEST_URI'], 'user-new.php')
		&& !strpos($_SERVER['REQUEST_URI'], 'user-edit.php')) {
		$wpdb->set_blog_id($ms_site_id);
		$table_prefix = $ms_site_prefix . $ms_site_id . '_';
	}
	
	// restore original tables
	$wpdb->options = $options;
	$wpdb->users = $users;
	$wpdb->usermeta = $usermeta;
	$wpdb->blogs = $blogs;
	$wpdb->blog_versions = $blog_versions;
	$wpdb->site = $site;
	$wpdb->sitemeta = $sitemeta;
	$wpdb->signups = $signups;
	$wpdb->sitecategories = $sitecategories;
	$wpdb->registration_log = $registration_log;
}
add_action('init', 'table_prefix_switch');

// create custom plugin settings menu
function mms_create_menu() {
	//create new top-level menu
	add_submenu_page('plugins.php','MMS Settings', 'MMS Settings', 'administrator', 'mms_settings_page', 'mms_settings_page', plugins_url('/favicon.png', __FILE__));
	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
	//register our settings
	register_setting( 'mms-settings-group', 'subsite_site_id' );
	register_setting( 'mms-settings-group', 'ms_site_prefix' );
}

function mms_settings_page() {
?>
<div class="wrap">
<h2>Mirror Multi Sites</h2>

<form method="post" action="options.php">
	<?php settings_fields( 'mms-settings-group' ); ?>
	<?php // do_settings( 'mms-settings-group' ); ?>
	<table class="form-table">
		<tr valign="top">
		<th scope="row">Database prefix of mirrored (sub)site:</th>
		<td><input type="text" name="ms_site_prefix" value="<?php $ms_site_prefix = get_option('ms_site_prefix'); if (empty($ms_site_prefix)) echo 'wp_'; else echo $ms_site_prefix; ?>" /></td>
		</tr>
		<tr valign="top">
		<th scope="row">Site's ID of mirrored subsite:</th>
		<td><input type="text" name="subsite_site_id" value="<?php echo get_option('subsite_site_id'); ?>" />
		<p>For subsites only.</p></td>
		</tr>
	</table>

	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>

</form>
</div>
<?php
}
add_action('admin_menu', 'mms_create_menu');
?>
