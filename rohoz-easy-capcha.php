<?php
				if (session_id() == "") {
					session_start();
				}
/**
 * @package RohoZ Easy captcha
 */
/*
 Plugin Name: RohoZ Easy captcha
 Plugin URI: https://rohoz.com/easy-captcha
 Description: RohoZ Easy captcha is a free, fast and easy that protects your sites from spam and abuse.
 Version: 3.0
 Author: RohoZ
 Author URI: https://rohoz.com/
 Plugin License: GPL3
 Text Domain: rohoz
*/
/*

Copyright 2014-2019 RohoZ, Inc.
*/
if (!defined('ABSPATH')) {
	die( 'Direct access not allowed!' );
}
if (!defined('WPINC')) {
	die( 'Direct access not allowed!' );
}
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
define( 'RohoZ_EC_Ecaptcha_VERSION', '3.0' );
define( 'RohoZ_EC_Ecaptcha_MINIMUM_WP_VERSION', '4.6' );
define( 'RohoZ_EC_Ecaptcha_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RohoZ_EC_Ecaptcha_DELETE_LIMIT', 100000 );
	if ((!get_option("RohoZ_EC_site_key") || !get_option("RohoZ_EC_secret_key") || !get_option("RohoZ_EC_Lang_key") || !get_option("RohoZ_EC_Color_key")) && (get_option("RohoZ_EC_site_key")=='' || get_option("RohoZ_EC_secret_key")=='' || get_option("RohoZ_EC_Lang_key")=='' || get_option("RohoZ_EC_Color_key")=='')) {
    add_action( 'admin_notices', array('RohoZ_EC_class', "RohoZ_EC_admin_notices") );
	}
if ( ! class_exists( 'RohoZ_EC_class' ) ) {
		class RohoZ_EC_class {
			function RohoZ_EC_add_plugin_action_links($links) {
				return array_merge(array("settings" => "<a href=\"options-general.php?page=RohoZ-ec-options\">"."Settings"."</a>"), $links);
			}
			function RohoZ_EC_activation($plugin) {
				if ($plugin == plugin_basename(__FILE__) && (!get_option("RohoZ_EC_site_key") || !get_option("RohoZ_EC_secret_key") || !get_option("RohoZ_EC_Lang_key") || !get_option("RohoZ_EC_Color_key"))) {
					exit(wp_redirect(admin_url("options-general.php?page=RohoZ-ec-options")));
				}
			}
			function RohoZ_EC_options_page() {
				$keywarning='';
				if ((!get_option("RohoZ_EC_site_key") || !get_option("RohoZ_EC_secret_key") || !get_option("RohoZ_EC_Lang_key") || !get_option("RohoZ_EC_Color_key")) && (get_option("RohoZ_EC_site_key")=='' || get_option("RohoZ_EC_secret_key")=='' || get_option("RohoZ_EC_Lang_key")=='' || get_option("RohoZ_EC_Color_key")=='')) {
					$keywarning='<div class="rohoz_warning"><span></span>
						<h2>What first?</h2>
						<ol>
							<li>If you have not already registered on <a href="https://rohoz.com/" target="_blank" rel="external">RohoZ</a>, first <a href="https://rohoz.com/singup/" target="_blank" rel="external">sign up in RohoZ</a>.(Easy and fast)</li>
							<li>You have to <a href="https://rohoz.com/start/96520" target="_blank" rel="external">register your domain</a> first, get required keys from RohoZ and save them below.</li>
						</ol>
					</div>';
				}
				if (get_option("RohoZ_EC_Head_VerfCode")) {
				echo "<div class=\"wrap\">
				<h1 class=\"rohoz_header\">"."RohoZ Easy captcha"."</h1>
				<div class=\"rohoz_help\"><span></span>
					<a href=\"https://rohoz.com/help/how-do-i-register\" target=\"_blank\" rel=\"external\">How do I register?</a><a href=\"https://rohoz.com/help/easy-captcha/how-do-i-get-the-key\" target=\"_blank\" rel=\"external\">How do I get the key?</a><a href=\"https://rohoz.com/donate\" target=\"_blank\" rel=\"external\">Donate</a>
				</div>
				".$keywarning.'<h2 class="nav-tab-wrapper" id="wpseo-tabs"><a class="nav-tab nav-tab-active" id="dashboard-tab">Settings</a><a class="nav-tab" id="prevented-tab">List prevented</a></h2>'."
				<div id=\"dashboard\" class=\"wpseotab active\"><form method=\"post\" action=\"options.php\">";
				$RohoZ_EC_Head_VerfCode = filter_var(get_option("RohoZ_EC_Head_VerfCode"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$RohoZ_EC_site_key = filter_var(get_option("RohoZ_EC_site_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$RohoZ_EC_secret_key = filter_var(get_option("RohoZ_EC_secret_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$RohoZ_EC_Lang_key = filter_var(get_option("RohoZ_EC_Lang_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if (empty($RohoZ_EC_Lang_key)) {
				$RohoZ_EC_Lang_key='en';
				}
				$RohoZ_EC_Color_key = filter_var(get_option("RohoZ_EC_Color_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if (empty($RohoZ_EC_Color_key)) {
					$RohoZ_EC_Color_key='white';
				}
				$RohoZ_EC_Error_Message = filter_var(get_option("RohoZ_EC_Error_Message"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				if (empty($RohoZ_EC_Error_Message)) {
					$RohoZ_EC_Error_Message='<strong>ERROR:</strong> RohoZ Easy captcha verification failed.';
				}

				$RohoZ_EC_whitelist = get_option("RohoZ_EC_whitelist");
				$RohoZ_EC_Blacklist = get_option("RohoZ_EC_Blacklist");
 				$RohoZ_EC_woocommerceActive=$RohoZ_EC_cf7Active=' disabled="disabled"';
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					$RohoZ_EC_woocommerceActive='';
				}
				/*if ( in_array( 'contact-form-7/contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					$RohoZ_EC_cf7Active='';
				}*/
				$RohoZ_EC_cf7Active='';
				$Checkwarning='';
				if ((!get_option("RohoZ_EC_site_key") || !get_option("RohoZ_EC_secret_key") || !get_option("RohoZ_EC_Lang_key") || !get_option("RohoZ_EC_Color_key")) && (get_option("RohoZ_EC_site_key")=='' || get_option("RohoZ_EC_secret_key")=='' || get_option("RohoZ_EC_Lang_key")=='' || get_option("RohoZ_EC_Color_key")=='')) {
					if (!get_option("RohoZ_EC_login_check_disable") && !get_option("RohoZ_EC_register_check_disable") && !get_option("RohoZ_EC_comment_check_disable") && !get_option("RohoZ_EC_lostpassword_check_disable") && !get_option("RohoZ_EC_woocommerce_check_disable") && !get_option("RohoZ_EC_cf7_check_disable") && !get_option("RohoZ_EC_limitation_enable")) {
					$Checkwarning=' checked="checked"';
					}
					if (!get_option("RohoZ_EC_ipblock_enable")) {
update_option("RohoZ_EC_ipblock_enable",0);
					}
				}
				/* Add List Lang*/
				$RohoZ_EC_Langlist=array(array('en','English'),array('zh','Chinese'),array('ru','Russia'),array('de','German'),array('fr','France'),array('es','Spanish'),array('in','Hindi'),array('ar','Arabic'),array('it','Italian'));
				$RohoZ_EC_LanglistNum=count($RohoZ_EC_Langlist);
				$RohoZ_EC_LanglistOut='';
				for ($RohoZ_w = 0; $RohoZ_w < $RohoZ_EC_LanglistNum; $RohoZ_w++) {
					$RohoZ_EC_SelLang='';
					if ($RohoZ_EC_Lang_key==$RohoZ_EC_Langlist[$RohoZ_w][0]) {
					$RohoZ_EC_SelLang=' selected="selected"';
					}
					$RohoZ_EC_LanglistOut .='<option'.$RohoZ_EC_SelLang.' value="'.$RohoZ_EC_Langlist[$RohoZ_w][0].'">'.$RohoZ_EC_Langlist[$RohoZ_w][1].'</option>';
				}
				/* Add List color*/
				$RohoZ_EC_Colorlist=array(array('white','White'),array('black','Black'),array('gray','Gray'));
				$RohoZ_EC_ColorlistNum=count($RohoZ_EC_Colorlist);
				$RohoZ_EC_ColorlistOut='';
				for ($RohoZ_w = 0; $RohoZ_w < $RohoZ_EC_ColorlistNum; $RohoZ_w++) {
					$RohoZ_EC_SelColor='';
					if ($RohoZ_EC_Color_key==$RohoZ_EC_Colorlist[$RohoZ_w][0]) {
					$RohoZ_EC_SelColor=' selected="selected"';
					}
					$RohoZ_EC_ColorlistOut .='<option'.$RohoZ_EC_SelColor.' value="'.$RohoZ_EC_Colorlist[$RohoZ_w][0].'">'.$RohoZ_EC_Colorlist[$RohoZ_w][1].'</option>';
				}
				$RohoZ_EC_limitation_Subn='';
				if (!get_option("RohoZ_EC_limitation_enable") && $Checkwarning=='') {
				$RohoZ_EC_limitation_Subn=' style="display: none;"';
				}
				echo '<fieldset class="rohoz_fieldset">
    	    			<legend>RohoZ Key and setting</legend>
				<div class="rohoz_input"><label for="RohoZ_EC_Head_VerfCode">Domain verification<span class="dashicons dashicons-admin-network"></span></label><input readonly="readonly" type="text" name="RohoZ_EC_Head_VerfCode" class="regular-text" id="RohoZ_EC_Head_VerfCode" value="'.$RohoZ_EC_Head_VerfCode.'" ></div>
				<div class="rohoz_input"><label for="RohoZ_EC_site_key">Site Key<span class="dashicons dashicons-lock"></span></label><input type="text" name="RohoZ_EC_site_key" class="regular-text" id="RohoZ_EC_site_key" value="'.$RohoZ_EC_site_key.'" ></div>
				<div class="rohoz_input rohoz_hide"><label for="RohoZ_EC_secret_key">Secret Key<span class="dashicons dashicons-lock"></span></label><input type="hidden" name="RohoZ_EC_secret_key" class="regular-text" id="RohoZ_EC_secret_key" value="'.$RohoZ_EC_Head_VerfCode.'" ></div>
				<div class="rohoz_input"><label for="RohoZ_EC_Lang_key">Language<span class="dashicons dashicons-admin-site-alt3"></span></label><select id="RohoZ_EC_Lang_key" name="RohoZ_EC_Lang_key" size="1" value="'.$RohoZ_EC_Lang_key.'"><option value="">Please select language</option>'.$RohoZ_EC_LanglistOut.'</select></div>
				<div class="rohoz_input"><label for="RohoZ_EC_Color_key">Color<span class="dashicons dashicons-image-filter"></span></label><select id="RohoZ_EC_Color_key" name="RohoZ_EC_Color_key" size="1" value="'.$RohoZ_EC_Color_key.'"><option value="">Please select color</option>'.$RohoZ_EC_ColorlistOut.'</select></div>
    			<button name="reset" id="reset" class="button rohoz_button"><span class="dashicons dashicons-no"></span>Delete Keys and Disable</button>
				<button name="reset" id="resetall" class="button rohoz_button"><span class="dashicons dashicons-trash"></span>Delete Domain verification and Disable</button>
				</fieldset>
				<fieldset class="rohoz_fieldset">
    	    			<legend>IP</legend>
				<div class="rohoz_input"><label for="RohoZ_EC_whitelist">Whitelist IP<span class="dashicons dashicons-filter"></span></label><textarea type="text" name="RohoZ_EC_whitelist" class="regular-text" id="RohoZ_EC_whitelist">'.$RohoZ_EC_whitelist.'</textarea></div>
				<div class="rohoz_input"><label for="RohoZ_EC_Blacklist">Blacklist IP<span class="dashicons dashicons-filter"></span></label><textarea type="text" name="RohoZ_EC_Blacklist" class="regular-text" id="RohoZ_EC_Blacklist">'.$RohoZ_EC_Blacklist.'</textarea></div>
    			<button name="reset1" id="reset1" class="button">Reset IP list</button>
				</fieldset>
				<fieldset class="rohoz_fieldset">
    	    			<legend>RohoZ Easy captcha Active for</legend>
				<div class="rohoz_checkbox"><input type="checkbox" name="RohoZ_EC_login_check_disable" id="RohoZ_EC_login_check_disable" value="1" '.checked(1, get_option("RohoZ_EC_login_check_disable"), false).$Checkwarning.'><label for="RohoZ_EC_login_check_disable"><label for="RohoZ_EC_login_check_disable"></label></label><label for="RohoZ_EC_login_check_disable">Active for login form</label></div>
				<div class="rohoz_checkbox"><input type="checkbox" name="RohoZ_EC_register_check_disable" id="RohoZ_EC_register_check_disable" value="1" '.checked(1, get_option("RohoZ_EC_register_check_disable"), false).$Checkwarning.'><label for="RohoZ_EC_register_check_disable"><label for="RohoZ_EC_register_check_disable"></label></label><label for="RohoZ_EC_register_check_disable">Active for register form</label></div>
				<div class="rohoz_checkbox"><input type="checkbox" name="RohoZ_EC_comment_check_disable" id="RohoZ_EC_comment_check_disable" value="1" '.checked(1, get_option("RohoZ_EC_comment_check_disable"), false).$Checkwarning.'><label for="RohoZ_EC_comment_check_disable"><label for="RohoZ_EC_comment_check_disable"></label></label><label for="RohoZ_EC_comment_check_disable">Active for comment form</label></div>
				<div class="rohoz_checkbox"><input type="checkbox" name="RohoZ_EC_lostpassword_check_disable" id="RohoZ_EC_lostpassword_check_disable" value="1" '.checked(1, get_option("RohoZ_EC_lostpassword_check_disable"), false).$Checkwarning.'><label for="RohoZ_EC_lostpassword_check_disable"><label for="RohoZ_EC_lostpassword_check_disable"></label></label><label for="RohoZ_EC_lostpassword_check_disable">Active for Reset password form</label></div>
				<div class="rohoz_checkbox"><input'.$RohoZ_EC_woocommerceActive.' type="checkbox" name="RohoZ_EC_woocommerce_check_disable" id="RohoZ_EC_woocommerce_check_disable" value="1" '.checked(1, get_option("RohoZ_EC_woocommerce_check_disable"), false).$Checkwarning.'><label for="RohoZ_EC_woocommerce_check_disable"><label for="RohoZ_EC_woocommerce_check_disable"></label></label><label for="RohoZ_EC_woocommerce_check_disable">Active for woocommerce plugin</label></div>
				<div class="rohoz_checkbox"><input'.$RohoZ_EC_cf7Active.' type="checkbox" name="RohoZ_EC_cf7_check_disable" id="RohoZ_EC_cf7_check_disable" value="1" '.checked(1, get_option("RohoZ_EC_cf7_check_disable"), false).$Checkwarning.'><label for="RohoZ_EC_cf7_check_disable"><label for="RohoZ_EC_cf7_check_disable"></label></label><label for="RohoZ_EC_cf7_check_disable">Active for Contact Form 7 plugin</label></div>
				</fieldset>
				<fieldset class="rohoz_fieldset">
    	    			<legend>limitation</legend>
				<div class="rohoz_checkbox"><input type="checkbox" name="RohoZ_EC_limitation_enable" id="RohoZ_EC_limitation_enable" value="1" '.checked(1, get_option("RohoZ_EC_limitation_enable"), false).$Checkwarning.'><label for="RohoZ_EC_limitation_enable"><label for="RohoZ_EC_limitation_enable"></label></label><label for="RohoZ_EC_limitation_enable">Enable restrict Login Attempts</label></div>
					<fieldset class="rohoz_fieldset" id="RohoZ_EC_limitation_Sub"'.$RohoZ_EC_limitation_Subn.'>
    	    			<legend>If the user answers more than 5 times incorrectly.</legend>
						<div class="rohoz_checkbox"><input type="radio" name="RohoZ_EC_ipblock_enable" id="RohoZ_EC_ipblock_enable" value="0" '.checked(0, get_option("RohoZ_EC_ipblock_enable"), false).$Checkwarning.'><label for="RohoZ_EC_ipblock_enable"><label for="RohoZ_EC_ipblock_enable"></label></label><label for="RohoZ_EC_ipblock_enable">Blocking user ip</label></div>
						<div class="rohoz_checkbox"><input type="radio" name="RohoZ_EC_ipblock_enable" id="RohoZ_EC_ipblock_enable1" value="1" '.checked(1, get_option("RohoZ_EC_ipblock_enable"), false).$Checkwarning.'><label for="RohoZ_EC_ipblock_enable1"><label for="RohoZ_EC_ipblock_enable1"></label></label><label for="RohoZ_EC_ipblock_enable1">Block user temporarily</label></div>


					</fieldset>

				</fieldset>
				<fieldset class="rohoz_fieldset">
    	    			<legend>Error Message</legend>
				<div class="rohoz_input"><label for="RohoZ_EC_Error_Message">Error Message</label><input type="text" name="RohoZ_EC_Error_Message" class="regular-text" id="RohoZ_EC_Error_Message" value="'.$RohoZ_EC_Error_Message.'" ></div>
				';
				settings_fields("RohoZ_EC_header_section");
				do_settings_sections("RohoZ-ec-options");
				submit_button();
if (file_exists(plugin_dir_path( __FILE__ ).'data/list.php')) {
require_once plugin_dir_path( __FILE__ ) . 'data/list.php';
$RohoZ_EC_BListNum=count($RohoZ_EC_BList);
$RohoZ_EC_BList1 = array_reverse($RohoZ_EC_BList);
$RohoZ_EC_OutList ='';
for ($i = 0; $i < $RohoZ_EC_BListNum; $i++) {
if ($RohoZ_EC_Blacklist=='') {
	$RohoZ_EC_OutList .='<div><div><p><b>IP:</b> '.$RohoZ_EC_BList1[$i][0].'</p><p><b>Time:</b> '.$RohoZ_EC_BList1[$i][1].' '.$RohoZ_EC_BList1[$i][2].'</p><button rohozdata="'.$RohoZ_EC_BList1[$i][0].'" type="button" class="button rohoz_button AddList"><span class="dashicons dashicons-shield"></span>Block</button></div><pre><b>User agent:</b> '.$RohoZ_EC_BList1[$i][3].'</pre></div>';
} else {
if (strpos('list\\n'.$RohoZ_EC_Blacklist,$RohoZ_EC_BList1[$i][0]) == false) {
	$RohoZ_EC_OutList .='<div><div><p><b>IP:</b> '.$RohoZ_EC_BList1[$i][0].'</p><p><b>Time:</b> '.$RohoZ_EC_BList1[$i][1].' '.$RohoZ_EC_BList1[$i][2].'</p><button rohozdata="'.$RohoZ_EC_BList1[$i][0].'" type="button" class="button rohoz_button AddList"><span class="dashicons dashicons-shield"></span>Block</button></div><pre><b>User agent:</b> '.$RohoZ_EC_BList1[$i][3].'</pre></div>';
} else {
	$RohoZ_EC_OutList .='<div><div><p><b>IP:</b> '.$RohoZ_EC_BList1[$i][0].'</p><p><b>Time:</b> '.$RohoZ_EC_BList1[$i][1].' '.$RohoZ_EC_BList1[$i][2].'</p></div><pre><b>User agent:</b> '.$RohoZ_EC_BList1[$i][3].'</pre></div>';
}
}

}
}
if ($RohoZ_EC_OutList=='') {
$RohoZ_EC_OutList ='<p style="text-align: center;padding: 28px 0;">list is empty.</p>';

}
				echo "<button type=\"reset\" name=\"reset\" id=\"resetall5\" class=\"button\">reset</button></fieldset></form></div><div id=\"prevented\" class=\"wpseotab\" style=\"display: none;\"><div class=\"rohoz_Listview\">".$RohoZ_EC_OutList."</div>
				</div>
				</div><script>
					(function($) {
					$('#reset').on('click', function(e) {
						e.preventDefault();
						$('#RohoZ_EC_site_key').val('');
						$('#RohoZ_EC_secret_key').val('');
						$('#RohoZ_EC_Lang_key').val('');
						$('#RohoZ_EC_Color_key').val('');
						$('#submit').trigger('click');
					});
					$('#resetall').on('click', function(e) {
						e.preventDefault();
						$('#RohoZ_EC_Head_VerfCode').val('');
						$('#RohoZ_EC_site_key').val('');
						$('#RohoZ_EC_secret_key').val('');
						$('#RohoZ_EC_Lang_key').val('');
						$('#RohoZ_EC_Color_key').val('');
						$('#submit').trigger('click');
					});
					$('#reset1').on('click', function(e) {
						e.preventDefault();
						$('#RohoZ_EC_whitelist').val('');
						$('#RohoZ_EC_Blacklist').val('');
						$('#submit').trigger('click');
					});
					$('#prevented-tab').on('click', function(e) {

						$('#dashboard-tab').removeClass('nav-tab-active');
						$('#prevented-tab').addClass('nav-tab-active');
						$('#dashboard').hide();
						$('#prevented').show();

					});
					$('#dashboard-tab').on('click', function(e) {

						$('#dashboard-tab').addClass('nav-tab-active');
						$('#prevented-tab').removeClass('nav-tab-active');
						$('#dashboard').show();
						$('#prevented').hide();

					});
					$('.AddList').on('click', function(e) {
$('#resetall5').trigger('click');
RohoZ_TextPlus=$('#RohoZ_EC_Blacklist').val()+'\\n'+$(this).attr('rohozdata');
					$('#RohoZ_EC_Blacklist').val(RohoZ_TextPlus);
$('#submit').trigger('click');

					});
					$('#RohoZ_EC_limitation_enable').on('change', function(e) {
            if($(this).prop('checked') == true){
						$('#RohoZ_EC_limitation_Sub').show();
            }else{
						$('#RohoZ_EC_limitation_Sub').hide();
			}

					});
					})(jQuery);
				</script>";
				}else{
/***************************/
				echo "<div class=\"wrap\">
				<h1 class=\"rohoz_header\">"."RohoZ Easy captcha"."</h1>
				<div class=\"rohoz_help\"><span></span>
					<a href=\"https://rohoz.com/help/how-do-i-register\" target=\"_blank\" rel=\"external\">How do I register?</a><a href=\"https://rohoz.com/help/easy-captcha/how-do-i-get-the-key\" target=\"_blank\" rel=\"external\">How do I get the key?</a><a href=\"https://rohoz.com/donate\" target=\"_blank\" rel=\"external\">Donate</a>
				</div>
				".$keywarning."
				<form method=\"post\" action=\"options.php\">";

				echo '<fieldset class="rohoz_fieldset">
    	    			<legend>Domain verification setting</legend>
				<div class="rohoz_input"><label for="RohoZ_EC_Head_VerfCode">Domain verification</label><input type="text" name="RohoZ_EC_Head_VerfCode" class="regular-text" id="RohoZ_EC_Head_VerfCode" value="" ></div>';
				settings_fields("RohoZ_EC_header_section");
				do_settings_sections("RohoZ-ec-options");
				submit_button();
				echo "</fieldset></form>
				</div>";

/******************************/
				}

			}

			function RohoZ_EC_menu() {
				add_submenu_page("options-general.php", "RohoZ Easy captcha", "RohoZ Easy captcha", "manage_options", "RohoZ-ec-options", array('RohoZ_EC_class', "RohoZ_EC_options_page"));
			}

			function RohoZ_EC_display_content() {
				echo "";
			}

			function RohoZ_EC_display_options() {
				add_settings_section("RohoZ_EC_header_section", "", array('RohoZ_EC_class', "RohoZ_EC_display_content"), "RohoZ-ec-options");

				register_setting("RohoZ_EC_header_section", "RohoZ_EC_site_key");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_secret_key");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_Lang_key");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_Color_key");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_whitelist");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_Blacklist");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_login_check_disable");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_register_check_disable");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_comment_check_disable");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_lostpassword_check_disable");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_woocommerce_check_disable");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_cf7_check_disable");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_Head_VerfCode");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_cf7_check_disable");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_limitation_enable");
				register_setting("RohoZ_EC_header_section", "RohoZ_EC_ipblock_enable");
			}
			function RohoZ_EC_admin_notices() {
        		// not working, or notice fired in last 30 seconds
        		$e_captcha_error = get_option('e_captcha_error');
        		$e_captcha_working = get_option('e_captcha_working');
        		$e_captcha_notice = get_option('e_captcha_notice');
        		$time = time();
        		if(!empty($e_captcha_error) && (empty($e_captcha_working) || ($time - $e_captcha_notice < 30))) {
            		$message_type = 'notice-error';

            		if (empty($message_type)) {
                		$message_type = 'notice-info';
            		}
            		echo '<div class="notice '.$message_type.' is-dismissible">
            		<p>
            		RohoZ Easy captcha has not been properly configured. <a href="options-general.php?page=RohoZ-ec-options">Click here</a> to configure.
            		</p>
            		</div>'."\n";
        		}
    		}
			function RohoZ_arraytostr($array)
{
$str=  json_encode($array, JSON_UNESCAPED_UNICODE);
$str = str_replace("[", "array(", $str);
$str = str_replace("]", ")", $str);
$str = str_replace("\/", "/", $str);
	return($str);
}
			function RohoZ_EC_Save_BList()
			{
				if (get_option("RohoZ_EC_limitation_enable")) {
				if (session_id() == "") {
					session_start();
				}

				if(isset($_SESSION['RohoZ_EC_visit'])) {
					$current_time=($_SESSION['RohoZ_EC_visit']*1)+1;
					$_SESSION['RohoZ_EC_visit']=$current_time;
				}else{
					$current_time=1;
					$_SESSION['RohoZ_EC_visit']=1;
				}

				if ($current_time>5) {
					if (get_option("RohoZ_EC_ipblock_enable")==0) {
$ip = RohoZ_EC_class::get_ip_address();
				$RohoZ_EC_Blacklist = get_option("RohoZ_EC_Blacklist");
				if ($RohoZ_EC_Blacklist=='') {
				update_option("RohoZ_EC_Blacklist",$ip);
				}else{
				update_option("RohoZ_EC_Blacklist",$RohoZ_EC_Blacklist."\n".$ip);
				}
					}else{
						$_SESSION['RohoZ_EC_Block']=1;
					}

				}
				}

        		$ip = RohoZ_EC_class::get_ip_address();
				$user_agent = addslashes($_SERVER['HTTP_USER_AGENT']);
				$date=date('Y/m/d');
				$Time=date('H:i:s');
if (file_exists(plugin_dir_path( __FILE__ )."data/list.php")) {
require(plugin_dir_path( __FILE__ )."data/list.php");
$counterNum=count($RohoZ_EC_BList);
if ($counterNum>98) {
array_splice($RohoZ_EC_BList, 0, $counterNum-98);
$counterNum=98;
}
} else {
$RohoZ_EC_BList=array();
$counterNum=0;
}
$RohoZ_EC_BList[$counterNum][0]=$ip;
$RohoZ_EC_BList[$counterNum][1]=$date;
$RohoZ_EC_BList[$counterNum][2]=$Time;
$RohoZ_EC_BList[$counterNum][3]=$user_agent;
$arraycounterStr=RohoZ_EC_class::RohoZ_arraytostr($RohoZ_EC_BList);
$file=fopen(plugin_dir_path( __FILE__ )."data/list.php",'w');
fwrite($file,'<?php $RohoZ_EC_BList = '.$arraycounterStr.'; ?>');
fclose($file);

			}
			function get_ip_address() {
        		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            		if (array_key_exists($key, $_SERVER) === true) {
                		foreach (explode(',', $_SERVER[$key]) as $ip) {
                    		$ip = trim($ip); // just to be safe
                    		$ip = filter_var($ip, FILTER_VALIDATE_IP);
                    		if (!empty($ip)) {
                        		return $ip;
                    		}
                		}
            		}
        		}
        		return false;
    		}
			function ip_in_whitelist() {

        		/* get whitelist and convert to array */
        		$whitelist_str = get_option('RohoZ_EC_whitelist');
       			if (!empty($whitelist_str)) {
            		$whitelist = explode("\r\n", trim($whitelist_str));
        		} else {
            		$whitelist = array();
        		}

        		/* get ip address */
        		$ip = RohoZ_EC_class::get_ip_address();

        		if ( !empty($ip) && !empty($whitelist) && in_array($ip, $whitelist) ) {
            		return true;
        		} else {
            		return false;
        		}

    		}
			function RohoZ_EC_Set403()
			{
				return '<div class="RohoZ_EC_403"><p>You do not have access to this page</p><pre>Powered by <a href="https://rohoz.com/easy-captcha/">RohoZ Easy captcha</a></pre><a href="https://rohoz.com">rohoz.com</a></div>';
			}
			function ip_in_Blacklist() {

        		/* get whitelist and convert to array */
        		$whitelist_str = get_option('RohoZ_EC_Blacklist');
       			if (!empty($whitelist_str)) {
            		$whitelist = explode("\r\n", trim($whitelist_str));
        		} else {
            		$whitelist = array();
        		}

        		/* get ip address */
        		$ip = RohoZ_EC_class::get_ip_address();

        		if ( !empty($ip) && !empty($whitelist) && in_array($ip, $whitelist) ) {
            		return true;
        		} else {
            		return false;
        		}

    		}
			function RohoZ_EC_display() {
				if (session_id() == "") {
					session_start();
				}
				if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
				echo RohoZ_EC_class::RohoZ_EC_Set403();
					http_response_code(403);
					die('You are not allowed to access this page.');
				} else {
				global $wp;
				$RohoZ_Lasturl=explode("?",add_query_arg( $wp->query_vars ));
				$_SESSION['RohoZ_Lasturl']=esc_url($RohoZ_Lasturl[0]) ;
				echo '<script>
				ROHOZ_ECID="'.get_option("RohoZ_EC_site_key").'";
				input_param="'.get_option("RohoZ_EC_secret_key").'";
				Lang="'.get_option("RohoZ_EC_Lang_key").'";
				Color="'.get_option("RohoZ_EC_Color_key").'";
				var i;if(i==null){i=1;}else{i++;}d=document;dom=window.location.host;if (i==1){s=d.createElement("script");s.src="https://rohoz.com/e-captcha/server1/easy-captcha.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);s=d.createElement("link");s.href="https://rohoz.com/e-captcha/server1/easy-captcha.css";s.rel="stylesheet";s.type="text/css";d.getElementsByTagName("head")[0].appendChild(s);d.write(\'<div class="ecaptcha" id="helpecaptcha"><samp title="Help"  EcapGopen="wecaptcha">&#xa00b;</samp><div EcapGclose="wecaptcha" id="wecaptcha" class="wecaptcha"></div></div>\');}else{d.write(\'<div class="ecaptcha" id="helpecaptcha"><samp title="Help"  EcapGopen="wecaptcha">&#xa00b;</samp></div>\');}d.write(\'<div ecin="\'+input_param+\'" ecid="aecaptcha\'+i+\'" id="aecaptcha\'+i+\'"></div>\');
				</script>';

				}
			}
			function RohoZ_EC_display_Woo() {
				if (session_id() == "") {
					session_start();
				}
				if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
					echo RohoZ_EC_class::RohoZ_EC_Set403();
					http_response_code( 403 );
					die('You are not allowed to access this page.');
				} else {
				global $wp;
				$RohoZ_Lasturl=explode("?",add_query_arg( $wp->query_vars ));
				$_SESSION['RohoZ_Lasturl']=esc_url($RohoZ_Lasturl[0]) ;
				echo '<script>
				ROHOZ_ECID="'.get_option("RohoZ_EC_site_key").'";
				input_param="'.get_option("RohoZ_EC_secret_key").'";
				Lang="'.get_option("RohoZ_EC_Lang_key").'";
				Color="'.get_option("RohoZ_EC_Color_key").'";
				var i;if(i==null){i=1;}else{i++;}d=document;dom=window.location.host;if (i==1){s=d.createElement("script");s.src="https://rohoz.com/e-captcha/server1/easy-captcha.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);s=d.createElement("link");s.href="https://rohoz.com/e-captcha/server1/easy-captcha.css";s.rel="stylesheet";s.type="text/css";d.getElementsByTagName("head")[0].appendChild(s);d.write(\'<div class="ecaptcha" id="helpecaptcha"><samp title="Help"  EcapGopen="wecaptcha">&#xa00b;</samp><div EcapGclose="wecaptcha" id="wecaptcha" class="wecaptcha"></div></div>\');}else{d.write(\'<div class="ecaptcha" id="helpecaptcha"><samp title="Help"  EcapGopen="wecaptcha">&#xa00b;</samp></div>\');}d.write(\'<div ecin="\'+input_param+\'" ecid="aecaptcha\'+i+\'" id="aecaptcha\'+i+\'"></div>\');
				 setTimeout("RohoZ_EC_Reload_Woo()", 100);
				</script>';

				}
			}
			function RohoZ_EC_display_cf7($tag) {
					$outputte ='';
				if (get_option("RohoZ_EC_site_key") && get_option("RohoZ_EC_secret_key") && get_option("RohoZ_EC_Lang_key") && get_option("RohoZ_EC_Color_key") && !is_user_logged_in() && !RohoZ_EC_class::ip_in_whitelist() /*&& !function_exists("wpcf7_contact_form_shortcode")*/) {
				if (session_id() == "") {
					session_start();
				}

				if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
					echo RohoZ_EC_class::RohoZ_EC_Set403();
					http_response_code( 403 );
					die('You are not allowed to access this page.');
					$outputte ='You are not allowed to access this page.';
				} else {
				global $wp;
				$RohoZ_Lasturl=explode("?",add_query_arg( $wp->query_vars ));
				$_SESSION['RohoZ_Lasturl']=esc_url($RohoZ_Lasturl[0]) ;
				$outputte= '<script>
				ROHOZ_ECID="'.get_option("RohoZ_EC_site_key").'";
				input_param="'.get_option("RohoZ_EC_secret_key").'";
				Lang="'.get_option("RohoZ_EC_Lang_key").'";
				Color="'.get_option("RohoZ_EC_Color_key").'";
				var i;if(i==null){i=1;}else{i++;}d=document;dom=window.location.host;if (i==1){s=d.createElement("script");s.src="https://rohoz.com/e-captcha/server1/easy-captcha.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);s=d.createElement("link");s.href="https://rohoz.com/e-captcha/server1/easy-captcha.css";s.rel="stylesheet";s.type="text/css";d.getElementsByTagName("head")[0].appendChild(s);d.write(\'<div class="ecaptcha" id="helpecaptcha"><samp title="Help"  EcapGopen="wecaptcha">&#xa00b;</samp><div EcapGclose="wecaptcha" id="wecaptcha" class="wecaptcha"></div></div>\');}else{d.write(\'<div class="ecaptcha" id="helpecaptcha"><samp title="Help"  EcapGopen="wecaptcha">&#xa00b;</samp></div>\');}d.write(\'<div ecin="\'+input_param+\'" ecid="aecaptcha\'+i+\'" id="aecaptcha\'+i+\'"></div>\');
				setTimeout("ROHOZ_EC_setbut_cf7(\'aecaptcha"+i+"\')", 100);
				</script><span class="wpcf7-form-control-wrap rohozecaptcha"><input name="rohozecaptcha" style="display: none" type="text"></span>';


				}
				}
				return $outputte;
			}
			function RohoZ_EC_Shortcode() {
				if (session_id() == "") {
					session_start();
				}
				if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
					echo RohoZ_EC_class::RohoZ_EC_Set403();
					http_response_code( 403 );
					die('You are not allowed to access this page.');
				} else {
				global $wp;
				$RohoZ_Lasturl=explode("?",add_query_arg( $wp->query_vars ));
				$_SESSION['RohoZ_Lasturl']=esc_url($RohoZ_Lasturl[0]) ;
				echo '<script class="rohoz_ecaptcha">
				ROHOZ_ECID="'.get_option("RohoZ_EC_site_key").'";
				input_param="c'.get_option("RohoZ_EC_secret_key").'";
				Lang="'.get_option("RohoZ_EC_Lang_key").'";
				Color="'.get_option("RohoZ_EC_Color_key").'";
				var i;if(i==null){i=1;}else{i++;}d=document;dom=window.location.host;if (i==1){s=d.createElement("script");s.src="https://rohoz.com/e-captcha/server1/easy-captcha.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);s=d.createElement("link");s.href="https://rohoz.com/e-captcha/server1/easy-captcha.css";s.rel="stylesheet";s.type="text/css";d.getElementsByTagName("head")[0].appendChild(s);d.write(\'<div class="ecaptcha" id="helpecaptcha"><samp title="Help"  EcapGopen="wecaptcha">&#xa00b;</samp><div EcapGclose="wecaptcha" id="wecaptcha" class="wecaptcha"></div></div>\');}else{d.write(\'<div class="ecaptcha" id="helpecaptcha"><samp title="Help"  EcapGopen="wecaptcha">&#xa00b;</samp></div>\');}d.write(\'<div ecin="\'+input_param+\'" ecid="aecaptcha\'+i+\'" id="aecaptcha\'+i+\'"></div>\');
				//setTimeout("ROHOZ_EC_setbut(\'aecaptcha"+i+"\')", 100);
				</script>';

				}
			}
			function RohoZ_EC_get_host($url) {
    			$host = parse_url($url, PHP_URL_HOST);
    			$names = explode(".", $host);
				if(count($names) == 1) {
        			return $names[0];
    			}
    			$names = array_reverse($names);
    			return $names[1] . '.' . $names[0];
			}
			function RohoZ_EC_verify($input) {
					$RohoZ_EC_ErrorLoad=get_option("RohoZ_EC_Error_Message");
				if (/*isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) !== 'wp-login.php' &&*/ $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[get_option("RohoZ_EC_secret_key")])) {
					$RohoZ_EC_base_site_url=get_site_url();
					$RohoZ_EC_out_site_url=RohoZ_EC_class::RohoZ_EC_get_host($RohoZ_EC_base_site_url);
					$RohoZ_EC_site_key = filter_var(get_option("RohoZ_EC_site_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$RohoZ_EC_ecaptcha_response = filter_input(INPUT_POST, get_option("RohoZ_EC_secret_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$verifyResponse =wp_remote_fopen("https://rohoz.com/e-captcha/server1/ecaptcha.html?siteverify={$RohoZ_EC_site_key}&t={$RohoZ_EC_out_site_url}&d=i&l=en&ep={$RohoZ_EC_ecaptcha_response}");
					$response = json_decode($verifyResponse, true);
/*if( is_wp_error( $response ) ) {
	wp_die($response->get_error_message()) ;
}
*///wp_die($response['Out']);
					if ($response['Out']=='true') {
						return $input;
					} elseif (is_array($input)) { // Array = Comment else Object
						RohoZ_EC_class::RohoZ_EC_Save_BList();
						$RohoZ_EC_ffffff='javascript:history.back()';
						if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
						$RohoZ_EC_ffffff=$_SESSION['RohoZ_Lasturl'];
						}
						wp_die("<p>".$RohoZ_EC_ErrorLoad."<br><a href=\"".$RohoZ_EC_ffffff."\">Back</a></p>", "RohoZ Easy captcha", array("response" => 403, "back_link" => 0));
					} else {
						RohoZ_EC_class::RohoZ_EC_Save_BList();
						$RohoZ_EC_ffffff='javascript:history.back()';
						if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
						$RohoZ_EC_ffffff=$_SESSION['RohoZ_Lasturl'];
						}
						wp_die("<p>".$RohoZ_EC_ErrorLoad."<br><a href=\"".$RohoZ_EC_ffffff."\">Back</a></p>", "RohoZ Easy captcha", array("response" => 403, "back_link" => 0));
					}
				} else {
						RohoZ_EC_class::RohoZ_EC_Save_BList();
						$RohoZ_EC_ffffff='javascript:history.back()';
						if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
						$RohoZ_EC_ffffff=$_SESSION['RohoZ_Lasturl'];
						}
						wp_die("<p>".$RohoZ_EC_ErrorLoad."<br><a href=\"".$RohoZ_EC_ffffff."\">Back</a></p>", "RohoZ Easy captcha", array("response" => 403, "back_link" => 0));
				}
			}
			function RohoZ_EC_woo_verify($input) {
					$RohoZ_EC_ErrorLoad=get_option("RohoZ_EC_Error_Message");
				if (/*isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) !== 'wp-login.php' &&*/ $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[get_option("RohoZ_EC_secret_key")])) {
					$RohoZ_EC_base_site_url=get_site_url();
					$RohoZ_EC_out_site_url=RohoZ_EC_class::RohoZ_EC_get_host($RohoZ_EC_base_site_url);
					$RohoZ_EC_site_key = filter_var(get_option("RohoZ_EC_site_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$RohoZ_EC_ecaptcha_response = filter_input(INPUT_POST, get_option("RohoZ_EC_secret_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$verifyResponse =wp_remote_fopen("https://rohoz.com/e-captcha/server1/ecaptcha.html?siteverify={$RohoZ_EC_site_key}&t={$RohoZ_EC_out_site_url}&d=i&l=en&ep={$RohoZ_EC_ecaptcha_response}");
					$response = json_decode($verifyResponse, true);
/*if( is_wp_error( $response ) ) {
	wp_die($response->get_error_message()) ;
}
*///wp_die($response['Out']);
$RohoZ_EC_Reload='';
if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
$RohoZ_EC_Reload= RohoZ_EC_class::RohoZ_EC_Set403();
}

					if ($response['Out']=='true') {

					} elseif (is_array($input)) { // Array = Comment else Object
						RohoZ_EC_class::RohoZ_EC_Save_BList();
						wc_add_notice('<p>'.$RohoZ_EC_ErrorLoad.'</p>'.$RohoZ_EC_Reload , 'error' );
					} else {
						RohoZ_EC_class::RohoZ_EC_Save_BList();
						wc_add_notice('<p>'.$RohoZ_EC_ErrorLoad.'</p>'.$RohoZ_EC_Reload , 'error' );
					}
				} else {
						RohoZ_EC_class::RohoZ_EC_Save_BList();
						wc_add_notice('<p>'.$RohoZ_EC_ErrorLoad.'</p>'.$RohoZ_EC_Reload , 'error' );
				}

			}
			function RohoZ_EC_cf7_verify( $result, $tag ) {
				if (get_option("RohoZ_EC_site_key") && get_option("RohoZ_EC_secret_key") && get_option("RohoZ_EC_Lang_key") && get_option("RohoZ_EC_Color_key") && !is_user_logged_in() && !RohoZ_EC_class::ip_in_whitelist() /*&& !function_exists("wpcf7_contact_form_shortcode")*/) {
$type = $tag['type'];
$name = $tag['name'];
    $tag = new WPCF7_Shortcode( $tag );
				if (/*isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) !== 'wp-login.php' &&*/ $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[get_option("RohoZ_EC_secret_key")])) {
					$RohoZ_EC_base_site_url=get_site_url();
					$RohoZ_EC_out_site_url=RohoZ_EC_class::RohoZ_EC_get_host($RohoZ_EC_base_site_url);
					$RohoZ_EC_site_key = filter_var(get_option("RohoZ_EC_site_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$RohoZ_EC_ecaptcha_response = filter_input(INPUT_POST, get_option("RohoZ_EC_secret_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$verifyResponse =wp_remote_fopen("https://rohoz.com/e-captcha/server1/ecaptcha.html?siteverify={$RohoZ_EC_site_key}&t={$RohoZ_EC_out_site_url}&d=i&l=en&ep={$RohoZ_EC_ecaptcha_response}");
					$response = json_decode($verifyResponse, true);
/*if( is_wp_error( $response ) ) {
	wp_die($response->get_error_message()) ;
}
*///wp_die($response['Out']);
$RohoZ_EC_Reload='';
if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
$RohoZ_EC_Reload='<script>location.reload();</script>';
}
					if ($response['Out']=='true') {

					} elseif (is_array($input)) { // Array = Comment else Object
						RohoZ_EC_class::RohoZ_EC_Save_BList();
        $tag->name = "rohozecaptcha";
$result->invalidate($tag, 'RohoZ Easy captcha verification failed.'.$RohoZ_EC_Reload);
					} else {
						RohoZ_EC_class::RohoZ_EC_Save_BList();
        $tag->name = "rohozecaptcha";
$result->invalidate($tag, 'RohoZ Easy captcha verification failed.'.$RohoZ_EC_Reload);
					}
				} else {
						RohoZ_EC_class::RohoZ_EC_Save_BList();
        $tag->name = "rohozecaptcha";
$result->invalidate($tag, 'RohoZ Easy captcha verification failed.'.$RohoZ_EC_Reload);
				}
				if (!empty($_POST['rohozecaptcha'])) {
						RohoZ_EC_class::RohoZ_EC_Save_BList();
        $tag->name = "rohozecaptcha";
$result->invalidate($tag, 'RohoZ Easy captcha verification failed.'.$RohoZ_EC_Reload);

				}
}

    return $result;
}
			function RohoZ_EC_verify1($input) {
				if ( isset($_POST['c'.get_option("RohoZ_EC_secret_key")])) {
					$RohoZ_EC_base_site_url=get_site_url();
					$RohoZ_EC_out_site_url=RohoZ_EC_class::RohoZ_EC_get_host($RohoZ_EC_base_site_url);
					$RohoZ_EC_site_key = filter_var(get_option("RohoZ_EC_site_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$RohoZ_EC_ecaptcha_response = filter_input(INPUT_POST, get_option("RohoZ_EC_secret_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$verifyResponse =wp_remote_fopen("https://rohoz.com/e-captcha/server1/ecaptcha.html?siteverify={$RohoZ_EC_site_key}&t={$RohoZ_EC_out_site_url}&d=i&l=en&ep={$RohoZ_EC_ecaptcha_response}");
					$response = json_decode($verifyResponse, true);
					$RohoZ_EC_ErrorLoad=get_option("RohoZ_EC_Error_Message");
					if ($response['Out']=='true') {
						return $input;
					} elseif (is_array($input)) { // Array = Comment else Object
						RohoZ_EC_class::RohoZ_EC_Save_BList();
						$RohoZ_EC_ffffff='javascript:history.back()';
						if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
						$RohoZ_EC_ffffff=$_SESSION['RohoZ_Lasturl'];
						}
						wp_die("<p>".$RohoZ_EC_ErrorLoad."<br><a href=\"".$RohoZ_EC_ffffff."\">Back</a></p>", "RohoZ Easy captcha", array("response" => 403, "back_link" => 0));
					} else {
						RohoZ_EC_class::RohoZ_EC_Save_BList();
						$RohoZ_EC_ffffff='javascript:history.back()';
						if (RohoZ_EC_class::ip_in_Blacklist() || isset($_SESSION['RohoZ_EC_Block'])) {
						$RohoZ_EC_ffffff=$_SESSION['RohoZ_Lasturl'];
						}
						wp_die("<p>".$RohoZ_EC_ErrorLoad."<br><a href=\"".$RohoZ_EC_ffffff."\">Back</a></p>", "RohoZ Easy captcha", array("response" => 403, "back_link" => 0));
					}
				}
			}
			function add_shortcode_RohoZ_EC() {
			if ( function_exists( 'wpcf7_add_form_tag' ) ) {
			    wpcf7_add_form_tag( 'rohozecaptcha', array('RohoZ_EC_class', "RohoZ_EC_display_cf7"), true );
			} elseif ( function_exists( 'wpcf7_add_shortcode' ) ) {
				wpcf7_add_shortcode( 'rohozecaptcha', array('RohoZ_EC_class', "RohoZ_EC_display_cf7"), true );
		  }
}
			function frontend_RohoZ_EC_script() {
				$RohoZ_EC_site_key = filter_var(get_option("RohoZ_EC_site_key"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				$RohoZ_EC_display_list=array();
				/*$RohoZ_EC_display_list = array("comment_form_after_fields", "register_form", "lost_password", "lostpassword_form", "retrieve_password", "resetpass_form", "woocommerce_register_form", "woocommerce_lostpassword_form", "woocommerce_after_order_notes", "bp_after_signup_profile_fields");*/

				if (get_option("RohoZ_EC_login_check_disable")) {
					array_push($RohoZ_EC_display_list, "login_form");
				}
				//register
				if (get_option("RohoZ_EC_register_check_disable")) {
					array_push($RohoZ_EC_display_list, "register_form");
				}
				//commend
				if (get_option("RohoZ_EC_comment_check_disable")) {
					array_push($RohoZ_EC_display_list, "comment_form_after_fields");
				}
				//lost password
				if (get_option("RohoZ_EC_lostpassword_check_disable")) {
					array_push($RohoZ_EC_display_list, "lost_password", "lostpassword_form", "retrieve_password", "resetpass_form");
				}
				//woocommerce
        		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					if (get_option("RohoZ_EC_woocommerce_check_disable")) {
						array_push($RohoZ_EC_display_list, "woocommerce_login_form", "woocommerce_lostpassword_form", "woocommerce_register_form");
						add_action("woocommerce_checkout_order_review", array('RohoZ_EC_class', "RohoZ_EC_display_Woo"));
					}
        		}
				// contact form 7

		//wpforo
			//array_push($RohoZ_EC_display_list, "wpforo_login_form", "wpforo_register_form", "wpforo_new_topic_form", "wpforo_reply_form");

				foreach($RohoZ_EC_display_list as $RohoZ_EC_display) {
					add_action($RohoZ_EC_display, array('RohoZ_EC_class', "RohoZ_EC_display"));
				}

	wp_register_script("RohoZ_EC_ecaptcha_main", plugin_dir_url( __FILE__ ) . 'js/rohoz_main.js');
	wp_enqueue_script("RohoZ_EC_ecaptcha_main");
	wp_register_style( 'custom_style', "https://rohoz.com/e-captcha/server1/easy-captcha.css?v=3.0" );
	wp_enqueue_style("custom_style" );
						wp_register_style( 'R_easy_captcha_style', plugin_dir_url( __FILE__ ) . "css/easy-captcha.css?v=3.0" );
						wp_enqueue_style("R_easy_captcha_style" );
			}
			function RohoZ_EC_check() {
				if (!get_option("RohoZ_EC_Error_Message")) {
				update_option("RohoZ_EC_Error_Message",'<strong>ERROR:</strong> RohoZ Easy captcha verification failed.');
				}
				if (get_option("RohoZ_EC_site_key") && get_option("RohoZ_EC_secret_key") && get_option("RohoZ_EC_Lang_key") && get_option("RohoZ_EC_Color_key") && !is_user_logged_in() && !RohoZ_EC_class::ip_in_whitelist() /*&& !function_exists("wpcf7_contact_form_shortcode")*/) {
					add_action("login_enqueue_scripts", array('RohoZ_EC_class', "frontend_RohoZ_EC_script"));
					add_action("wp_enqueue_scripts", array('RohoZ_EC_class', "frontend_RohoZ_EC_script"));
					$RohoZ_EC_verify_list=array();

		if (get_option("RohoZ_EC_login_check_disable")) {
			array_push($RohoZ_EC_verify_list, "wp_authenticate_user", "bp_signup_validate");
		}
		//register
		if (get_option("RohoZ_EC_register_check_disable")) {
		array_push($RohoZ_EC_verify_list, "register_post");
		}
		//commend
		if (get_option("RohoZ_EC_comment_check_disable")) {
		array_push($RohoZ_EC_verify_list, "preprocess_comment");
		}
		//lost password
		if (get_option("RohoZ_EC_lostpassword_check_disable")) {
		array_push($RohoZ_EC_verify_list, "lostpassword_post");
		}
		//woocommerce
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			if (get_option("RohoZ_EC_woocommerce_check_disable")) {
			array_push($RohoZ_EC_verify_list, "woocommerce_register_post");
			add_action("woocommerce_checkout_process",  array('RohoZ_EC_class', "RohoZ_EC_woo_verify"));
			}
		}
		// contact form 7
        /*if ( in_array( 'contact-form-7/contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		}*/
			if (get_option("RohoZ_EC_cf7_check_disable")) {
				add_filter('wpcf7_validate',array('RohoZ_EC_class', "RohoZ_EC_cf7_verify"), 10, 2);
			}
		//wpforo
		//array_push($RohoZ_EC_verify_list, "wpforo_login_form", "wpforo_register_form", "wpforo_new_topic_form", "wpforo_reply_form");

		foreach($RohoZ_EC_verify_list as $RohoZ_EC_verify) {
			add_action($RohoZ_EC_verify,  array('RohoZ_EC_class', "RohoZ_EC_verify"));
		}
	}
}
function add_shake_error_codes( $shake_error_codes ) {
        $shake_error_codes[] = 'no_captcha';
        $shake_error_codes[] = 'invalid_captcha';
        return $shake_error_codes;
    }
function RohoZ_EC_add_tag_generator() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'rohozecaptcha', 'RohoZ Easy captcha' ,
		array('RohoZ_EC_class', "RohoZ_EC_tag_generator"), array( 'nameless' => 1 ) );
}
function RohoZ_EC_Add_VerfCode() {
				$RohoZ_EC_Head_VerfCode = filter_var(get_option("RohoZ_EC_Head_VerfCode"), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
				?>
<meta name="rohoz-easy-captcha" content="RohoZ-<?php echo $RohoZ_EC_Head_VerfCode; ?>">
				<?php
}

function RohoZ_EC_tag_generator( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() ); ?>
	<div class="control-box">
    	<a href="https://rohoz.com" target="_blank"><img style="width: 100%;" src="<?php echo plugin_dir_url( __FILE__ ); ?>img/baner.png" alt="RohoZ Easy captcha"></a>
	</div>
	<div class="insert-box">
		<input type="text" name="rohozecaptcha" class="tag code" readonly="readonly" onfocus="this.select()" />
		<div class="submitbox">
		    <input type="button" class="button button-primary insert-tag" value="Insert Tag" />
		</div>
	</div>
<?php
}
function RohoZ_EC_admin_style(){
	wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'css/rohoz_admin.css' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}
		}
}

add_action('admin_enqueue_scripts', array('RohoZ_EC_class', "RohoZ_EC_admin_style"));
add_filter("plugin_action_links_".plugin_basename(__FILE__), array('RohoZ_EC_class', "RohoZ_EC_add_plugin_action_links"));
add_action("activated_plugin", array('RohoZ_EC_class', "RohoZ_EC_activation"));
add_action("admin_menu", array('RohoZ_EC_class', "RohoZ_EC_menu"));
add_action("admin_init", array('RohoZ_EC_class', "RohoZ_EC_display_options"));
add_action("init", array('RohoZ_EC_class', "RohoZ_EC_check"));
add_action("init", array('RohoZ_EC_class', "RohoZ_EC_verify1"));
// Add Contact Form Tag Generator Button
		// contact form 7
        /*if ( in_array( 'contact-form-7/contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		}*/
			if (get_option("RohoZ_EC_cf7_check_disable")) {
add_action( 'wpcf7_init', array('RohoZ_EC_class', "add_shortcode_RohoZ_EC") );
add_action( 'wpcf7_admin_init', array('RohoZ_EC_class', "RohoZ_EC_add_tag_generator"), 55 );
			}
			if (get_option("RohoZ_EC_Head_VerfCode")) {
add_action('wp_head', array('RohoZ_EC_class', "RohoZ_EC_Add_VerfCode"));
			}


//add_shortcode( 'rohozecaptcha2', array('RohoZ_EC_class', "RohoZ_EC_Shortcode"));
?>