<?php

/**
 * The plugin bootstrap file
 *
 * @category   Wordpress
 * @package    Page Builder Hub
 * @author     SolidBunch
 * @link       https://solidbunch.com
 * @version    Release: 1.0.0
 * @since      1.0.0
 *
 * @starter-kit-plugin
 * Plugin Name: Page Builder Hub
 * Plugin URI: https://github.com/SolidBunch/Page-Builder-Hub
 * Description: Wordpress plugin, a library of premium quality content elements for different page builders.
 * Version: 1.0.0
 * Author: SolidBunch
 * Author URI: https://solidbunch.com
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: page-builder-hub
 * Domain Path: /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

// helper functions for developers
require_once __DIR__ . '/app/dev.php';

if(class_exists('WP_CLI')) {
	//define theme root directory for future commands
	define('THEME_ROOT_DIRECTORY' , __DIR__);
	//load commands for dir
	foreach (glob(__DIR__ . '/dev/cli/*.php') as $file) {
		require $file;
	}
}


/**
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Foo\Bar\Baz\Qux;
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 */
spl_autoload_register( function ( $class ) {
	
	// project-specific namespace prefix
	$prefix = 'StarterKit\\';
	
	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/app/';
	
	// does the class use the namespace prefix?
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		// no, move to the next registered autoloader
		return;
	}
	
	// get the relative class name
	$relative_class = substr( $class, $len );
	
	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
	
	// if the file exists, require it
	if ( file_exists( $file ) ) {
		require $file;
	}
} );

// Global point of enter
if ( ! function_exists( 'Starter_Kit' ) ) {
	
	function Starter_Kit() {
		return \StarterKit\App::getInstance();
	}
	
}

// Run the theme
Starter_Kit()->run();