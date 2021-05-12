<?php

use Underpin\Traits\Instance_Setter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Underpin_Debug_Bar_Panel_Logger_Instance extends Underpin_Debug_Bar_Panel_Instance {

	use \Underpin\Traits\With_Parent;
	use \Underpin\Traits\Templates;

	protected $logger_key;

	public function __construct( $args ) {
		parent::__construct( $args );
	}

	public function prerender() {
		$this->set_visible( count( $this->get_logger() ) > 0 );
	}

	public function get_logger() {
		return $this->parent()->logger()->get( $this->logger_key );
	}

	public function render() {
		echo $this->get_template( 'wrapper' );
	}

	function debug_bar_classes( $classes ) {
		if ( true === $this->get_logger()->write_to_log && count( $this->get_logger() ) > 0 ) {
			$classes[] = 'debug-bar-php-warning-summary';
		}
		return $classes;
	}

	public function get_templates() {
		return [
			'wrapper' => [],
		];
	}

	protected function get_template_group() {
		return 'events';
	}

	protected function get_template_root_path() {
		return UNDERPIN_DEBUG_BAR_EXTENSION_ROOT_DIR . 'templates';
	}

}