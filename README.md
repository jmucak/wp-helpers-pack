# wp-helpers-pack

## Table of contents

1. [Project info](#project-info)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [Features](#features)
5. [Usage](#usage)

### Project info

WordPress helper pack for custom theme and plugins development

- repository: `https://github.com/jmucak/wp-helpers-pack`

### Requirements

- PHP > 8.1
- composer v2

### Installation

- Run `composer require jmucak/wp-helpers-pack` inside your custom theme or plugin folder

### Features

- template loader helper
- asset provider => registering css and js
- block provider => registering custom acf gutenberg blocks
- cpt provider => registering custom post types and taxonomies
- file helper

### Usage

#### Template Loader Helper

- Used to get or load a file withing theme or a plugin
- It's similar to WordPress _load_template()_ function

```
function get_partial( string $path, array $data = array(), bool $html = false ): bool|string|null {
	$file_path = TEMPLATE_PATH . 'partials/' . $path . '.php';

	return TemplateLoaderHelper::get_instance()->get_partial( $file_path, $data, $html );
}
```

#### Asset Provider

```
$config = array(
    'assets' => array(
        'wp_enqueue_scripts' => array(
            'js'        => array(
                'jsHandle' => array(
                    'path'           => '{PATH_TO_BUNDLE_JS}',
                    'version'        => '1.0.0',
                    'localize'       => array(
                        'object' => '{OBJECT_NAME}',
                        'data'   => array(),
                    ),
                    'timestamp_bust' => true, // dynamic version change
                )
            ),
            'css'       => array(
                'cssHandle' => array(
                    'path'           => '{PATH_TO_BUNDLE_CSS}',
                    'in_footer'      => false,
                    'version'        => '1.0.0',
                    'timestamp_bust' => true, // dynamic version change
                ),
            ),
            'admin_enqueue_scripts' => array(
                'js'        => array(
                    'jsHandle' => array(
                        'path'           => '{PATH_TO_BUNDLE_JS}',
                        'version'        => '1.0.0',
                        'localize'       => array(
                            'object' => '{OBJECT_NAME}',
                            'data'   => array(),
                        ),
                        'timestamp_bust' => true, // dynamic version change
                    )
                ),
                'css'       => array(
                    'cssHandle' => array(
                        'path'           => '{PATH_TO_BUNDLE_CSS}',
                        'in_footer'      => false,
                        'version'        => '1.0.0',
                        'timestamp_bust' => true, // dynamic version change
                    ),
                ),
            'enqueue_block_editor_assets' => array(
                'js'        => array(
                    'jsHandle' => array(
                        'path'           => '{PATH_TO_BUNDLE_JS}',
                        'version'        => '1.0.0',
                        'localize'       => array(
                            'object' => '{OBJECT_NAME}',
                            'data'   => array(),
                        ),
                        'timestamp_bust' => true, // dynamic version change
                    )
                ),
                'css'       => array(
                    'cssHandle' => array(
                        'path'           => '{PATH_TO_BUNDLE_CSS}',
                        'in_footer'      => false,
                        'version'        => '1.0.0',
                        'timestamp_bust' => true, // dynamic version change
                    ),
                ),
        )
    ),
    'base_url'  => get_template_directory_uri() . '/{ASSETS_FOLDER}/',
    'base_path' => get_theme_file_path( '/{ASSETS_FOLDER}/' ),
);
		
add_action( 'wp_enqueue_scripts', array( new AssetProvider( $config ), 'register' ) );
```

#### Registering blocks

```
$config = array(
    'blocks' => array(
		array(), // Block settings
    )
    'default_blocks' => array(
        'core/paragraph',
        'core/heading',
        'core/image',
        ...
    ),
    'categories'     => array(
        array(
            'slug'  => 'category-slug',
            'title' => 'Category name'
        )
    ),	
);

ServiceProvider::register_blocks( $config );
```

#### Registering post types and taxonomies

```
$service_provider = new ServiceProvider();
$service_provider->register_post_types( array(
        'movie' => array() //CPT settings
    ) );
$service_provider->register_taxonomies( array(
        'genre' => array() // Taxonomies settings
    ) );
```

#### Registering rest routes
```
add_action( 'rest_api_init', array( $this, 'register_rest_route' ) );

public function register_rest_route(): void {

    $config_data = array(
        array(
            'namespace' => {NAMESPACE},
            'route' => {ROUTE},
            'args' => array()
        ),
    );
    
    ServiceProvider::register_rest_routes( $config_data );
}
```