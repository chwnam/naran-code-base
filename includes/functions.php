<?php
/**
 * Naran code base: functions.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ncb_pool(): NCB_Pool {
	return NCB_Pool::get_instance();
}
