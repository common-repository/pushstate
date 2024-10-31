<?php
/*
Plugin Name: HTML5 pushState
Plugin URI: http://www.lontongcorp.com/2013/02/15/wordpress-html5-pushstate/
Description: AJAXify with HTML5 pushState based on History.js by Benjamin Lupton <github.com/balupton/history.js>. Bundled with jQuery scrollTo plugin. This is an early version, support for HTML5 only, focus on mobile and SEO rank.
Author: Erick (IGITS)
Version: 1.0.2
Author URI: http://www.lontongcorp.com/
License: GPL2
*/
/*
  Copyright 2013 Erick Tampubolon <lontongcorp@gmail.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
    
*/

/**
 * Protection 
 * 
 * This string of code will prevent hacks from accessing the file directly.
 */
defined('ABSPATH') or die("Cannot access pages directly.");

/*
 * Admin Options Page: Settings -> pushState
 */
add_action( 'admin_menu', 'pushstate_menu' );
function pushstate_menu() {
  add_options_page( 'HTML5 pushState', 'HTML5 pushState', 'manage_options', 'pushstate', 'pushstate_settings' );
  add_action( 'admin_init', 'register_pushstate_settings' );
  add_filter( 'plugin_action_links', 'settings_links',10,2);
}
//register settings
function register_pushstate_settings(){
  register_setting( 'pushstate_settings', 'pushstate_div' );
  register_setting( 'pushstate_settings', 'pushstate_tied' );
  register_setting( 'pushstate_settings', 'pushstate_domain' );
  register_setting( 'pushstate_settings', 'pushstate_loading' );
  register_setting( 'pushstate_settings', 'pushstate_loading_posx' );
  register_setting( 'pushstate_settings', 'pushstate_loading_posy' );
  register_setting( 'pushstate_settings', 'pushstate_callback' );
}

function settings_links( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ )) {
	   $settings = '<a href="options-general.php?page=pushstate">' . __( 'Settings' ) . '</a>';
	   array_unshift($links, $settings);
  }
	return $links;
}

function wp_gear_manager_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('jquery');
}

function wp_gear_manager_admin_styles() {
wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
add_action('admin_print_styles', 'wp_gear_manager_admin_styles');

//setting page
function pushstate_settings() {
    
?>
<div class="wrap">
<script language="JavaScript">
jQuery(document).ready(function() {
    jQuery('#select_image').click(function() {
    formfield = jQuery('#upload_image').attr('name');
    tb_show('', 'media-upload.php?type=image&TB_iframe=true');
    return false;
});

window.send_to_editor = function(html) {
    imgurl = jQuery('img',html).attr('src');
    jQuery('#pushstate_loading').val(imgurl);
    tb_remove();
}

});
</script>
  <h2>HTML5 pushState</h2>
  <form method="post" action="options.php">
    <?php
	  
	  //verifying and saving
    if ( $_POST && wp_verify_nonce( $_POST['pushstate_noncename'], plugin_basename( __FILE__ ) ) ) {      
        do_settings_sections( 'pushstate_settings' );
    }
    
    wp_nonce_field( plugin_basename( __FILE__ ), 'pushstate_noncename' );   
     
	  settings_fields( 'pushstate_settings');
    
	  load_plugin_textdomain( 'pushstate', false, plugin_basename( __FILE__ ) );
	?>
	<!--
	<p><label for="pushstate_domain" style="font-weight:bold;">Main Domain :</label> <input type="text" style="width:300px;" id="pushstate_domain" name="pushstate_domain" value="<?php echo get_option( 'pushstate_domain' ); ?>" placeholder="ex.: example.com" />
	</p>
	<p class="description"><?php _e( 'Set main domain to support pushState on Subdomain.', 'pushstate' ) ?> <?php _e( 'Example Plugins', 'pushstate' ) ?>: <a href="http://wordpress.org/extend/plugins/wordpress-subdomains/" target="_blank">Wordpress Subdomain</a> (<a href="http://wordpress.org/extend/plugins/wp-subdomains-revisited/" target="_blank">Revisited</a>)</p>
	
	<p>&nbsp;</p>
	-->
	
	<p><label for="pushstate_div" style="font-weight:bold;">DOM Container :</label> <input type="text" style="width:250px;" id="pushstate_div" name="pushstate_div" value="<?php echo get_option( 'pushstate_div' ); ?>" placeholder="body" />
	</p>
	<p class="description"><?php _e( 'Container DOM that enable pushState for all &lt;a&gt; link, example: <em>&quot;body&quot;</em>, <em>&quot;#wrapper_div&quot;</em>, <em>&quot;.wrapper-class&quot;</em>', 'pushstate' ) ?></p>
	
	<p>&nbsp;</p>
	
	<!--
	<p><label style="font-weight:bold;"><?php _e( 'Filter content tied to DOM container' ) ?> &nbsp; <input type="checkbox" name="pushstate_tied" <?php echo (get_option( 'pushstate_tied' ) ? 'checked="checked" ' : '') ?>/></label>
	</p>
	<p class="description"><?php _e( 'Basic behaviour is to replace the whole body content. This option make it to filter contents just to the DOM as given above.', 'pushstate' ) ?></p>
	
	<p>&nbsp;</p>
	-->
	
	<p><label for="pushstate_loading" style="font-weight:bold;">Loading Image :</label> <input type="text" style="width:250px;" id="pushstate_loading" name="pushstate_loading" value="<?php echo get_option( 'pushstate_loading' ); ?>" placeholder="ex.: http://s1.wp.com/i/loading/fresh-64.gif" />
	<input id="select_image" type="button" value="Media" />
	</p>
	<p><strong>Image Position : </strong> &nbsp;
	   <label>Horizontal <input type="text" style="width:50px;margin-right:35px" name="pushstate_loading_posx" value="<?php echo get_option('pushstate_loading_posx'); ?>" placeholder="center" /></label>
	   <label>Vertical <input type="text" style="width:50px;margin-right:5px" name="pushstate_loading_posy" value="<?php echo get_option('pushstate_loading_posy'); ?>" placeholder="center" /></label>
	</p>
	<p class="description"><?php _e( "Waiting loading image, keep it empty if you don't want one.", 'pushstate' ) ?> <?php _e( 'CSS rules, dont forget px/em/pt if you want precise value for positions', 'pushstate' ) ?></p>
	
	<p>&nbsp;</p>
	
	<p><label style="font-weight:bold;margin-right: 40px"><?php _e( 'Javascript Callback' ) ?> :</label></p>
	<p>
	   <textarea id="pushstate_callback" name="pushstate_callback" style="min-width:500px; min-height:180px"><?php echo get_option( 'pushstate_callback' ) ?></textarea><br />
	   <span class="description">
	       <?php _e( 'Put javascript callback here, don\'t use &lt;script&gt; tag', 'pushstate' ) ?>
	       <?php _e( 'Can be combined with jQuery code.', 'pushstate' ) ?><br />
	       <strong class="error-message"><?php _e( 'Notes' ) ?>:</strong> <?php _e( 'Use at your own risk!', 'pushstate' ) ?>
	       This feature made to make other javascript plugins keep working or debug anything.
	   </span>
	<p>
	
	<p>&nbsp;</p>
	
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
</form>
</div>
<?php
}

/*
 * enqueue history.js
 */
function pushstate_init() {
    // jquery.history.js
		wp_deregister_script('jquery.history');
		wp_register_script('jquery.history', plugins_url('/jquery.history.js',__FILE__), array('jquery')); 
		wp_enqueue_script('jquery.history');
		
    // jquery.scrollTo.js
		wp_deregister_script('jquery.scrollTo');
		wp_register_script('jquery.scrollTo', plugins_url('/jquery.scrollTo.js',__FILE__), array('jquery')); 
		wp_enqueue_script('jquery.scrollTo');
}
add_action('init', 'pushstate_init');

/*
 * Print javascript in footer
 */
function pushstate_javascript() {
    $div = get_option('pushstate_div');
    print('<script type="text/javascript">
var wrapper = "' . ($div ? $div : 'body') . '";
');
    $functions = file_get_contents(dirname(__FILE__) . '/functions.js');
    $loading_posx = get_option('pushstate_loading_posx') ? get_option('pushstate_loading_posy') : 'center';
    $loading_posy = get_option('pushstate_loading_posy') ? get_option('pushstate_loading_posy') : 'center';
    $callback = get_option('pushstate_callback') ? get_option('pushstate_callback') : '';
    $functions = str_replace(
        array('LOADIMG', 'LOADPOS', '/*!CALLBACK*/'),
        array(
            get_option('pushstate_loading') ? "url('".get_option('pushstate_loading')."')" : '',
            $loading_posx . ' ' . $loading_posy,
            $callback
    ), $functions);
    echo $functions;
    print('</script>');
}
add_action('wp_footer', 'pushstate_javascript',18);

/*
 * uninstall hook
 */    
function pushstate_uninstall_hook() {
  delete_option('pushstate');
  delete_option('pushstate_settings');
  
if ( function_exists('register_uninstall_hook') )
    register_uninstall_hook(__FILE__, 'pushstate_uninstall_hook');
}
?>
