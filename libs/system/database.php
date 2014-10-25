<?php

namespace libs\system;

class database {

	/**
	 * dibi connection 
	 * @var \DibiConnection 
	 */
	public $con;

	public function init() {
		if (empty($this->con)) {
			$config = system::getObj('config');
			$this->con = $this->getConnection($config->get('db'));
		}
	}
	
	/**
	 * @param type $config
	 * @return \DibiConnection
	 */
	private function getConnection($config) {
		// naicluduju dibi
		include APP_DIR . '/libs/external/dibi/dibi.php';
		$config = array(
			'driver' => $config['driver'],
			'host' => $config['host'],
			'username' => $config['username'],
			'password' => $config['password'],
			'charset' => $config['charset'],
			'database' => $config['database'],
		);
		\dibi::connect($config);
		return \dibi::getConnection();
	}
}
