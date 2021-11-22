<?php

use Underpin\Abstracts\Underpin;
use Underpin_Logger\Abstracts\Event_Type;
use Underpin_Logger\Loaders\Logger;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Add this loader.
Underpin::attach( 'setup', new \Underpin\Factories\Observer( 'query_monitor_extension', [
	'deps'   => [ 'logger' ],
	'update' => function ( Underpin $plugin ) {
		$plugin->logger()->attach( 'event:logged', new \Underpin\Factories\Observer( 'query_monitor', [
			'update' => function ( Logger $logger, \Underpin\Factories\Simple_Storage $storage ) {
				/* @var \Underpin_Logger\Factories\Log_Item $event */
				$event = $storage->event;
				/* @var Event_Type $event_type */
				$event_type = $storage->event_type;

				$data = array_merge( [
					'volume' => $event_type->volume,
					'group'  => $event_type->group,
					'type'   => $event_type->type,
				], $event->data );

				do_action( 'qm/' . $event_type->psr_level, $event->code . ':' . $event->message . "\n" . json_encode( $data, JSON_PRETTY_PRINT ) );
			},
		] ) );
	},
] ) );