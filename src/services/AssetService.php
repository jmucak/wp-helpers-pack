<?php

namespace jmucak\wpHelpersPack\services;

class AssetService {
	private string $base_path;
	private string $base_url;
	private array $assets;

	public function __construct( array $assets, array $config = array() ) {
		$this->base_url  = ! empty( $config['base_url'] ) ? $config['base_url'] : get_template_directory_uri() . '/static/';
		$this->base_path = ! empty( $config['base_path'] ) ? $config['base_path'] : get_theme_file_path( '/static/' );
		$this->assets    = $assets;
	}

	public function register(): void {
		if ( empty( $this->base_path ) || empty( $this->base_url ) ) {
			return;
		}

		$this->enqueue_scripts( $this->assets['js'] );
		$this->enqueue_styles( $this->assets['css'] );
	}

	private function get_base_path( string $path ): string {
		return $this->base_path . $path;
	}

	private function get_base_url( string $path ): string {
		return $this->base_url . $path;
	}

	private function enqueue_scripts( array $assets ): void {
		foreach ( $assets as $handle => $data ) {
			if ( empty( $data['path'] ) ) {
				continue;
			}
			if ( ! file_exists( $this->get_base_path( $data['path'] ) ) ) {
				continue;
			}

			$version        = $data['version'] ?? 1.0;
			$timestamp_bust = ! empty( $data['timestamp_bust'] );
			$in_footer      = $data['in_footer'] ?? true;

			if ( $timestamp_bust ) {
				$version .= sprintf( '.%d', filemtime( $this->get_base_path( $data['path'] ) ) );
			}

			wp_enqueue_script( $handle, $this->get_base_url( $data['path'] ), [], $version, $in_footer );

			if ( ! empty( $data['localize'] ) && ! empty( $data['localize']['data'] ) ) {
				wp_localize_script( $handle, $data['localize']['object'], $data['localize']['data'] );
			}
		}
	}

	private function enqueue_styles( array $assets ): void {
		foreach ( $assets as $handle => $data ) {
			if ( empty( $data['path'] ) ) {
				continue;
			}

			wp_enqueue_style( $handle, $this->get_base_url( $data['path'] ), [], $data['version'] ?? 1.0, $data['in_footer'] ?? true );
		}
	}
}