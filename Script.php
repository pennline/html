<?php
namespace Pennline\Html;

class Script {

	/**
	 * @var string
	 */
	protected $content;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $src;

	/**
	 * @param array $options
	 */
	public function __construct( array $options = array() ) {
		$this->init();
		$this->populate( $options );
	}

	/**
	 * @return string
	 */
	public function __toString() {
		$result = '<script';

		if ( !empty( $this->src ) ) {
			$result .= ' src="' . $this->src . '"';
		}

		if ( !empty( $this->id ) ) {
			$result .= ' id="' . $this->id . '"';
		}

		$result .= '>';

		if ( !empty( $this->content ) ) {
			$result .= $this->content;
		}

		$result .= '</script>' . PHP_EOL;

		return $result;
	}

	protected function init() {
		$this->content = '';
		$this->id = '';
		$this->src = '';
	}

	/**
	 * @param array $options
	 */
	protected function populate( array $options ) {
		if ( isset( $options['content'] ) ) {
			$this->content = $options['content'];
		}

		if ( isset( $options['id'] ) ) {
			$this->id = filter_var( $options['id'], FILTER_SANITIZE_STRING );
		}

		if ( isset( $options['src'] ) ) {
			$this->src = filter_var( $options['src'], FILTER_SANITIZE_STRING );
		}
	}

}