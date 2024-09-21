<?php

namespace jmucak\wpHelpersPack\providers;

class ServiceProvider {
	public function register_post_types( array $post_types ): void {
		foreach ( $post_types as $post_type => $args ) {
			register_post_type( $post_type, $args );
		}
	}

	public function register_taxonomies( array $taxonomies ): void {
		foreach ( $taxonomies as $taxonomy => $args ) {
			register_taxonomy( $taxonomy, $args['post_types'], $args['args'] );
		}
	}

	// Register acf blocks
	public function register_blocks(array $blocks): void {
		foreach ( $blocks as $block ) {
			acf_register_block_type( $block );
		}
	}
}