<?php

namespace jmucak\wpHelpersPack\interfaces;

interface BlockProviderInterface {
	public function get_blocks() : array;
	public function get_default_blocks() : array;
	public function get_categories() : array;
}