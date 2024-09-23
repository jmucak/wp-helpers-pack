<?php

namespace jmucak\wpHelpersPack\interfaces;

interface BlockCallbackInterface {
	public function get_view( array $block, string $content, bool $is_preview = false, int $post_id = 0 ): void;
}