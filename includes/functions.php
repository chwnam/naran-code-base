<?php
/**
 * Naran code base: functions.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'ncb_pool' ) ) {
	function ncb_pool(): NCB_Pool {
		return NCB_Pool::get_instance();
	}
}


if ( ! function_exists( 'ncb_src_helper' ) ) {
	/**
	 * script load helper.
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	function ncb_src_helper( string $path ): string {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			if ( substr( $path, - 8 ) === '.min.css' ) {
				$path = substr( $path, 0, strlen( $path ) - 8 ) . '.css';
			} elseif ( substr( $path, - 7 ) === '.min.js' ) {
				$path = substr( $path, 0, strlen( $path ) - 7 ) . '.js';
			}
		}

		return $path;
	}
}


if ( ! function_exists( 'ncb_include_file_array') ) {
	function ncb_include_file_array( string $path ): array {
		$items = [];

		if ( file_exists( $path ) && is_readable( $path ) ) {
			$items = include $path;

			if ( ! is_array( $items ) ) {
				$items = [];
			}
		}

		return $items;
	}
}
