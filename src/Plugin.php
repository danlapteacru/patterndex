<?php
/**
 * Plugin bootstrap.
 *
 * @package patterndex
 */

declare( strict_types=1 );

namespace Patterndex;

defined( 'ABSPATH' ) || exit;

/**
 * Wires up the plugin's features.
 */
final class Plugin {

	/**
	 * Register all hooks.
	 */
	public static function boot(): void {
		Capabilities::register();
		Assets::register();
		RegistryController::register();
	}
}
