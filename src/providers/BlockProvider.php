<?php

namespace jmucak\wpHelpersPack\providers;

use jmucak\wpHelpersPack\interfaces\BlockProviderInterface;

class BlockProvider {
	private BlockProviderInterface $block_provider;

	public function register( BlockProviderInterface $block_provider ): void {
		$this->block_provider = $block_provider;

		if ( function_exists( 'acf_register_block_type' ) ) {
			add_action( 'acf/init', array( $this, 'register_blocks' ) );
		}

		add_filter( 'allowed_block_types_all', array( $this, 'filter_allowed_blocks' ) );
		add_filter( 'block_categories_all', array( $this, 'filter_block_categories' ) );
	}

	public function register_blocks(): void {
		foreach ( $this->block_provider->get_blocks() as $block ) {
			acf_register_block_type( $block );
		}
	}

	public function filter_allowed_blocks( bool|array $allowed_block_types ): array {
		$all_blocks = get_dynamic_block_names();

		$filtered_acf_arrays = array_filter( $all_blocks, fn( $block_name ) => str_contains( $block_name, 'acf' ) );

		$gutenberg_blocks = $this->block_provider->get_default_blocks();

		return array_merge( $filtered_acf_arrays, $gutenberg_blocks );
	}

	public function filter_block_categories( array $categories ): array {
		return array_merge( $categories, $this->block_provider->get_categories() );
	}
}