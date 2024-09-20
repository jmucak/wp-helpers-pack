<?php

namespace jmucak\wpHelpersPack\interfaces;

interface AssetServiceInterface {
	public function get_base_url(): string;

	public function get_base_path(): string;

	public function get_js_settings(): array;

	public function get_css_settings(): array;
}