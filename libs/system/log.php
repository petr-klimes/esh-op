<?php

namespace libs\system;

class log {

    /**
     * @var libs\system\file
     */
    private $file;

    public function init() {
        $this->file = system::getObj('file');
    }

    public function set($cat, $name) {
        $path = $this->getLogPath($cat, $name);
    }

    private function getLogPath($cat, $name) {
    }

}
