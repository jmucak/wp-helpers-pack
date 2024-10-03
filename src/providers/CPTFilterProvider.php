<?php

namespace jmucak\wpHelpersPack\providers;

use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

class CPTFilterProvider {
	public const ROUTE_CPT = 'cpt';
	public string $namespace = '';

	public function register(string $namespace): void {
		$this->namespace = $namespace;
		add_action( 'rest_api_init', array( $this, 'register_rest_route' ) );
	}

	public function register_rest_route(): void {
		register_rest_route( $this->namespace, self::ROUTE_CPT, $this->get_route_args() );
	}

	public function get_route_args(): array {
		return array(
			array(
				'methods'             => WP_REST_Server::READABLE,
				'permission_callback' => '__return_true',
				'callback'            => array( $this, 'get_items' ),
			),
		);
	}

	/**
	 *
	 * GET
	 * @url wp-json/wsytes/v1/cpt
	 *
	 * @param WP_REST_Request $request
	 * @return WP_REST_Response
	 * @example ?post_type=article&view=html&article_cat=blog,news&paged=1&posts_per_page=2
	 *
	 */
	public function get_items( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_query_params();

		if ( empty( $params['post_type'] ) ) {
			return rest_ensure_response( array() );
		}

		$args   = apply_filters( 'wsytes_cpt_controller_args', $params );
		$output = apply_filters( 'wsytes_cpt_controller_output', $args );

		return rest_ensure_response( $output );
	}
}