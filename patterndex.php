<?php
/**
 * Plugin Name: Patterndex – Pattern & Block Debugger
 * Plugin URI: https://github.com/danlapteacru/patterndex
 * Description: Adds a pattern registry browser and a block/pattern debug panel to the block editor.
 * Version: 0.1.2
 * Requires at least: 6.6
 * Requires PHP: 8.1
 * Author: Dan Lapteacru
 * Author URI: https://github.com/danlapteacru
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: patterndex
 *
 * @package patterndex
 */

declare( strict_types=1 );

namespace Patterndex;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PATTERNDEX_DIR', __DIR__ );
define( 'PATTERNDEX_FILE', __FILE__ );

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} else {
	// Minimal PSR-4 autoloader so the plugin works without a Composer install.
	spl_autoload_register(
		static function ( string $class_name ): void {
			$prefix = __NAMESPACE__ . '\\';

			if ( ! str_starts_with( $class_name, $prefix ) ) {
				return;
			}

			$path = __DIR__ . '/src/' . str_replace( '\\', '/', substr( $class_name, strlen( $prefix ) ) ) . '.php';

			if ( file_exists( $path ) ) {
				require $path;
			}
		}
	);
}

Plugin::boot();
