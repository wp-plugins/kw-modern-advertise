<?php 
/**
 * @package kw-modern-advertise
 * @author Laurent Bertrand
 * @version 1.0
 */
 
/*
 Plugin Name: Kw Modern Advertise
 Plugin URI: http://style-cataclysm.com/kw-modern-advertise
 Description: A simply way to make background clickable. A easy way to install your modern advertise zone based on background image and make it clickable on your index page or in your theme or whatever you want.
 Author: Laurent Bertrand
 Version: 1.0
 Tags: display,modern-advertise-zone,modern-advertise,background-advertise,on-index-page,directly-in-theme,advertise-flash-effect
 
 Author URI: Laurent Bertrand | KwarK on http://www.style-cataclysm.com/
 */
/**
 * @copyright 2011  Laurent Bertrand  ( email : kwark1(at)style-cataclysm.com )
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
 
 
/**
 * Bootstrap file for getting the ABSPATH constant to wp-load.php
 * This is requried when a plugin requires access not via the admin screen.
 *
 * If the wp-load.php file is not found, then an error will be displayed
 *
 * @package WordPress
 * @since Version 2.6
 */
 
 /** Add custom background for modern advertise option (if exist for your wordpress installation) **/
 

add_custom_background();	


/** Enable / Disable option for Css and parse css to frontend if enable **/

if ( get_option( 'kw_cssad' ) == true ) {
	wp_enqueue_style( 'kw_stylead', '/wp-content/plugins/Kw-Modern-Advertise/css/style.css');
}

/**<?php kw_add_left_display(); ?> | <?php kw_add_right_display(); ?> | <?php kw_add_top_display(); ?> to diplaying zones in your theme **/
	
function kw_add_top_display() {
	
		$kw_eadt = get_option("kw_eadt"); 
		if ($kw_eadt !== "disable") { ?>
<?php
				$kw_adt = get_option("kw_adt");
				$kw_adt = stripslashes($kw_adt);
				
				$kw_top_target = get_option("kw_top_target");
				$kw_top_target = stripslashes($kw_top_target);
				
				$kw_top_height = get_option("kw_top_height");
				$kw_top_height = stripslashes($kw_top_height);

				if($kw_adt == "") {
					echo "&nbsp;";
				}
				else {
				echo "<a href=\" ".$kw_top_target." \"><div id=\"advertisetop\" style=\"height: ".$kw_top_height.";\">$kw_adt</div></a>";
				}
				?>
<?php }
	}
	
function kw_add_left_display() {
	
		$kw_eadl = get_option("kw_eadl"); 
		if ($kw_eadl !== "disable") { ?>
<?php
				$kw_adl = get_option("kw_adl");
				$kw_adl = stripslashes($kw_adl);

				$kw_left_target = get_option("kw_left_target");
				$kw_left_target = stripslashes($kw_left_target);
				
				$kw_left_width = get_option("kw_left_width");
				$kw_left_width = stripslashes($kw_left_width);

				if($kw_adl == "") {
					echo "&nbsp;";
				}
				else {
				echo "<a href=\" ".$kw_left_target." \"><div id=\"advertiseleft\" style=\"width: ".$kw_left_width.";\">$kw_adl</div></a>";
				}
				?>
<?php }
	}
	
function kw_add_right_display() {
	
		$kw_eadr = get_option("kw_eadr"); 
		if ($kw_eadr !== "disable") { ?>
<?php
				$kw_adr = get_option("kw_adr");
				$kw_adr = stripslashes($kw_adr);

				$kw_right_target = get_option("kw_right_target");
				$kw_right_target = stripslashes($kw_right_target);
				
				$kw_right_width = get_option("kw_right_width");
				$kw_right_width = stripslashes($kw_right_width);

				if($kw_adr == "") {
					echo "&nbsp;";
				}
				else {
				echo "<a href=\" ".$kw_right_target." \"><div id=\"advertiseright\" style=\"width: ".$kw_right_width.";\">$kw_adr</div></a>";
				}
				?>
<?php }
	}

/** Group all function in one for parse directly the 3 zones in the theme **/

/** <?php kw_advert_main() ?> **/

function kw_advert_main() {
	kw_add_left_display();
	kw_add_right_display();
	kw_add_top_display();
	} 

/**Add menu admin in the Apparence menu **/

add_action('admin_menu', 'kw_advert_menu');

function kw_advert_menu() {
	add_theme_page('Advertises Options', 'Modern advertise', 'manage_options', 'kw-modern-advertise', 'kw_advert');
}

/**Updates "kw_advert Settings" Page Form **/

function kw_advert(){
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){
		
        /**Get form data**/

		$kw_eadt = $_POST['kw_eadt'];
		$kw_eadr = $_POST['kw_eadr'];
		$kw_eadl = $_POST['kw_eadl'];
		
		$kw_adt = stripslashes($_POST['kw_adt']);
		$kw_top_height = stripslashes($_POST['kw_top_height']);
		$kw_top_target = stripslashes($_POST['kw_top_target']);
		
		$kw_adl = stripslashes($_POST['kw_adl']);
		$kw_left_width = stripslashes($_POST['kw_left_width']);
		$kw_left_target = stripslashes($_POST['kw_left_target']);
		
		$kw_adr = stripslashes($_POST['kw_adr']);
		$kw_right_width = stripslashes($_POST['kw_right_width']);
		$kw_right_target = stripslashes($_POST['kw_right_target']);
		
		update_option("kw_adt", $kw_adt);
		update_option("kw_eadt", $kw_eadt);
		update_option("kw_top_height", $kw_top_height);
		update_option("kw_top_target", $kw_top_target);
		
		update_option("kw_adr", $kw_adr);
		update_option("kw_eadr", $kw_eadr);
		update_option("kw_right_width", $kw_right_width);
		update_option("kw_right_target", $kw_right_target);
		
		update_option("kw_adl", $kw_adl);
		update_option("kw_eadl", $kw_eadl);
		update_option("kw_left_width", $kw_left_width);
		update_option("kw_left_target", $kw_left_target);
		
		update_option('kw_cssad', $_POST['kw_cssad']);
	
        echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
    }
		
?>
<?php /**Start Form for advertises**/?>

<div class="wrap">
<div id="theme-options-wrap">
  <div class="icon32" id="icon-tools"><br />
  </div>
  <h2> Advertise Modern Zone Options</h2>
  <p>Take control of your theme, with a modern advertising zone with your own specific preferences.</p>
  <p>The simply way is to use a method with a special background. Optionnaly, just html + css and text coding work also.</p>
  <p>This three zones support html + css attribut, flash object and more... View readme text file for places one, two or three zone in your theme.</p>
  <div style="margin-left:620px; margin-top:69px;">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="WZG8AR3WCN9H8">
      <input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/en_US/FR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/fr_FR/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div>
  <div style="margin-top:-70px;">
    <form method="post" name="kw_advert" target="_self">
      <div style="Display: block; height: 15px; width: 100%;"></div>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">First step</th>
          <td><p style="margin: 0px;"> <a href="/wp-admin/themes.php?page=custom-background">Define a special background</a> <br />
              &nbsp;<br />
              &nbsp;<br />
              for your theme where the drawings advertises was included in the background image &nbsp;<br />
              &nbsp; </p></td>
        </tr>
        <tr valign="top">
          <th scope="row">Enable/Disable Top clickable zone:</th>
          <td><select name="kw_eadt">
              <option value="enable"<?php if(get_option('kw_eadt') == "enable") { echo ' selected="selected"'; } ?>>
              <?php if(get_option('kw_eadt') == "enable") { echo "Enabled"; } else { echo "Enable"; } ?>
              </option>
              <option value="disable"<?php if(get_option('kw_eadt') == "disable") { echo ' selected="selected"'; } ?>>
              <?php if(get_option('kw_eadt') == "disable") { echo "Disabled"; } else { echo "Disable"; } ?>
              </option>
            </select>
            <p style="margin: 0px;">
              <?php if(get_option('kw_eadt') !== NULE) { ?>
              Top clickable zone are currently <span style="color: #D13E12; font-weight: strong;">
              <?php $kw_eadt = get_option('kw_eadt'); echo $kw_eadt; ?>
              </span>
              <?php } ?>
            </p></td>
        </tr>
        <tr valign="top" <?php $kw_eadt = get_option('kw_eadt'); if ($kw_eadt == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Define height attribut</th>
          <td><input type='text' style="width:125px;"  maxlength="6" name='kw_top_height' id="kw_top_height" value="<?php echo get_option("kw_top_height"); ?>" />
            for this zone to make cliquable (automatic width @ 100%, start @ align top-center)</td>
        </tr>
        <tr valign="top" <?php $kw_eadt = get_option('kw_eadt'); if ($kw_eadt == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Define link target</th>
          <td><input type='text' style="width:250px;" maxlength="120" name='kw_top_target' id="kw_top_target" value="<?php echo get_option("kw_top_target"); ?>" /></td>
        </tr>
        <tr valign="top" <?php $kw_eadt = get_option('kw_eadt'); if ($kw_eadt == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Copy and paste your flash effect</th>
          <td><p style="margin: 0px 0px 5px 0px;"><em>Optionnal <a href="http://www.effectgenerator.com/" target="_new">effect generator online</a></em></p>
            <p style="margin: 0px 0px 5px 0px;">
              <textarea name="kw_adt" maxlength="1000" cols="60" rows="7" id="kw_adt"><?php if ($kw_adt == NULL){ echo ("&shy;") ;}?><?php echo get_option("kw_adt"); ?></textarea>
            </p></td>
        </tr>
        <tr valign="top">
          <th scope="row">Enable/Disable Left clickable zone:</th>
          <td><select name="kw_eadl">
              <option value="enable"<?php if(get_option('kw_eadl') == "enable") { echo ' selected="selected"'; } ?>>
              <?php if(get_option('kw_eadl') == "enable") { echo "Enabled"; } else { echo "Enable"; } ?>
              </option>
              <option value="disable"<?php if(get_option('kw_eadl') == "disable") { echo ' selected="selected"'; } ?>>
              <?php if(get_option('kw_eadl') == "disable") { echo "Disabled"; } else { echo "Disable"; } ?>
              </option>
            </select>
            <p style="margin: 0px;">
              <?php if(get_option('kw_eadl') !== NULE) { ?>
              Left clickable zone are currently <span style="color: #D13E12; font-weight: strong;">
              <?php $kw_eadl = get_option('kw_eadl'); echo $kw_eadl; ?>
              </span>
              <?php } ?>
            </p></td>
        </tr>
        <tr valign="top" <?php $kw_eadl = get_option('kw_eadl'); if ($kw_eadl == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Define width attribut</th>
          <td><input type='text' style="width:125px;"  maxlength="6" name='kw_left_width' id="kw_left_width" value="<?php echo get_option("kw_left_width"); ?>" />
            for this zone to make cliquable (automatic height @ 100%, start top 0 - left 0)</td>
        </tr>
        <tr valign="top" <?php $kw_eadl = get_option('kw_eadl'); if ($kw_eadl == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Define link target</th>
          <td><input type='text' style="width:250px;" maxlength="120" name='kw_left_target' id="kw_left_target" value="<?php echo get_option("kw_left_target"); ?>" /></td>
        </tr>
        <tr valign="top" <?php $kw_eadl = get_option('kw_eadl'); if ($kw_eadl == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Copy and paste your flash effect</th>
          <td><p style="margin: 0px 0px 5px 0px;"><em>Optionnal <a href="http://www.effectgenerator.com/" target="_new">effect generator online</a></em></p>
            <p style="margin: 0px 0px 5px 0px;">
              <textarea name="kw_adl" maxlength="1000" cols="60" rows="7" id="kw_adl"><?php if ($kw_adl == NULL){ echo ("&shy;") ;}?><?php echo get_option("kw_adl"); ?></textarea>
            </p></td>
        </tr>
        <tr valign="top">
          <th scope="row">Enable/Disable Right clickable zone:</th>
          <td><select name="kw_eadr">
              <option value="enable"<?php if(get_option('kw_eadr') == "enable") { echo ' selected="selected"'; } ?>>
              <?php if(get_option('kw_eadr') == "enable") { echo "Enabled"; } else { echo "Enable"; } ?>
              </option>
              <option value="disable"<?php if(get_option('kw_eadr') == "disable") { echo ' selected="selected"'; } ?>>
              <?php if(get_option('kw_eadr') == "disable") { echo "Disabled"; } else { echo "Disable"; } ?>
              </option>
            </select>
            <p style="margin: 0px;">
              <?php if(get_option('kw_eadr') !== NULE) { ?>
              Right clickable zone are currently <span style="color: #D13E12; font-weight: strong;">
              <?php $kw_eadr = get_option('kw_eadr'); echo $kw_eadr; ?>
              </span>
              <?php } ?>
            </p></td>
        </tr>
        <tr valign="top" <?php $kw_eadr = get_option('kw_eadr'); if ($kw_eadr == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Define width attribut</th>
          <td><input type='text' style="width:125px;"  maxlength="6" name='kw_right_width' id="kw_right_width" value="<?php echo get_option("kw_right_width"); ?>" />
            for this zone to make cliquable (automatic height @ 100%, start top 0 - right 0)</td>
        </tr>
        <tr valign="top" <?php $kw_eadr = get_option('kw_eadr'); if ($kw_eadr == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Define link target</th>
          <td><input type='text' style="width:250px;" maxlength="120" name='kw_right_target' id="kw_right_target" value="<?php echo get_option("kw_right_target"); ?>" /></td>
        </tr>
        <tr valign="top" <?php $kw_eadr = get_option('kw_eadr'); if ($kw_eadr == "disable") { ?>style="display: none;"<?php } ?>>
          <th scope="row">Copy and paste your flash effect</th>
          <td><p style="margin: 0px 0px 5px 0px;"><em>Optionnal <a href="http://www.effectgenerator.com/" target="_new">effect generator online</a></em></p>
            <p style="margin: 0px 0px 5px 0px;">
              <textarea name="kw_adr" maxlength="1000" cols="60" rows="7" id="kw_adr"><?php if ($kw_adr == NULL){ echo ("&shy;") ;}?><?php echo get_option("kw_adr"); ?></textarea>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">Enable / Disable based css</th>
          <td><input type='checkbox' name='kw_cssad' value='1' <?php if ( get_option( 'kw_cssad' ) ) { echo 'checked'; } ?> />
            <?php _e( 'Enable the based css.', 'kw-modern-advertise' ); echo " <em>(" . __( "Recommended", "kw-modern-advertise" ) . ")</em>"; ?></td>
        </tr>
      </table>
      <p class="submit">
        <input name="submitted" type="hidden" value="yes" />
        <input type="submit" name="Submit" value="Update &raquo;" />
      </p>
      <div style="Display: block; height: 15px; width: 100%;"></div>
    </form>
  </div>
</div>
<?php 
}
?>
