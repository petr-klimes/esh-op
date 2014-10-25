<?php

namespace module\shopopp\controller;

use libs\system\controller;
use data\product as product;

class homepage extends controller {

    public function __construct($params) {	
        $this->setVariable('welcome', 'welcome');
        $this->renderJson();
    }

}
