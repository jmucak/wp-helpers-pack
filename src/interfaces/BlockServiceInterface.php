<?php

namespace jmucak\wpHelpersPack\interfaces;

interface BlockServiceInterface {
	public function get_blocks() : array;
	public function get_default_blocks() : array;
	public function get_categories() : array;
}