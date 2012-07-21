<?php 
/*
Plugin Name: Kw Modern Advertise
Plugin URI: http://kwark.allwebtuts.net
Description: A simply way to make background image clickable. Now with multi-partners, multi-adverts, priority and filter based on is single, is category, is page, is home/is front page.
Author: Laurent (KwarK) Bertrand
Version: 1.2.0
Tags: modern-advertise-zone, background, partner, gestion, advertiser, modern-advertise, adverts, background-adverts, background-advertise, wordpress, plugin
Author URI: http://kwark.allwebtuts.net
*/

/**
 * @copyright 2011  Laurent (KwarK) Bertrand  ( email : kwark(at)allwebtuts.net )
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
 
// disallow direct access to file
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
	wp_die('Sorry, but you cannot access this page directly.');
}

$GLOBALS['kma_plugin_path'] = $kma_plugin_path = PLUGIN_DIR_PATH(__FILE__);

//langages
load_plugin_textdomain( 'kma', true, dirname( plugin_basename( __FILE__ ) ) . '/wp-languages/' );

//Construct admin page
if(is_admin())
{
	// Respects SSL, Style.css is relative to the current file
    wp_register_style('kma_admincss', plugins_url('css/admin.css', __FILE__));
	wp_enqueue_style('kma_admincss');
	wp_register_script('kma_pagination', plugins_url('js/JPages.min.js', __FILE__));
}
/*wp_register_script('kma_frontendjs', plugins_url('js/resize.js', __FILE__), array('jquery'));*/

/*add_filter('body_class','kma_body_class_name_cheat');
function kma_body_class_name_cheat($classes) {
	// add 'class-name' to the $classes array
	$classes[] = 'kma-background';
	// return the $classes array
	return $classes;
}*/

//For is_home
add_action( 'wp_footer', 'kma_is_home');
function kma_is_home()
{
	if(is_home() || is_front_page())
	{
		global $wpdb, $blog_id, $kma_plugin_path;
		$prior = array();
		$prior = array('5','5','5','5','5','4','4','4','4','3','3','3','2','2','1');
		shuffle($prior);
		
		$priority = $prior[0];
		
		$cachetime = get_option('kma_cache');

		$cache = $kma_plugin_path . 'cache/temp_'.$blog_id.'_is_home_'.$priority.'.html';
			
		$expire = time() - ($cachetime * 60); //-60; // valable X minutes
	
		if(file_exists($cache) && filemtime($cache) > $expire)
		{
			readfile($cache);
		}
		else
		{
			ob_start(); //start buffer
			
			$kma_width = get_option('kma_width');
			$kma_background_fixed = get_option('kma_background_fixed');
			$kma_original_theme = get_option('kma_original_theme');
				
			$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE 'is_home' AND Priority LIKE '".$priority."'");
			$backgrounds = $wpdb->get_results($sql);
			
			/*var_dump($backgrounds);*/
				
			if(!$backgrounds)
			{
				$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE 'is_home'");
				$backgrounds = $wpdb->get_results($sql);
			}
			
			shuffle($backgrounds);
			
			/*var_dump($backgrounds);*/
			
			$background_url = $backgrounds[0]->BackgroundUrl;
			$background_partener_url = $backgrounds[0]->PartnerUrl;
			$background_color = $backgrounds[0]->BackgroundColor;
			
			$special_content .= '<style type="text/css" id="custom-background-css">';
			$special_content .= '#cliczone-advert-left {
								background-color: transparent !important;
								width: '.$kma_width.'px;
								height: 1600px; /*Current max 2440x1600*/
								margin: 30px 0 0 -'.$kma_width.'px;
								float: left;
								border: none;
							}
							
							#cliczone-advert-right {
								background-color: transparent !important;
								width: '.$kma_width.'px;
								height: 1000px;
								margin: 30px -'.$kma_width.'px 0 0;
								float: right;
								border: none;
							}
							
							#kma-wrapper{
								background-color: transparent !important;
								margin: 0 auto 1600px;
								width: '.$kma_original_theme.'px;
								height: 0px;
								position: fixed;
								top: 1px;
								left: 1px;
								right: 1px;
								border: none;
							}';
			
					
					if($kma_background_fixed == 'fixed')
					{
						$special_content .= 'body, body.custom-background { background-color: #'.$background_color.'; background-image: url(\''.$background_url.'\') !important; background-repeat: no-repeat; background-position: top center; background-attachment: fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;}';
					}	
					else
					{
						$special_content .= 'body, body.custom-background { background-color: #'.$background_color.'; background-image: url(\''.$background_url.'\') !important; background-repeat: no-repeat; background-position: top center; background-attachment: scroll; }';
					}	
					
					$special_content .= '</style><div id="kma-wrapper"><a href="'.$background_partener_url.'"><div id="cliczone-advert-left">&nbsp;</div></a><a href="'.$background_partener_url.'"><div id="cliczone-advert-right">&nbsp;</div></a></div>';
					
			echo $special_content;
			
			//Clean buffer and ending file
			$page = ob_get_contents();
			
			ob_end_clean();
			
			file_put_contents($cache, $page);
			
			echo $page;
		}
	}
}

//For others	
add_filter('the_content','kma_filter_content');
function kma_filter_content($content)
{
	global $wpdb, $blog_id, $kma_plugin_path;
	
	$prior = array();
	$prior = array('5','5','5','5','5','4','4','4','4','3','3','3','2','2','1');
	shuffle($prior);
	
	$priority = $prior[0];
	
	$kma_width = get_option('kma_width');
	$kma_background_fixed = get_option('kma_background_fixed');
	$kma_original_theme = get_option('kma_original_theme');
	$cachetime = get_option('kma_cache');
		
		if(is_category())
		{
			$cache = $kma_plugin_path . 'cache/temp_'.$blog_id.'_is_category_'.$priority.'.html';
				
			$expire = time() - ($cachetime * 60); //-60; // valable X minutes
		
			if(file_exists($cache) && filemtime($cache) > $expire)
			{
				readfile($cache);
			}
			else
			{
				ob_start(); //start buffer
				
				$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE 'is_category' AND Priority LIKE '".$priority."'");
				$backgrounds = $wpdb->get_results($sql);
				
				if(!$backgrounds)
				{
					$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE 'is_category'");
					$backgrounds = $wpdb->get_results($sql);
				}
				
				if($backgrounds)
				{
					shuffle($backgrounds);
					
					/*var_dump($backgrounds);*/
				
					$background_url = $backgrounds[0]->BackgroundUrl;
					$background_partener_url = $backgrounds[0]->PartnerUrl;
					$background_color = $backgrounds[0]->BackgroundColor;
				}
			}
		}
	
	if(is_single())
	{
		$cache = $kma_plugin_path . 'cache/temp_'.$blog_id.'_is_single_'.$priority.'.html';
			
		$expire = time() - ($cachetime * 60); //-60; // valable X minutes
	
		if(file_exists($cache) && filemtime($cache) > $expire)
		{
			readfile($cache);
		}
		else
		{	
			ob_start(); //start buffer
				
			$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE 'is_single' AND Priority LIKE '".$priority."'");
			$backgrounds = $wpdb->get_results($sql);
			
			if(!$backgrounds)
			{
				$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE 'is_single'");
				$backgrounds = $wpdb->get_results($sql);
			}
			
			if($backgrounds)
			{
				shuffle($backgrounds);
				
				/*var_dump($backgrounds);*/
			
				$background_url = $backgrounds[0]->BackgroundUrl;
				$background_partener_url = $backgrounds[0]->PartnerUrl;
				$background_color = $backgrounds[0]->BackgroundColor;
			}
		}
	}	
	
	if(is_page())
	{
		$cache = $kma_plugin_path . 'cache/temp_'.$blog_id.'_is_page_'.$priority.'.html';
			
		$expire = time() - ($cachetime * 60); //-60; // valable X minutes
	
		if(file_exists($cache) && filemtime($cache) > $expire)
		{
			readfile($cache);
		}
		else
		{
			ob_start(); //start buffer
			
			$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE 'is_page' AND Priority LIKE '".$priority."'");
			$backgrounds = $wpdb->get_results($sql);
			
			if(!$backgrounds)
			{
				$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE 'is_page'");
				$backgrounds = $wpdb->get_results($sql);
			}
			
			if($backgrounds)
			{
				shuffle($backgrounds);
				
				/*var_dump($backgrounds);*/
			
				$background_url = $backgrounds[0]->BackgroundUrl;
				$background_partener_url = $backgrounds[0]->PartnerUrl;
				$background_color = $backgrounds[0]->BackgroundColor;
			}
		}
	}
	if($background_url)
	{
		$special_content .= '<style type="text/css" id="custom-background-css">';
		$special_content .= '
						#cliczone-advert-left {
							background-color: transparent !important;
							width: '.$kma_width.'px;
							height: 1600px; /*Current max 2440x1600*/
							margin: 30px 0 0 -'.$kma_width.'px;
							float: left;
							border: none;
						}
						
						#cliczone-advert-right {
							background-color: transparent !important;
							width: '.$kma_width.'px;
							height: 1600px;
							margin: 30px -'.$kma_width.'px 0 0;
							float: right;
							border: none;
						}
						
						#kma-wrapper{
							background-color: transparent !important;
							margin: 0 auto 1600px;
							width: '.$kma_original_theme.'px;
							height: 0px;
							position: fixed;
							top: 1px;
							left: 1px;
							right: 1px;
							border: none;
						}';	
		if($kma_background_fixed == 'fixed')
		{
			$special_content .= '
			body, body.custom-background { background-color: #'.$background_color.'; background-image: url(\''.$background_url.'\') !important; background-repeat: no-repeat; background-position: top center; background-attachment: fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;}';
		}	
		else
		{
			$special_content .= '
			body, body.custom-background { background-color: #'.$background_color.'; background-image: url(\''.$background_url.'\') !important; background-repeat: no-repeat; background-position: top center; background-attachment: scroll; }';
		}	
		
		$special_content .= '
		</style>
		<div id="kma-wrapper"><a href="'.$background_partener_url.'"><div id="cliczone-advert-left">&nbsp;</div></a><a href="'.$background_partener_url.'"><div id="cliczone-advert-right">&nbsp;</div></a></div>';
		
		echo $special_content;
		
		//Clean buffer and ending file
		$page = ob_get_contents();
		
		ob_end_clean();
		
		file_put_contents($cache, $page);
		
		echo $page;
		
		$content .= $special_content;
	}
	
	return $content;
}

global $kma_db_version;

$kma_db_version = "1.1.1";

function kma_install() {
 
 	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
   	global $wpdb, $kma_db_version;
	
	$table_prefix = $wpdb->prefix;
		
		$sql = "CREATE TABLE IF NOT EXISTS `".$table_prefix."background_partner` (
			  `BackgroundId` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `BackgroundUrl` varchar(255) NOT NULL,
			  `PartnerUrl` varchar(255) NOT NULL,
			  `Priority` enum('1','2','3','4','5') NOT NULL,
			  `Category` enum('is_home','is_single','is_page','is_category') NOT NULL,
			  PRIMARY KEY (`BackgroundId`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;" ;
			dbDelta($sql);
	
	update_option("kma_db_version", $kma_db_version);
}

register_activation_hook(__FILE__,'kma_install');

$installed_ver = get_option('kma_db_version');

if($installed_ver != $kma_db_version)
{
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
   	global $wpdb, $kma_db_version;
	
	$table_prefix = $wpdb->prefix;
	//"ALTER TABLE ".SFFORUMS. " ADD (forum_status int(4) NOT NULL default '0')";
	$sql = "CREATE TABLE `".$table_prefix."background_partner` (
			  `BackgroundId` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `BackgroundUrl` varchar(255) NOT NULL,
			  `PartnerUrl` varchar(255) NOT NULL,
			  `Priority` enum('1','2','3','4','5') NOT NULL,
			  `Category` enum('is_home','is_single','is_page','is_category') NOT NULL,
			  `BackgroundColor` varchar(6) NOT NULL,
			  PRIMARY KEY (`BackgroundId`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;" ;
			dbDelta($sql);
	
	update_option("kma_db_version", $kma_db_version);
}

function kma_update_db_check()
{
    global $kma_db_version;
    if (get_site_option('kma_db_version') != $kma_db_version) 
	{
        kma_install();
    }
}
add_action('plugins_loaded', 'kma_update_db_check');

function kma_uninstall()
{
	global $wpdb;
	$table_name = $wpdb->prefix;
	$wpdb->query("DROP TABLE IF EXISTS ".$table_name."background_partner");
	delete_option('kma_width');
	delete_option('kma_background_fixed');
	delete_option('kma_original_theme');
	delete_option('kma_cache');
}
register_uninstall_hook(__FILE__, 'kma_uninstall');

//Deprecated but stop bug if enable in theme without php condition
function kw_add_top_display() {
	echo '';
	}
//Deprecated but stop bug if enable in theme without php condition
function kw_add_left_display() {
	echo '';
	}
//Deprecated but stop bug if enable in theme without php condition
function kw_add_right_display() {
	echo '';
	}
//Deprecated but stop bug if enable in theme without php condition
function kw_advert_main() {
	echo '';
	} 

/**Add menu admin in the Apparence menu **/

add_action('admin_menu', 'kw_advert_menu');

function kw_advert_menu() {
	add_theme_page('Advertises Options', 'Modern advertise', 'manage_options', 'kw-modern-advertise', 'kw_advert');
}

/**Updates "kw_advert Settings" Page Form **/

function kw_advert()
{
	if(isset($_POST['submitted']) && $_POST['submitted'] == "yes")
	{
		$kma_width = stripslashes($_POST['kma_width']);
		update_option('kma_width', $kma_width);
		
		$kma_background_fixed = stripslashes($_POST['kma_background_fixed']);
		update_option('kma_background_fixed', $kma_background_fixed);
		
		$kma_original_theme = stripslashes($_POST['kma_original_theme']);
		update_option('kma_original_theme', $kma_original_theme);
		
		$kma_cache = stripslashes($_POST['kma_cache']);
		update_option('kma_cache', $kma_cache);
	}
?>
<?php /**Start Form for advertises**/?>
<div class="wrap wb-admin">
	   	<div class="icon32" id="icon-tools"><br />
	  	</div>
	  	<h2>
		<?php _e('Modern advertise - General configuration', 'kma'); ?>
	  	</h2>
	  	<form method="post" action="" class="wb_admin">
		<p class="submit">
		<input type="submit" name="options_submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
		</p>
		<table class="widefat options" style="width: 650px">
		<th colspan="2" class="dashboard-widget-title"><?php _e('Add one modern advert', 'wb'); ?></th>
	  	<tr valign="top">
		<td scope="row"><label>
			<?php _e('add background url', 'kma'); ?>
		  </label></td>
		<td class="kma-admin-td"><input type="text" style="width:125px;" maxlength="55" name="kma_background_url" id="kma_background_url" class="regular-text" />
		  <span class="kma_help" title="<?php _e('Complete this input with the background src link', 'kma'); ?>"></span><br /></td>
	  </tr>
      <tr valign="top">
		<td scope="row"><label>
			<?php _e('add partner url', 'kma'); ?>
		  </label></td>
		<td class="kma-admin-td"><input type="text" style="width:125px;" maxlength="55" name="kma_background_partner_url" id="kma_background_partner_url" class="regular-text" />
		  <span class="kma_help" title="<?php _e('Complete this input with the partner link linked to this background', 'kma'); ?>"></span><br /></td>
	  </tr>
       <tr valign="top">
		<td scope="row"><label>
			<?php _e('Choose one category', 'kma'); ?>
		  </label></td>
		<td class="kma-admin-td"><select name="kma_background_category" id="kma_background_category">
        <?php $categories = array(); $categories = array('is_home','is_single','is_page','is_category'); 
				foreach($categories as  $cat){ ?>
				<option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                <?php } ?>
			  </select>
		  <span class="kma_help" title="<?php _e('Choose where this background partner program is displayed', 'kma'); ?>"></span><br /></td>
	  </tr>
      <tr valign="top">
		<td scope="row"><label>
			<?php _e('Priority display', 'kma'); ?>
		  </label></td>
		<td class="kma-admin-td"><select name="kma_background_priority" id="kma_background_priority">
        <?php $priorities = array(); $priorities = array('1','2','3','4','5'); 
				foreach($priorities as $prior){ ?>
				<option value="<?php echo $prior; ?>"><?php echo $prior; ?></option>
                <?php } ?>
			  </select>
		  <span class="kma_help" title="<?php _e('Choose priority display - 1 2 3 4 5 +', 'kma'); ?>"></span><br /></td>
	  </tr>
      <tr valign="top">
		<td scope="row"><label>
			<?php _e('Background color', 'kma'); ?>
		  </label></td>
		<td class="kma-admin-td">#<input type="text" style="width:125px;" maxlength="55" name="kma_background_color" id="kma_background_color" class="regular-text" />
		  <span class="kma_help" title="<?php _e('Choose background colorization (6hex) to synch bottom of background img and background color', 'kma'); ?>"></span><br /></td>
	  </tr>
      </table>
      <br />
      <table class="widefat options" style="width: 650px">
		<th colspan="2" class="dashboard-widget-title"><?php _e('Static options', 'wb'); ?></th>
	  	<tr valign="top">
		<td scope="row"><label>
			<?php _e('width of left & right clickable zones', 'kma'); ?>
        </label></td>
		<td class="kma-admin-td"><label><input type="number" style="width:125px;" max="9999" value="<?php echo get_option('kma_width'); ?>" name="kma_width" id="kma_width" class="regular-text" />px</label>
		  <span class="kma_help" title="<?php _e('Complete this input with the width of your choice for the left and right clickable zones in pixel', 'kma'); ?>"></span><br /></td>
	  </tr>
      <tr valign="top">
		<td scope="row"><label>
			<?php _e('width of your current theme', 'kma'); ?>
        </label></td>
		<td class="kma-admin-td"><label><input  type="number" style="width:125px;" max="9999" value="<?php echo get_option('kma_original_theme'); ?>" name="kma_original_theme" id="kma_original_theme" class="regular-text" />px</label>
		  <span class="kma_help" title="<?php _e('Complete this input with the width of the main div content of your current theme', 'kma'); ?>"></span><br /></td>
	  </tr>
      <tr valign="top">
		<td scope="row"><label>
			<?php _e('background fixed or scroll', 'kma'); $temp = get_option('kma_background_fixed'); ?>
        </label></td>
		<td class="kma-admin-td"><select name="kma_background_fixed" id="kma_background_fixed">
        		<option <?php if($temp == 'fixed'){ echo 'selected="selected"';} ?> value="fixed">fixed</option>
                <option <?php if($temp == 'scroll'){ echo 'selected="selected"';} ?> value="scroll">scroll</option>
			  </select><span class="kma_help" title="<?php _e('Select scrolling background or fixed it', 'kma'); ?>"></span><br /></td>
	  </tr>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Choose a cache time', 'kma'); ?>
          </label></td>
        <?php $temp = get_option('kma_cache'); ?>
        <td class="kma-admin-td"><select name="kma_cache" id="kma_cache">
        <option <?php if($temp == '0'){echo 'selected="selected"';} ?> value="0">Off</option>
            <?php for($i = 1; $i <= 10; $i++){ ?>
            <option <?php if($temp == ''.$i.''){echo 'selected="selected"';} ?> value="<?php echo ''.$i.''; ?>"><?php echo ''.$i.''; ?></option>
            <?php } ?>
          </select>
          <span class="kma_help" title="<?php _e('Cache is expressed in minutes before expiration', 'kma'); ?> <?php _e('Consider Off as temporary Off. Choose Off only when you makes setting changes to see the result more quickly. After settings, choose a cache time.', 'kma'); ?>"></span> <br /></td>
      </tr>
      </table>
        <?php
		if(isset($_POST['submitted']) && $_POST['submitted'] == "yes")
		{		
			if(isset($_POST['delete_one_is_home']) && !empty($_POST['delete_one_is_home']))
			{
				$temp = stripslashes($_POST['delete_one_is_home']);
				
				if($temp)
				{
					global $wpdb;
					$table_name = $wpdb->prefix;
					$wpdb->query($wpdb->prepare("DELETE FROM {$table_name}background_partner WHERE BackgroundId=".$temp.""));
				}
			}
			if(isset($_POST['delete_one_is_category']) && !empty($_POST['delete_one_is_category']))
			{
				$temp = stripslashes($_POST['delete_one_is_category']);
				
				if($temp)
				{
					global $wpdb;
					$table_name = $wpdb->prefix;
					$wpdb->query($wpdb->prepare("DELETE FROM {$table_name}background_partner WHERE BackgroundId=".$temp.""));
				}
			}
			if(isset($_POST['delete_one_is_page']) && !empty($_POST['delete_one_is_page']))
			{
				$temp = stripslashes($_POST['delete_one_is_page']);
				
				if($temp)
				{
					global $wpdb;
					$table_name = $wpdb->prefix;
					$query = $wpdb->query($wpdb->prepare("DELETE FROM {$table_name}background_partner WHERE BackgroundId=".$temp.""));
				}
			}
			
			if(isset($_POST['delete_one_is_single']) && !empty($_POST['delete_one_is_single']))
			{
				$temp = stripslashes($_POST['delete_one_is_single']);
				
				if($temp)
				{
					global $wpdb;
					$table_name = $wpdb->prefix;
					$query = $wpdb->query($wpdb->prepare("DELETE FROM {$table_name}background_partner WHERE BackgroundId=".$temp.""));
				}
			}
			
			if(isset($_POST['kma_background_url']) && $_POST['kma_background_url'] != '' && isset($_POST['kma_background_partner_url']) && $_POST['kma_background_partner_url'] != '' && isset($_POST['kma_background_priority']) && $_POST['kma_background_priority'] != '' && isset($_POST['kma_background_category']) && $_POST['kma_background_category'] != '' && isset($_POST['kma_background_color']))
			{
				global $wpdb;
				$table_name = $wpdb->prefix;
				$background_url = $_POST['kma_background_url'];
				$background_partner_url = $_POST['kma_background_partner_url'];
				$background_priority = $_POST['kma_background_priority'];
				$background_category = $_POST['kma_background_category'];
				$background_color = $_POST['kma_background_color'];
	/*			$rows_affected = $wpdb->insert( $table_name, array('BackgroundUrl' => $background_url, 'PartnerUrl' => $background_partner_url, 'Priority' => $background_priority, 'Category' => $background_category), array('%s','%s','%s','%s'));*/
				$rows_affected = $wpdb->query( $wpdb->prepare( "INSERT INTO {$table_name}background_partner ( BackgroundUrl, PartnerUrl, Category, Priority, BackgroundColor ) VALUES ( %s, %s, %s, %s, %s )", ''.$background_url.'', ''.$background_partner_url.'', ''.$background_category.'', ''.$background_priority.'', ''.$background_color.'' ) );
			}
		        echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
    	}
	
	$types = array();
	$types = array('is_home', 'is_category' , 'is_single', 'is_page');
	foreach($types as $key => $type)
			{
				global $wpdb;
				$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."background_partner WHERE Category LIKE '".$type."'");
				$kma = $wpdb->get_results($sql);
				/*var_dump($kma);*/
				if($kma) { 
				wp_enqueue_script('kma_pagination'); ?>
				<script type="text/javascript">
                /* when document is ready */
                jQuery(document).ready(function($){
                    
                    $("div.kma-holder-<?php echo $type; ?>").jPages({
                        containerID  : "kma-container-<?php echo $type; ?>",
                        perPage      : 5,
                        first        : 'first',
                        last         : 'last',
                        previous	 : 'prev',
                        next	     : 'next'
                    });
                });
             </script>
        <br />
    <div class="kma-holder-<?php echo $type; ?>"></div>
    <br />
        <table class="widefat options" style="width: 650px">
	  
		<th colspan="2" class="dashboard-widget-title"><?php _e('Delete one background in ', 'kma'); echo $type; ?>
		  <span class="mini-<?php echo $type; ?>"></span></th>
	  <tr valign="top">
		<td scope="row"><label>
		<?php _e('Delete one ?', 'kma') ?>
        </label></td>
		<td class="kma-admin-td"><select name="delete_one_<?php echo ''.$type.'' ?>" id="delete_one_<?php echo ''.$type.'' ?>">
			<option value=""><?php echo 'off' ?></option>
			<?php 
			foreach($kma as $ke => $value)
			{
			?>
			<option value="<?php echo ''.$value->BackgroundId.''; ?>"><?php echo ''.$value->BackgroundId.''; ?></option>
			<?php } ?>
		  </select>
		  <span class="kma_help" title="<?php _e('Select one to delete and clic on save changes button to delete this current background', 'kma'); ?>"></span> <br /></td>
	       </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
    <thead><tr><th>ID</th><th>img src</th><th>url</th><th>Prior</th><th>Color</th></tr></thead>
    <tbody id="kma-container-<?php echo $type; ?>">
             <?php
			 foreach($kma as $k => $v)
			{
			?>
	  <tr valign="top">
		<td scope="row"><label><?php echo 'ID&nbsp;' ?>
		<input type="text" style="width:50px;" maxlength="55" disabled="disabled" value="<?php echo ''.$v->BackgroundId.''; ?>" />
		</label></td>
		<td scope="row"><label><?php echo 'img src&nbsp;' ?>
        <input type="text" style="width:125px;" maxlength="55" disabled="disabled" name="<?php echo $v->BackgroundUrl; ?>" value="<?php echo $v->BackgroundUrl; ?>" id="<?php echo ''.$v->BackgroundId.'' ?>" />
        </label></td>
         <td scope="row"><label><?php echo 'url&nbsp;' ?>
        <input type="text" style="width:125px;" maxlength="55" disabled="disabled" name="<?php echo $v->PartnerUrl; ?>" value="<?php echo $v->PartnerUrl; ?>" id="<?php echo ''.$v->PartnerUrl.'' ?>" />
        </label></td>
         <td scope="row"><label><?php echo 'Prior&nbsp;' ?>
		<input type="text" style="width:50px;" maxlength="55" disabled="disabled" value="<?php echo ''.$v->Priority.''; ?>" />
		</label></td>
        <td scope="row"><label><?php echo 'Color&nbsp;' ?>
		<input type="text" style="width:50px;" maxlength="55" disabled="disabled" value="<?php echo ''.$v->BackgroundColor.''; ?>" />
		</label></td>
	  </tr>
	  <?php } ?>
	</table>
    <?php }} ?>
		 <p class="submit">
		  <input name="submitted" type="hidden" value="yes" />
		  <input type="submit" name="options_submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
		</p>
	  </form>
<?php 
}
?>
