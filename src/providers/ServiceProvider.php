<?php

namespace jmucak\wpHelpersPack\providers;

class ServiceProvider {
	public static function register_post_types( array $post_types ): void {
		foreach ( $post_types as $post_type => $args ) {
			register_post_type( $post_type, $args );
		}
	}

	public static function register_taxonomies( array $taxonomies ): void {
		foreach ( $taxonomies as $taxonomy => $args ) {
			register_taxonomy( $taxonomy, $args['post_types'], $args['args'] );
		}
	}

	// Register ACF Gutenberg blocks
	public static function register_blocks( array $config = array() ): void {
		if ( ! empty( $config['blocks'] ) ) {
			foreach ( $config['blocks'] as $block ) {
				acf_register_block_type( $block );
			}

			new BlockSettingsProvider( $config );
		}
	}

	public static function register_assets( array $config ): void {
		if ( ! empty( $config['assets'] ) ) {
			foreach ( $config['assets'] as $hook => $asset ) {
				if ( ! empty( $asset ) ) {
					add_action( $hook, array( new AssetProvider( $asset, $config ), 'register' ) );
				}
			}
		}
	}
}