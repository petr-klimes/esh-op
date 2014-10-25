<?php
// Ulozeni reference na /public adresar
define('PUBLIC_DIR', realpath('.'));
// Prejdeme do korene cele aplikace, cimz usnadnime praci s cestami. Vsechno je
// nyni relativni ke koreni.
chdir(dirname(__DIR__));

define('DS', DIRECTORY_SEPARATOR);
define('APP_DIR', realpath('.'));

include_once 'libs/system/autoload.php';

use libs\system\system as system;

class app {

    private $router;
    private $config;

    public function init() {
        $this->cofig = system::getObj('config');
        $this->router = system::getObj('router');
        $this->router->initController();
    }

}
$app = new app();
$app->init();
?>