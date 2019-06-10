<?php

namespace simplemvc;

use simplemvc\ Controller;

class Bootstrap {

	public $_post;
	private $_url;
	private $_filter;
	private $_controller = null;
	private $_defaultController;

	public

	function __construct() {
		//start the session class
		Session::init();
		//sets the url
		$this->_getUrl();
		$this->_getPOST();

	}

	public

	function setController( $name ) {
		
		$this->_defaultController = $name;
	}

	public

	function init() {
		//if no page requested set default controller
				
		if ( empty( $this->_url[ 0 ] ) ) {
			$this->_loadDefaultController();
			return false;
		}

		$this->_loadExistingController();
		$this->_callControllerMethod();
	}

	private

	function _getUrl() {
		$url = isset( $_GET[ 'url' ] ) ? rtrim( $_GET[ 'url' ], '/' ) : NULL;
		$url = urldecode( filter_var( urlencode( $url ), FILTER_SANITIZE_URL ) );
		$this->_url = explode( '/', $url );
	}

	public

	function _getPOST() {
		$post = isset( $_POST ) ? $_POST : NULL;
		$this->_post = filter_var_array( $post, FILTER_SANITIZE_STRING );
	}

	private

	function _loadDefaultController() {
		$this->_defaultController = 'App\Controller\\' . $this->_defaultController;
		$this->_controller = new $this->_defaultController();
		$this->_controller->index();
	}

	private

	function _loadExistingController() {

		//set url for controllers
		$controller = 'App\Controller\\' . $this->_url[ 0 ];

		if ( class_exists( $controller ) ) {
			
			//instatiate controller
			$this->_controller = new $controller;
		} else {
			$this->_errors( "File does not exist: " . $this->_url[ 0 ] );
			return false;
		}

	}

	/**
	 * If a method is passed in the GET url paremter
	 *
	 *  http://localhost/controller/method/(param)/(param)/(param)
	 *  url[0] = Controller
	 *  url[1] = Method
	 *  url[2] = Parameter
	 *  url[3] = Parameter
	 *  url[4] = Parameter
	 */
	private

	function _callControllerMethod() {
		unset( $this->_url[ 0 ] );
		$method = 'index';

		if (isset($this->_url[ 1 ])){
			
			if ( is_callable( array( $this->_controller, $this->_url[ 1 ] ) ) ) {
				$method = array_shift( $this->_url );
			}
			
		} 

		$parameter[ 'get' ] = filter_var_array( $this->_url, FILTER_SANITIZE_STRING );
		$parameter[ 'post' ] = $this->_post;

		call_user_func_array( array( $this->_controller, $method ), $parameter );
	}

	/**
	 * Display an error page if nothing exists
	 *
	 * @return boolean
	 */
	private

	function _errors( $error ) {

		$this->_controller = new Errors( $error );
		$this->_controller->index();
		die;
	}

}