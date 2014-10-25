<?php

namespace libs\system;

class controller {

	private $variables = array();
	private $smarty = null;
	
	public function init(){
		
	}

	public function setVariable($name, $value) {
		$this->variables[$name] = $value;
	}

	public function getVariable($name) {
		return $this->variables[$name];
	}

	public function getVariables() {
		return $this->variables;
	}
	
	/***********************************
	 * SMARTY
	 **********************************/
	public function fetchTemplate($templateName, $cacheId = null) {
		$smarty = $this->getSmarty();
		return $smarty->fetch($templateName . '.tpl', $cacheId);
	}

	public function renderTemplate($templateName, $cacheId = null) {
		$smarty = $this->getSmarty();
		$smarty->display($templateName . '.tpl', $cacheId);
	}

	private function getSmarty() {
		if (!$this->smarty) {
			include_once APP_DIR .'/libs/external/smarty/Smarty.class.php';

			$smarty = new \Smarty();
			$smarty->addTemplateDir(APP_DIR . "/module/" . system::$module . "/template/");
			$smarty->setCompileDir(APP_DIR . '/cache/smarty/template_c/');
			$smarty->setConfigDir(APP_DIR . '/config/items/');
			$smarty->setCacheDir(APP_DIR . '/cache/smarty/cache/');

			foreach ($this->variables as $name => $value) {
				$smarty->assign($name, $value);
			}
			
			$this->smarty = $smarty;
		}
		return $this->smarty;
	}

	/***********************************
	 * JSON
	 **********************************/
	public function fetchJson() {
		return $this->getJson();
	}

	public function renderJson() {
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-type: application/json');
		echo $this->getJson();
		
	}

	private function getJson() {
		return json_encode($this->variables);
	}

}
