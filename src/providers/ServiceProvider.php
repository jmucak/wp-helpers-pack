<?php

namespace jmucak\wpHelpersPack\providers;

use jmucak\wpHelpersPack\services\AssetService;

class ServiceProvider {
	private array $config = array();

	public function register_services( array $config ): void {
		$this->config = $config;
		if ( ! empty( $config['assets'] ) ) {
			$this->register_assets( $config['assets'] );
		}

		if ( ! empty( $config['post_types'] ) ) {
			$this->register_post_types( $config['post_types'] );
		}

		if ( ! empty( $config['taxonomies'] ) ) {
			$this->register_taxonomies( $config['taxonomies'] );
		}

		if ( ! empty( $config['blocks'] ) ) {
			add_action( 'acf/init', array( $this, 'register_blocks' ) );
		}

		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );

		if ( ! empty( $config['query_vars'] ) ) {
			add_filter( 'query_vars', array( $this, 'register_query_vars' ) );
		}
	}

	private function register_assets( array $config ): void {
		if ( ! empty( $config['assets'] ) ) {
			foreach ( $config['assets'] as $hook => $asset ) {
				if ( ! empty( $asset ) ) {
					add_action( $hook, array( new AssetService( $asset, $config ), 'register' ) );
				}
			}
		}
	}

	private function register_post_types( array $post_types ): void {
		foreach ( $post_types as $post_type => $args ) {
			register_post_type( $post_type, $args );
		}
	}

	private function register_taxonomies( array $taxonomies ): void {
		foreach ( $taxonomies as $taxonomy => $args ) {
			register_taxonomy( $taxonomy, $args['post_types'], $args['args'] );
		}
	}

	// Register ACF Gutenberg blocks
	public function register_blocks(): void {
		foreach ( $this->config['blocks']['blocks'] as $block ) {
			acf_register_block_type( $block );
		}

		new BlockSettingsProvider( $this->config['blocks'] );
	}

	public function register_rest_routes(): void {
		if ( ! empty( $this->config['register_cpt_filter'] ) && ! empty( $this->config['rest_route_namespace'] ) ) {
			$this->config['rest_routes'] = array_merge( array(
				array(
					'namespace' => $this->config['rest_route_namespace'],
					'route'     => CPTFilterProvider::ROUTE_CPT,
					'args'      => ( new CPTFilterProvider() )->get_route_args(),
				)
			), $this->config['rest_routes'] );
		}

		if ( ! empty( $this->config['rest_routes'] ) ) {
			foreach ( $this->config['rest_routes'] as $rest_config ) {
				register_rest_route( $rest_config['namespace'], $rest_config['route'], $rest_config['args'] );
			}
		}
	}

	public function register_query_vars( array $query_vars ): array {
		return array_merge( $query_vars, $this->config['query_vars'] );
	}
}