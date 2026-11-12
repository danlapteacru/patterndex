<?php
/**
 * Editor asset loading.
 *
 * @package patterndex
 */

declare( strict_types=1 );

namespace Patterndex;

defined( 'ABSPATH' ) || exit;

/**
 * Loads the built editor script and style, gated by capability.
 */
final class Assets {

	/**
	 * Handle shared by the script and style.
	 */
	private const HANDLE = 'patterndex';

	/**
	 * Register hooks.
	 */
	public static function register(): void {
		add_action( 'enqueue_block_editor_assets', [ self::class, 'enqueue_assets' ] );
	}

	/**
	 * Enqueue the built editor assets for authorized users.
	 */
	public static function enqueue_assets(): void {
		if ( ! current_user_can( Capabilities::VIEW ) ) {
			return;
		}

		$asset_path = PATTERNDEX_DIR . '/build/index.asset.php';
		$asset      = file_exists( $asset_path ) ? require $asset_path : null;

		if ( ! is_array( $asset ) || ! is_array( $asset['dependencies'] ?? null ) || ! is_string( $asset['version'] ?? null ) ) {
			_doing_it_wrong(
				__METHOD__,
				'The built assets are missing or malformed. Run `npm install && npm run build` in the patterndex plugin directory.',
				'0.1.0'
			);

			return;
		}

		wp_enqueue_script(
			self::HANDLE,
			plugins_url( 'build/index.js', PATTERNDEX_FILE ),
			$asset['dependencies'],
			$asset['version'],
			true
		);
		wp_set_script_translations( self::HANDLE, 'patterndex', PATTERNDEX_DIR . '/languages' );

		wp_enqueue_style(
			self::HANDLE,
			plugins_url( 'build/index.css', PATTERNDEX_FILE ),
			[ 'wp-components' ],
			$asset['version']
		);
	}
}
