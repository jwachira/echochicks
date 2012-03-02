<?php
/*
Plugin Name: WP FB Like
Plugin URI: http://buzzknow.com/2010/04/24/facebook-like-button-simple-wordpress-plugin/
Description: Allow you to put Facebook Like Button Plugin directly into your post. Developed by <a href="http://buzzknow.com/" title="Sharing Knowledge Of Internet" target="_blank">Ferri Sutanto</a>.
Author: Ferri Sutanto
Version: 1.3
Author URI: http://buzzknow.com/
*/

/*  Copyright 2010 Ferri Sutanto  (email: greenhouseprod@gmail.com)
**
**  This program is free software; you can redistribute it and/or modify
**  it under the terms of the GNU General Public License as published by
**  the Free Software Foundation; either version 2 of the License, or
**  (at your option) any later version.
**
**  This program is distributed in the hope that it will be useful,
**  but WITHOUT ANY WARRANTY; without even the implied warranty of
**  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
**  GNU General Public License for more details.
**
**  You should have received a copy of the GNU General Public License
**  along with this program; if not, write to the Free Software
**  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function fblike_options()
{
	add_options_page('Facebook Like', 'Facebook Like', 'administrator', basename(__FILE__), 'fblike_options_page');
}

function fblike_generate_button()
{
	$button .= '<div class="fblike_button" style="'.get_option('fblike_style').'">';
	
	// iframe options
	$button .= '<iframe src="http://www.facebook.com/plugins/like.php?href='.urlencode(get_permalink());
	$button .= '&amp;layout='.get_option('fblike_layout').'';
		if(get_option('fblike_faces') == 'true')
		{
			$faces	= 'true';
		}
		else
		{
			$faces = 'false';
		}
	$button .= '&amp;show_faces='.$faces;
	$button .= '&amp;width='.get_option('fblike_width').'';
	$button .= '&amp;action='.get_option('fblike_verb').'';
		if(get_option('fblike_font') != '')
		{
			$button .= '&amp;font='.get_option('fblike_font').'';
		}
	$button .= '&amp;colorscheme='.get_option('fblike_color').'"';
	$button .= ' scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.get_option('fblike_width').'px; height:'.get_option('fblike_height').'px"></iframe>';
	
	$button .= '</div>';
	
	return $button;
}

function fblike_out($content)
{
	global $post;
	
	if((is_page() && get_option('fblike_display_page') != 'true') || (is_home() && get_option('fblike_display_home') != 'true'))
	{
		$button	= null;
	}
	else
	{
		$button	= fblike_generate_button();
	}
	
	// are we just using the shortcode
	if (get_option('fblike_where') == 'shortcode') 
	{
		return str_replace('[fblike]', $button, $content);
	} 
	elseif (get_option('fblike_where') == 'manual')
	{
		return $content;
	} 
	else 
	{
		if (get_option('fblike_where') == 'beforeandafter') {
			// adding it before and after
			return $button . $content . $button;
		} else if (get_option('fblike_where') == 'before') {
			// just before
			return $button . $content;
		} else {
			// just after
			return $content . $button;
		}
	}
}

// admin options page
function fblike_options_page()
{

?>

	<div class="wrap" id="fblike_top">
    <div class="icon32" id="icon-options-general"><br/></div><h2>Settings for WP FB Like</h2>
	
	<p>This plugin will add new WP FB Like plugin for each of your blog posts. It can be easily styles in your blog posts. For reference, please see <code>http://developers.facebook.com/docs/reference/plugins/like</code>.
    </p>
	
	<div class="metabox-holder has-right-sidebar" id="poststuff">
	
		<div class="inner-sidebar">
			<div style="position: relative;" class="meta-box-sortabless ui-sortable" id="side-sortables">
	
			<div class="postbox">
				<h3 class="hndle"><span>About WP FB Like</span></h3>
				<div class="inside">
				<p>
				<a href="http://buzzknow.com/2010/04/24/facebook-like-button-simple-wordpress-plugin/"><b>Plugin Homepage</b></a><br /><br />
				<b>Facebook</b> : <a href="http://www.facebook.com/pages/Buzzknow/Buzzknow/342879833411">Buzzknow Pages</a><br />
				<b>Twitter</b> : <a href="http://twitter.com/buzzknow">@buzzknow</a><br />
				</p>
				
				<p>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="QEQP2HVW8B5BN">
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				</p>
				</div><!--/inside-->
			</div><!--/postbox-->
			
			<div class="postbox">
		<h3 class="hndle"><span>Buzzknow Latest News</span></h3>
		<div class="inside">
			<p align="center">
			<a href="http://buzzknow.com" title="Buzzknow - Sharing Knowledge Of Internet"><img src="http://profile.ak.fbcdn.net/object2/1106/119/n342879833411_944.jpg" border="0" alt="Buzzknow - Sharing Knowledge Of Internet" /></a>
			</p>
			
			<?php
				// Get a SimplePie feed object from the specified feed source.
				$rss = fetch_feed('http://buzzknow.com/feed/');
				if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
					// Figure out how many total items there are, but limit it to 5. 
					$maxitems = $rss->get_item_quantity(5); 

					// Build an array of all the items, starting with element 0 (first element).
					$rss_items = $rss->get_items(0, $maxitems); 
				endif;
			?>
			
			<?php if ($maxitems == 0) echo '<li>No items.</li>';
			else
			// Loop through each feed item and display each item as a hyperlink.
			foreach ( $rss_items as $item ) : ?>
				<p>
				<a href='<?php echo $item->get_permalink(); ?>'
				title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
				<?php echo $item->get_title(); ?></a>
				</p>
			<?php endforeach; ?>
		
		</div><!--/inside-->
	</div><!--/postbox-->
	
			</div>
		</div><!--/inner-sidebar-->
		
		<div class="has-sidebar">					
			<div class="has-sidebar-content" id="post-body-content">
			
			<div class="postbox">
				<h3 class="hndle"><span>Settings WP FB Like</span></h3>
				<div class="inside">
				
				<form method="post" action="options.php">
			
				<?php
					// New way of setting the fields, for WP 2.7 and newer
					if(function_exists('settings_fields')){
						settings_fields('fblike-options');
					} else {
						wp_nonce_field('update-options');
						?>
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options" value="fblike_where, fblike_style, fblike_layout, fblike_faces, fblike_width, fblike_verb, fblike_font, fblike_color" />
						<?php
					}
				?>
				
				<table class="form-table" id="fblike_table">
					<tr>
						<tr>
							<th scope="row" valign="top">Display</th>
							<td>
								<input type="checkbox" value="true" <?php if (get_option('fblike_display_page') == 'true') echo 'checked="checked"'; ?> name="fblike_display_page" id="fblike_display_page" />
								<span class="description">Display the button on pages</span>
								<br />
								<input type="checkbox" value="true" <?php if (get_option('fblike_display_home') == 'true') echo 'checked="checked"'; ?> name="fblike_display_home" id="fblike_display_home" />
								<span class="description">Display the button on the front page (home)</span>
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">Position</th>
							<td>
								<select name="fblike_where" id="fblike_where">
									<option <?php if (get_option('fblike_where') == 'before') echo 'selected="selected"'; ?> value="before">Before</option>
									<option <?php if (get_option('fblike_where') == 'after') echo 'selected="selected"'; ?> value="after">After</option>
									<option <?php if (get_option('fblike_where') == 'beforeandafter') echo 'selected="selected"'; ?> value="beforeandafter">Before and After</option>
									<option <?php if (get_option('fblike_where') == 'shortcode') echo 'selected="selected"'; ?> value="shortcode">Shortcode [fblike]</option>
									<option <?php if (get_option('fblike_where') == 'manual') echo 'selected="selected"'; ?> value="manual">Manual</option>
								</select>
								<span class="description">For manual use this <code>&lt;?php if(function_exists(&#039;wp_fb_like&#039;)) { wp_fb_like(); } ?&gt;</code> and don't forget choose manual position</span>
							</td>
						</tr>
						
						 <tr>
							<th scope="row" valign="top"><label for="fblike_style">Styling</label></th>
							<td>
								<input type="text" value="<?php echo htmlspecialchars(get_option('fblike_style')); ?>" name="fblike_style" id="fblike_style" onblur="preview();" />
								<span class="description">Add style to the div that surrounds the button E.g. <code>margin: 10px 0;</code></span>
							</td>
						</tr>
						
						<tr>
							<th scope="row" valign="top">Layout Style</th>
							<td>
								<select name="fblike_layout" id="fblike_layout" onchange="preview();">
									<option <?php if (get_option('fblike_layout') == 'standard') echo 'selected="selected"'; ?> value="standard">standard</option>
									<option <?php if (get_option('fblike_layout') == 'button_count') echo 'selected="selected"'; ?> value="button_count">button_count</option>
								</select>
								<span class="description">Determines the size and amount of social context next to the button</span>
							</td>
						</tr>
						
						<tr>
							<th scope="row" valign="top">Show Faces</th>
							<td>
								<input type="checkbox" value="true" <?php if (get_option('fblike_faces') == 'true') echo 'checked="checked"'; ?> name="fblike_faces" id="fblike_faces" group="fblike_faces" onclick="preview();" />
								<span class="description">Show profile pictures below the button.</span>
							</td>
						</tr>
						
						<tr>
							<th scope="row" valign="top">Width</th>
							<td>
								<input type="text" value="<?php echo htmlspecialchars(get_option('fblike_width')); ?>" name="fblike_width" id="fblike_width" onblur="preview();" />
								<span class="description">The width of the plugin, in pixels</span>
							</td>
						</tr>
						
						<tr>
							<th scope="row" valign="top">Height</th>
							<td>
								<input type="text" value="<?php echo htmlspecialchars(get_option('fblike_height')); ?>" name="fblike_height" id="fblike_height" onblur="preview();" />
								<span class="description">The height of the plugin, in pixels</span>
							</td>
						</tr>
						
						<tr>
							<th scope="row" valign="top">Verb to display</th>
							<td>
								<select name="fblike_verb" id="fblike_verb" onchange="preview();">
									<option <?php if (get_option('fblike_verb') == 'like') echo 'selected="selected"'; ?> value="like">like</option>
									<option <?php if (get_option('fblike_verb') == 'recommend') echo 'selected="selected"'; ?> value="recommend">recommend</option>
								</select>
								<span class="description">The verb to display in the button. Currently only 'like' and 'recommend' are supported.</span>
							</td>
						</tr>
						
						<tr>
							<th scope="row" valign="top">Font</th>
							<td>
								<select name="fblike_font" id="fblike_font" onchange="preview();">
									<option <?php if (get_option('fblike_font') == '') echo 'selected="selected"'; ?> value=""></option>
									<option <?php if (get_option('fblike_font') == 'arial') echo 'selected="selected"'; ?> value="arial">arial</option>
									<option <?php if (get_option('fblike_font') == 'lucida grande') echo 'selected="selected"'; ?> value="lucida grande">lucida grande</option>
									<option <?php if (get_option('fblike_font') == 'segoe ui') echo 'selected="selected"'; ?> value="segoe ui">segoe ui</option>
									<option <?php if (get_option('fblike_font') == 'tahoma') echo 'selected="selected"'; ?> value="tahoma">tahoma</option>
									<option <?php if (get_option('fblike_font') == 'trebuchet ms') echo 'selected="selected"'; ?> value="trebuchet ms">trebuchet ms</option>
									<option <?php if (get_option('fblike_font') == 'verdana') echo 'selected="selected"'; ?> value="verdana">verdana</option>
								</select>
								<span class="description">The font of the plugin.</span>
							</td>
						</tr>
						
						<tr>
							<th scope="row" valign="top">Color Scheme</th>
							<td>
								<select name="fblike_color" id="fblike_color" onchange="preview();">
									<option <?php if (get_option('fblike_color') == 'light') echo 'selected="selected"'; ?> value="light">light</option>
									<option <?php if (get_option('fblike_color') == 'dark') echo 'selected="selected"'; ?> value="dark">dark</option>
									<option <?php if (get_option('fblike_color') == 'evil') echo 'selected="selected"'; ?> value="evil">evil</option>
								</select>
								<span class="description">The color scheme of the plugin.</span>
							</td>
						</tr>
					</tr>
				</table>

				</div><!--/inside-->
			</div><!--/postbox-->
	
			<div class="postbox">
				<h3 class="hndle"><span>Preview WP FB Like</span></h3>
				<div id="fblike_preview" class="inside">
			
				</div><!--/inside-->
			</div><!--/postbox-->
				
			<p class="submit">
				<input type="submit" class="button-primary" name="Submit" value="<?php _e('Save Changes &raquo;') ?>" />
			</p>
		</form>
	
			</div>
		</div><!--/has-sidebar-->
			
	</div><!--/poststuff-->
	
	<div style="float: right; font-size: 12px;">[ <a href="#fblike_top">BACK TO TOP</a> ]</div>

	</div><!--/wrap-->

<?php

}

// trigger javascript
function fblike_head()
{

?>

<script type="text/javascript">
jQuery(document).ready(function() {		
	preview();
});

function preview()
{
	var style	= jQuery('#fblike_style').val();
	var layout	= jQuery('#fblike_layout').val();
	var faces	= jQuery('#fblike_faces').is(':checked') ? true : false;
	var width	= jQuery('#fblike_width').val();
	var height	= jQuery('#fblike_height').val();
	var verb	= jQuery('#fblike_verb').val();
	var font	= jQuery('#fblike_font').val();
	var color	= jQuery('#fblike_color').val();
	
	var button	= '<div class="fblike_button" style="'+ style +'"><iframe src="http://www.facebook.com/plugins/like.php?href=&amp;layout='+ layout +'&amp;show_faces='+ faces +'&amp;width='+ width +'&amp;action='+ verb +'&amp;font='+ font +'&amp;colorscheme='+ color +'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'+ width +'px; height:'+ height +'px"></iframe></div>';
	
	jQuery('#fblike_preview').html(button);
}
</script>

<style type="text/css">
#fblike_table{
clear: none;
}
</style>
	
<?php

}

// For manual function PHP in themes
function wp_fb_like()
{
	if (get_option('fblike_where') == 'manual') 
	{
		echo fblike_generate_button();
	}
	else
	{
		return false;
	}
}

// On access of the admin page, register these variables (required for WP 2.7 & newer)
function fblike_init(){
    if(function_exists('register_setting')){
        register_setting('fblike-options', 'fblike_display_page');
        register_setting('fblike-options', 'fblike_display_home');
        register_setting('fblike-options', 'fblike_where');
        register_setting('fblike-options', 'fblike_style');
        register_setting('fblike-options', 'fblike_layout');
        register_setting('fblike-options', 'fblike_faces');
        register_setting('fblike-options', 'fblike_width');
        register_setting('fblike-options', 'fblike_height');
        register_setting('fblike-options', 'fblike_verb');
        register_setting('fblike-options', 'fblike_font');
        register_setting('fblike-options', 'fblike_color');
    }
}

// Only all the admin options if the user is an admin
if(is_admin()){
    add_action('admin_menu', 'fblike_options');
    add_action('admin_init', 'fblike_init');
	// ajax admin
	add_action('admin_head', 'fblike_head');
}

// Set the default options when the plugin is activated
function fblike_activation()
{
	add_option('fblike_display_page', 'false');
	add_option('fblike_display_home', 'false');
	add_option('fblike_where', 'before');
	add_option('fblike_style', 'margin: 10px 0;');
	add_option('fblike_layout', 'standard');
	add_option('fblike_faces', 'false');
	add_option('fblike_width', '450');
	add_option('fblike_height', '25');
	add_option('fblike_verb', 'like');
	add_option('fblike_font');
	add_option('fblike_color', 'light');
}

add_filter('the_content', 'fblike_out', 9);

register_activation_hook( __FILE__, 'fblike_activation');

?>