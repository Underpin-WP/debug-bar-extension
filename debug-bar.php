<?php

use Underpin\Abstracts\Underpin;
use Underpin_Logger\Abstracts\Event_Type;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add this loader.
add_action( 'underpin/before_setup', function ( $file, $class ) {
	add_action( 'plugins_loaded', function () use ( $file, $class ) {
		if ( ! defined( 'UNDERPIN_DEBUG_BAR_EXTENSION_ROOT_DIR' ) ) {
			define( 'UNDERPIN_DEBUG_BAR_EXTENSION_ROOT_DIR', plugin_dir_path( __FILE__ ) );
		}
		if ( ! class_exists( 'Debug_Bar_Panel' ) ) {
			return;
		}
		require_once( UNDERPIN_DEBUG_BAR_EXTENSION_ROOT_DIR . 'lib/factories/Debug_Bar_Panel_Instance.php' );
		require_once( UNDERPIN_DEBUG_BAR_EXTENSION_ROOT_DIR . 'lib/factories/Debug_Bar_Panel_Logger_Instance.php' );
		require_once( UNDERPIN_DEBUG_BAR_EXTENSION_ROOT_DIR . 'lib/loaders/Debug_Bars.php' );
		\Underpin\underpin()->get( $file, $class )->loaders()->add( 'debug_bars', [
			'registry' => '\Underpin_Debug_Bar_Extension\Loaders\Debug_Bars',
		] );
	} );
}, 3, 2 );

// When a logger instance is added, also add a debug bar instance.
add_action( 'underpin/loader_registered', function ( $key, $value, $loader, $parent_id ) {
	add_action( 'plugins_loaded', function () use ( $parent_id, $loader, $key ) {

		if ( ! class_exists( 'Debug_Bar_Panel' ) ) {
			return;
		}

		if ( $loader === 'Underpin_Logger\Loaders\Logger' ) {
			$name = Underpin::get_by_id( $parent_id )->name;

			// Due to an irritating limitation in the debug bar plugin, all class names must be unique, and free of invalid
			//characters, including a / character.
			// This frustration forces us to use eval, as there is no other way to create a unique class name, without slashes
			// Without manually creating new classes every time.
			// IF you are reading this, and have an idea on how this can be done without eval, we'd love to hear it.

			// Malform the class into an MD5. This keeps anyone from running anything cute.
			$class = 'Underpin_Debug_Panel_Instance_' . md5( $key . '_' . $parent_id );
			eval( 'class ' . $class . ' extends Underpin_Debug_Bar_Panel_Logger_Instance{}' );

			Underpin::get_by_id( $parent_id )->debug_bars()->add( $key, [
				'class' => $class,
				'args'  => [
					'title'      => "$name ${key}s",
					'parent_id'  => $parent_id,
					'logger_key' => $key,
				],
			] );

		}
	} );
}, 10, 4 );

add_action( 'underpin/logger/after_logged_item', function ( \Underpin_Logger\Factories\Log_Item $logged_item, Event_Type $logger ) {
	$data = array_merge( [
		'volume'    => $logger->volume,
		'group'     => $logger->group,
		'type'      => $logger->type,
	], $logged_item->data );

	do_action( 'qm/' . $logger->psr_level, $logged_item->code . ':' . $logged_item->message . "\n" . json_encode( $data, JSON_PRETTY_PRINT ) );
}, 10, 2 );