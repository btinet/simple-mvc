<?php

namespace simplemvc\ Core;

class View {

	public

	function render( $path, $data = false, $error = false ) {

		require APPPATH . 'views' . DS . "$path.php";

	}

}