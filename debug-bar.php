<?php

use Underpin\Abstracts\Event_Type;
use Underpin\Loaders\Logger;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Attach query monitor to logged events.
Logger::instance()->attach( 'event:logged', new \Underpin\Factories\Observer( 'query_monitor', [
	'update' => function ( Logger $logger, \Underpin\Factories\Simple_Storage $storage ) {
		/* @var \Underpin\Factories\Log_Item $event */
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