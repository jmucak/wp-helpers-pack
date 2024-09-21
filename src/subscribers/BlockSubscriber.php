<?php

namespace jmucak\wpHelpersPack\subscribers;

class BlockSubscriber {
	private array $config;
	public function __construct(array $config) {
		$this->config = $config;

		add_filter( 'allowed_block_types_all', array( $this, 'filter_allowed_blocks' ) );

		if ( ! empty( $this->config['categories'] ) ) {
			add_filter( 'block_categories_all', array( $this, 'filter_block_categories' ) );
		}
	}

	// Filter default blocks
	public function filter_allowed_blocks( bool|array $allowed_block_types ): array {
		$filtered_acf_arrays = array_filter( get_dynamic_block_names(), fn( $block_name ) => str_contains( $block_name, 'acf' ) );

		return array_merge( $filtered_acf_arrays, $this->config['default_blocks'] ?? array() );
	}

	// add custom block categories
	public function filter_block_categories( array $categories ): array {
		return array_merge( $categories, $this->config['categories'] );
	}
}