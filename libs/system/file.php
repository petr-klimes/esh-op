<?php

namespace libs\system;

class file {

	public function init() {
		
	}

	public function getFileContent($file) {
		try {
			return file_get_contents($file);
		} catch (\Exception $e) {
			print_r($e->getMessage());
		}
	}

	public function setFile($file, $data) {
		try {
			file_put_contents($file, $data, LOCK_EX);
			$this->setChmod($file);
		} catch (\Exception $e) {
			print_r($e->getMessage());
		}
	}

	public function appendToFile($file, $data) {
		try {
			file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
			$this->setChmod($file);
		} catch (\Exception $e) {
			print_r($e->getMessage());
		}
	}

	public function fileExist($file) {
		return file_exists($file);
	}

	public function deleteFile($file) {
		try {
			unlink($file);
		} catch (\Exception $e) {
			print_r($e->getMessage());
		}
	}

	public function deleteFiles($path) {
		
	}

	private function setChmod($file) {
		chmod($file, 0777);
	}

}
