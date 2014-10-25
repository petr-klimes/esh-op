<?php

namespace module\shopopp\controller;

use libs\system\controller;
use data\product as product;
use data\menu as menu;
use libs\system\page as page;
use libs\system\system as system;

class homepage extends controller {

    public function __construct($params) {
		
		$productMan = product::getInstance();
		$productMan->getItemById(1);
		
		$menu = menu::getInstance()->getItemByActualUrl();
		// z menu vycist title, klicova slova, h1
		
		$page = system::getObj('page');
		
		$this->setVariable('page', $page);
		$this->setVariable('welcome', 'welcome');
		$this->renderTemplate('layout');
    }

}
