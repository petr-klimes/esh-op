<?php

namespace libs\system;

class config {

    private $config;

    public function init() {
        // TODO: cache !!!
        // nacteni configu
        include APP_DIR . '/config/config.php';
        $this->config = $config;
    }

    public function get($cat, $name = null) {
        if ($name) {
            return $this->config[$cat][$name];
        } else {
            return $this->config[$cat];
        }
    }

    public function getAll() {
        return $this->config;
    }

    public function add($config) {
        $this->config = array_merge($this->config, $config);
    }

    public function addModuleConfig($moduleName) {
        include APP_DIR . "/module/$moduleName/config/config.php";
        if (isset($config)) {
            $this->add($config);
        }
    }

}
