<?php

use Underpin\Traits\Instance_Setter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Underpin_Debug_Bar_Panel_Instance extends Debug_Bar_Panel {

	use Instance_Setter;

	protected $init_callback;


	public function __construct( $args ) {
		parent::__construct( $args['title'] );
		unset($args['title']);
		$this->set_values( $args );
	}

	public function init() {
		return $this->set_callable( 'init_callback' );
	}

}