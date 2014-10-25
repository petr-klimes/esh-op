<?php

/**
 * Product manager class
 */

namespace data;

class menu {

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

    public function getItemById($id) {
        $menu = $this->db->con->query('SELECT [id], [parent_id], [name], [e_name],[order],[active] FROM [menu] WHERE [id]=%i LIMIT 1', $id)->fetch();
        return $menu;
    }

    public function getItemByEname($ename) {
        $menuId = $this->db->con->query('SELECT [id] WHERE [e_name]=%s LIMIT 1', $ename)->fetch();
        return $this->getItemById($menuId['id']);
    }

    public function getItemByActualRoute($routeName) {
        $menuId = $this->db->con->query('SELECT [id] WHERE [route]=%s LIMIT 1', $routeName)->fetch();
        return $this->getItemById($menuId['id']);
    }
}
