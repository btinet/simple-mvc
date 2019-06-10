<?php

namespace simplemvc\ Core;

use Twig\ Loader;

class Controller {

	protected $_view;
	protected $_model;
	protected $_data;
	protected $_template;
	

	function __construct() {
		$this->_view = new View();
		
		$name = get_class($this);		
		$modelpath = 'models/' . strtolower($name) . '_model.php';

		if (file_exists($modelpath)) {
			require $modelpath;

			$modelName = $name . '_Model';
			$this->_model = new $modelName();
		};		
		$this->_data['page'] = explode("/", $_REQUEST["url"]);
		$this->_data['time'] = date("d.m.Y - H:i", time());
		$this->_data[ 'parent_template' ] = 'default.tpl';
		
		
		
		$loader = new Loader\ FilesystemLoader( TPATH );
		$this->_template = new\ Twig\ Environment( $loader );
		
	}

}
