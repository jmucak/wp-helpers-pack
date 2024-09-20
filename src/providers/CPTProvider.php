<?php

namespace jmucak\wpHelpersPack\providers;

use jmucak\wpHelpersPack\services\AbstractCPTSettingsService;

class CPTProvider {
	private AbstractCPTSettingsService $cpt_settings_service;

	public function register( AbstractCPTSettingsService $cpt_settings_service ): void {
		$this->cpt_settings_service = $cpt_settings_service;

		$this->register_post_types();
		$this->register_taxonomies();
	}

	public function register_post_types(): void {
		$post_types = $this->cpt_settings_service->get_post_types();
		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type => $args ) {
				register_post_type( $post_type, $args );
			}
		}
	}

	public function register_taxonomies(): void {
		$taxonomies = $this->cpt_settings_service->get_taxonomies();
		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $taxonomy => $args ) {
				register_taxonomy( $taxonomy, $args['post_types'], $args['args'] );
			}
		}
	}
}