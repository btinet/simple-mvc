<?php

namespace simplemvc\ Core;

class Model {

	protected $_db;
	protected $_imap;

	public function __construct() {
		//connect to PDO here.
		$this->_db = new Database();
		//$this->_imap = new ImapClient(IMAP_HOST, IMAP_USER, IMAP_PASS, 'tls');
	}	

}