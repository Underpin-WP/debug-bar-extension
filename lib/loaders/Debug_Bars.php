<?php

namespace Underpin_Debug_Bar_Extension\Loaders;

use Underpin\Abstracts\Registries\Object_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Debug_Bars extends Object_Registry {

	protected $default_factory   = 'Underpin_Debug_Bar_Panel_Instance';
	protected $abstraction_class = '\Debug_Bar_Panel';

	public function __construct() {
		parent::__construct();
		$this->do_actions();
	}

	/**
	 * Fetches a debug bar panel
	 *
	 * @param string $key The instance key.
	 *
	 * @return \Debug_Bar_Panel|\WP_Error The panel if it exists, or WP_Error if not.
	 */
	public function get( $key ) {
		return parent::get( $key );
	}

	/**
	 * Do actions to set up panels.
	 */
	public function do_actions() {
		add_filter( 'debug_bar_panels', [ $this, 'add_panels' ] );
	}

	/**
	 * Registers panels.
	 *
	 * @param $panels
	 *
	 * @return mixed
	 */
	public function add_panels( $panels ) {
		foreach ( (array) $this as $key => $panel ) {
			$panel = $this->get( $key );
			if ( ! is_wp_error( $panel ) ) {
				$panels[] = $panel;
			}
		}

		return $panels;
	}

	protected function set_default_items() {}

}