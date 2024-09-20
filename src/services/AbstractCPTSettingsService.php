<?php

namespace jmucak\wpHelpersPack\services;

abstract class AbstractCPTSettingsService {
	public abstract function get_post_types() : array;
	public abstract function get_taxonomies() : array;

	/**
	 * Default labels for CPT
	 *
	 * @param string $label
	 * @param string $label_plural
	 * @param string $domain
	 * @return array
	 */
	protected function get_default_post_types_labels( string $label, string $label_plural, string $domain = '' ): array {
		return array(
			'name'                  => sprintf( __( '%s', $domain ), $label_plural ),
			'singular_name'         => sprintf( __( '%s', $domain ), $label ),
			'all_items'             => sprintf( __( 'All %s', $domain ), $label_plural ),
			'menu_name'             => sprintf( __( '%s', 'Admin menu name', $domain ), $label_plural ),
			'add_new'               => __( 'Add New', $domain ),
			'add_new_item'          => sprintf( __( 'Add new %s', $domain ), $label ),
			'edit'                  => __( 'Edit', $domain ),
			'edit_item'             => sprintf( __( 'Edit %s', $domain ), $label ),
			'new_item'              => sprintf( __( 'New %s', $domain ), $label ),
			'view_item'             => sprintf( __( 'View %s', $domain ), $label ),
			'view_items'            => sprintf( __( 'View %s', $domain ), $label_plural ),
			'search_items'          => sprintf( __( 'Search %s', $domain ), $label_plural ),
			'not_found'             => sprintf( __( 'No %s found', $domain ), $label_plural ),
			'not_found_in_trash'    => sprintf( __( 'No %s found in trash', $domain ), $label_plural ),
			'parent'                => sprintf( __( 'Parent %s', $domain ), $label ),
			'featured_image'        => sprintf( __( '%s image', $domain ), $label ),
			'set_featured_image'    => sprintf( __( 'Set %s image', $domain ), $label ),
			'remove_featured_image' => sprintf( __( 'Remove %s image', $domain ), $label ),
			'use_featured_image'    => sprintf( __( 'Use as %s image', $domain ), $label ),
			'insert_into_item'      => sprintf( __( 'Insert into %s', $domain ), $label ),
			'uploaded_to_this_item' => sprintf( __( 'Uploaded to this %s', $domain ), $label ),
			'filter_items_list'     => sprintf( __( 'Filter %s', $domain ), $label_plural ),
			'items_list_navigation' => sprintf( __( '%s navigation', $domain ), $label_plural ),
			'items_list'            => sprintf( __( '%s list', $domain ), $label_plural ),
		);
	}


	/**
	 * Default labels for taxonomies
	 *
	 * @param string $label
	 * @param string $domain
	 * @return array
	 */
	protected function get_default_taxonomies_labels( string $label, string $domain = '' ): array {
		return array(
			'name'              => sprintf( __( '%s', $domain ), $label ),
			'singular_name'     => sprintf( __( '%s', $domain ), $label ),
			'search_items'      => sprintf( __( 'Search %s', $domain ), $label ),
			'all_items'         => sprintf( __( 'All %s', $domain ), $label ),
			'parent_item'       => sprintf( __( 'Parent %s', $domain ), $label ),
			'parent_item_colon' => sprintf( __( 'Parent %s:', $domain ), $label ),
			'edit_item'         => sprintf( __( 'Edit %s', $domain ), $label ),
			'update_item'       => sprintf( __( 'Update %s', $domain ), $label ),
			'add_new_item'      => sprintf( __( 'Add new %s', $domain ), $label ),
			'new_item_name'     => sprintf( __( 'New %s', $domain ), $label ),
			'not_found'         => sprintf( __( 'No &quot;%s&quot; found', $domain ), $label ),
		);
	}
}