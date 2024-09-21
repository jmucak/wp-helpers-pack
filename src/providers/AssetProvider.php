<?php

namespace jmucak\wpHelpersPack\providers;

class AssetProvider {
	private array $config;

	public function __construct( array $config ) {
		$this->config = $config;
	}

	public function register(): void {
		if ( empty( $this->config['base_path'] ) || empty( $this->config['base_url'] ) ) {
			return;
		}

		$this->enqueue_scripts();
		$this->enqueue_styles();
	}

	private function get_base_path( string $path ): string {
		return $this->config['base_path'] . $path;
	}

	private function get_base_url( string $path ): string {
		return $this->config['base_url'] . $path;
	}

	private function enqueue_scripts(): void {
		if ( ! empty( $this->config['js'] ) ) {
			foreach ( $this->config['js'] as $handle => $data ) {
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
	}

	private function enqueue_styles(): void {
		if ( ! empty( $this->config['css'] ) ) {
			foreach ( $this->config['css'] as $handle => $data ) {
				if ( empty( $data['path'] ) ) {
					continue;
				}

				wp_enqueue_style( $handle, $this->get_base_url( $data['path'] ), [], $data['version'] ?? 1.0, $data['in_footer'] ?? true );
			}
		}
	}
}