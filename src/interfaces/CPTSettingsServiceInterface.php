<?php

namespace jmucak\wpHelpersPack\interfaces;

interface CPTSettingsServiceInterface {
	public function get_post_types() : array;
	public function get_taxonomies() : array;
}