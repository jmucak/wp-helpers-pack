<?php

namespace jmucak\wpHelpersPack\helpers;

class TemplateLoaderHelper {
	private static ?TemplateLoaderHelper $instance = null;
	private string $template_path = '';

	private function __construct() {
	}

	public static function get_instance(): ?TemplateLoaderHelper {
		if ( null === self::$instance ) {
			self::$instance = new TemplateLoaderHelper();
		}

		return self::$instance;
	}

	// @codingStandardsIgnoreStart
	public function render( string $_view_file_, array $_data_ = array() ): void {
		// we use special variable names here to avoid conflict when extracting data
		if ( ! empty( $_data_ ) ) {
			extract( $_data_, EXTR_OVERWRITE );
		}

		require $_view_file_;
	}

	public function get_html( $_view_file_, array $_data_ = array() ): bool|string {
		// we use special variable names here to avoid conflict when extracting data
		if ( ! empty( $_data_ ) ) {
			extract( $_data_, EXTR_OVERWRITE );
		}

		ob_start();
		ob_implicit_flush( 0 );
		require $_view_file_;

		return ob_get_clean();
	}

	// @codingStandardsIgnoreEnd

	/**
	 *
	 * Get partial template
	 *
	 * @param string $path
	 * @param array $data
	 * @param bool $html
	 * @param string $folder
	 * @return bool|string|void
	 */
	public function get_partial( string $path, array $data = array(), bool $html = false, string $folder = 'partials/' ) {
		if ( ! file_exists( $path ) ) {
			return false;
		}

		if ( $html ) {
			return $this->get_html( $path, $data );
		}

		$this->render( $path, $data );
	}
}