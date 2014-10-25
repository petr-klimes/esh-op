<?php

namespace libs\system;

class cache {
	
	private $cachedItems = array();
	
	/**
	 * @var file
	 */
	private $file;
	
	public function init() {
		$this->file = system::getObj('file');
	}

	public function get($name, $type = 'common') {
		if(!empty($cachedItems[$type][$name])){
			return $cachedItems[$type][$name];
		}elseif ($fileCache = $this->getFileCache($name, $type)) {
			return $fileCache;
		}else{
			return false;
		}
	}

	public function set($name, $value, $type = 'common') {
		$this->cachedItems[$name][$type] = $value;
		$this->setFileCache($name, $value, $type);
	}
	
	private function getFileCache($name,$type){
		return false;
	}
	
	private function setFileCache($name, $value, $type){
		return false;
	}

}
