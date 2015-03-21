<?php
namespace Pennline\Html\Helpers;

use Pennline\Php\Exception;

class Nav {

	/**
	 * @var array
	 */
	public $items;

	/**
	 * @param array $items
	 */
	public function __construct( $items = array() ) {
		$this->init();
		$this->populate( $items );
	}

	/**
	 * @param string $class
	 * @param string $page
	 * @return string
	 */
	public function getNavAsUl( $class = '', $page = '' ) {
		$result = '';

		if ( empty( $this->items ) ) {
			return $result;
		}

		$result = sprintf(
			'<ul class="%s">',
			filter_var( $class, FILTER_SANITIZE_STRING )
		);

		foreach ( $this->items as $item ) {
			$class = '';

			if ( $item->page === $page ) {
				$class = ' class="active"';
			}

			$result .= '<li>';

			$result .= sprintf(
				'<a href="%s" title="%s"%s>%s</a>',
				$item->href,
				$item->title,
				$class,
				$item->title
			);

			$result .= '</li>';
		}

		$result .= '</ul>';

		return $result;
	}

	protected function init() {
		$this->items = array();
	}

	/**
	 * @param array $items
	 * @throws Exception
	 */
	public function populate( $items = array() ) {
		if ( !is_array( $items ) ) {
			error_log( __METHOD__ . '() $items provided is not an array' );
			throw new Exception( 'parameter type error', 1 );
		}

		foreach ( $items as $item ) {
			$this->items[] = new NavItem( $item );
		}
	}

}