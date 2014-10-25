<?php

namespace libs\system;

use data\menu as menu;

class page {

    private $js;
    private $css;
    private $title;
    private $keys;
    private $h1;
    private $displayType;

    public function init() {
        $this->setInfoFromActualMenu();
    }

    private function setInfoFromActualMenu() {
        $this->setDisplayType();
        $this->setDefaultCss();
        $this->setDefaultJs();
        $menu = menu::getInstance()->getItemByActualUrl();
    }
    
    private function setDisplayType(){
        
    }
    
    private function setDefaultCss(){
        
    }
    
    private function setDefaultJs(){
        
    }

    public function setCss($path) {
        
    }

    public function getCss() {
        
    }

    public function setJs($path) {
        
    }

    public function getJs() {
        
    }

    public function setTitle($title) {
        
    }

    public function getTitle() {
        
    }

    public function setKey($key) {
        
    }

    public function setKeys($keys) {
        
    }

    public function getKeys() {
        
    }

    public function setH1($h1) {
        
    }

    public function getH1() {
        
    }

}
