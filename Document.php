<?php
namespace Pennline\Html;

use Pennline\Php\Exception;

class Document {

	/**
	 * @var string
	 */
	public $page;

	/**
	 * @var string
	 */
	public $heading;

	/**
	 * @var string
	 */
	public $html;

	/**
	 * @var array
	 * an array collection of Link’s
	 */
	protected $links;

	/**
	 * @var array
	 * an array collection of Meta’s
	 */
	protected $metas;

	/**
	 * @var array
	 * an array collection of Script’s
	 */
	protected $scripts;

	/**
	 * @var array
	 * an array collection of Style’s
	 */
	protected $styles;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	public $view;


	public function __construct() {
		$this->init();
	}

	/**
	 * @param Link $Link
	 * @throws Exception
	 */
	public function addLink( $Link ) {
		if ( !( $Link instanceof Link ) ) {
			error_log( __METHOD__ . '() $Link provided is not a valid Pennline\Html\Link' );
			throw new Exception( 'parameter type error', 1 );
		}

		$this->links[] = $Link;
	}

	/**
	 * @param Meta $Meta
	 * @throws Exception
	 */
	public function addMeta( $Meta ) {
		if ( !( $Meta instanceof Meta ) ) {
			error_log( __METHOD__ . '() $Meta provided is not a valid Pennline\Html\Meta' );
			throw new Exception( 'parameter type error', 1 );
		}

		$this->metas[] = $Meta;
	}

	/**
	 * @param Script $Script
	 * @param string $placement
	 * @throws Exception
	 */
	public function addScript( $Script, $placement = 'body' ) {
		if ( !( $Script instanceof Script ) ) {
			error_log( __METHOD__ . '() $Script provided is not a valid Pennline\Html\Script' );
			throw new Exception( 'parameter type error', 1 );
		}

		switch ( $placement ) {
			case 'body':
				$this->scripts['body'][] = $Script;
				break;

			case 'head':
				$this->scripts['head'][] = $Script;
		}
	}

	/**
	 * @param Style $Style
	 */
	public function addStyle( $Style ) {
		if ( !( $Style instanceof Style ) ) {
			error_log( __METHOD__ . '() $Style provided is not a valid Pennline\Html\Style' );
			throw new Exception( 'parameter type error', 1 );
		}

		$this->styles[] = $Style;
	}

	/**
	 * @return string
	 */
	public function getHeading() {
		$result = '';

		if ( empty( $this->heading ) ) {
			return $result;
		}

		$result = '<h1>' . $this->heading . '</h1>';
		return $result;
	}

	/**
	 * @return string
	 */
	public function getHtml() {
		$result = $this->html;

		if ( APPLICATION_ENV !== 'development' ) {
			// remove comments
			$result = preg_replace( '/<!--(.*?)-->/', '', $result );

			// remove tabs and new lines
			$result = str_replace( array( "\t", "\n" ), '', $result );
		}

		return $result;
	}

	/**
	 * @return string
	 */
	public function getLinks() {
		$result = '';

		foreach ( $this->links as $link ) {
			$result .= $link;
		}

		return $result;
	}

	/**
	 * @return string
	 */
	public function getMeta() {
		$result = '';

		foreach ( $this->metas as $meta ) {
			$result .= $meta;
		}

		return $result;
	}

	/**
	 * @return string
	 */
	public function getPageAsCssClass() {
		return str_replace( '/', '-', $this->page );
	}

	/**
	 * @param string $placement
	 * @return string
	 */
	public function getScripts( $placement = 'body' ) {
		$result = '';

		switch ( $placement ) {
			case 'head':
				$scripts = $this->scripts['head'];
				break;

			case 'body':
				$scripts = $this->scripts['body'];
				break;

			default:
				return $result;
		}

		foreach ( $scripts as $script ) {
			$result .= $script;
		}

		return $result;
	}

	/**
	 * @return string
	 */
	public function getStyles() {
		$result = '';

		foreach ( $this->styles as $style ) {
			$result .= $style;
		}

		return $result;
	}

	/**
	 * @return string|bool
	 */
	public function getViewFilepath() {
		if ( substr( $this->page, -1 ) === '/' ) {
			$filename = 'index.view.php';
		} else {
			$filename = '.view.php';
		}

		return realpath( APPLICATION_PATH . '/views/' . $this->page . $filename );
	}

	protected function init() {
		$this->page = '';
		$this->heading = '';
		$this->html = '';
		$this->links = array();
		$this->metas = array();
		$this->scripts = array( 'head' => array(), 'body' => array() );
		$this->styles = array();
		$this->title = '';
		$this->view = '';
	}

}