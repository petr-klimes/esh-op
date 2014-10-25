<?php
/**
 * Catalog manager class
 */
namespace data;

class catalog {

    /**
     * databazova trida
     * @var \libs\system\database
     */
    private $db;

    /**
     * @var \data\menu
     */
    private static $instance;

    /**
     * Ziskani instance tridy
     * @return \data\menu 
     */
    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    public function init() {
        $this->db = \libs\system\system::getObj('database');
    }

    public function getHomepageProductCatalog() {

    }
}
