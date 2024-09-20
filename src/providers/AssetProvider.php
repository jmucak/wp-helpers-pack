<?php

namespace jmucak\wpHelpersPack\providers;

use jmucak\wpHelpersPack\interfaces\AssetServiceInterface;

class AssetProvider {
	private AssetServiceInterface $asset_service;

	public function __construct(AssetServiceInterface $asset_service) {
		$this->asset_service = $asset_service;
	}

	public function register(  ): void {
		$this->enqueue_scripts();
		$this->enqueue_styles();
	}

	private function enqueue_scripts(): void {
		foreach ( $this->asset_service->get_js_settings() as $handle => $data ) {
			if ( empty( $data['path'] ) ) {
				continue;
			}
			$path = $data['path'];
			if ( ! file_exists( $this->asset_service->get_base_path() . $path ) ) {
				continue;
			}

			$version        = $data['version'] ?? 1.0;
			$timestamp_bust = ! empty( $data['timestamp_bust'] );
			$in_footer      = $data['in_footer'] ?? true;

			if ( $timestamp_bust ) {
				$version .= sprintf( '.%d', filemtime( $this->asset_service->get_base_path() . $path ) );
			}

			wp_enqueue_script( $handle, $this->asset_service->get_base_url() . $path, [], $version, $in_footer );

			if ( ! empty( $data['localize'] ) && ! empty( $data['localize']['data'] ) ) {
				wp_localize_script( $handle, $data['localize']['object'], $data['localize']['data'] );
			}
		}
	}

	private function enqueue_styles(): void {
		foreach ( $this->asset_service->get_css_settings() as $handle => $data ) {
			if ( empty( $data['path'] ) ) {
				continue;
			}

			$path      = $data['path'];
			$version   = $data['version'] ?? 1.0;
			$in_footer = $data['in_footer'] ?? true;

			wp_enqueue_style( $handle, $this->asset_service->get_base_url() . $path, [], $version, $in_footer );
		}
	}
}