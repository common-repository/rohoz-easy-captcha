<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die( 'Direct access not allowed!' );
}

function RohoZ_EC_delete($array) {
	foreach ($array as $one) {
		delete_option("RohoZ_EC_{$one}");
	}	
}

RohoZ_EC_delete(array("site_key", "secret_key", "login_check_disable", "Lang_key", "Color_key", "whitelist", "Blacklist", "login_check_disable", "register_check_disable", "comment_check_disable", "lostpassword_check_disable", "woocommerce_check_disable", "cf7_check_disable", "Error_Message", "Head_VerfCode", "limitation_enable", "ipblock_enable"));
