<?php
namespace Pennline\Html\Helpers;

class NavItem {

	/**
	 * @var string
	 */
	public $href;

	/**
	 * @var string
	 */
	public $page;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @param array $item
	 */
	public function __construct( $item = array() ) {
		$this->init();
		$this->populate( $item );
	}

	protected function init() {
		$this->href = '';
		$this->page = '';
		$this->title = '';
	}

	/**
	 * @param array $item
	 */
	public function populate( $item = array() ) {
		if ( !is_array( $item ) ) {
			error_log( __METHOD__ . '() $item provided is not an array' );
			throw new Exception( 'parameter type error', 1 );
		}

		if ( isset( $item['href'] ) ) {
			$this->href = filter_var( $item['href'], FILTER_SANITIZE_STRING );
		}

		if ( isset( $item['page'] ) ) {
			$this->page = filter_var( $item['page'], FILTER_SANITIZE_STRING );
		}

		if ( isset ( $item['title'] ) ) {
			$this->title = filter_var( $item['title'], FILTER_SANITIZE_STRING );
		}
	}

}