<?php

namespace libs\system;

class system {

	private static $objects = array();

	/**
	 * Promenne z routeru
	 * @var type 
	 */
	public static $module;
	public static $params;
        public static $route;

	/**
	 * inicialializace obj
	 */
	public static function init() {
		
	}

	/**
	 * Ziskani systemoveho objektu - musi mit metodu intit (TODO: interface)
	 * 
	 * @param type $nameObj
	 * @return type obj
	 */
	public static function getObj($nameObj) {
		if (!empty(self::$objects[$nameObj])) {
			return self::$objects[$nameObj];
		} else {
			$className = 'libs\system\\' . $nameObj;
			if (class_exists($className)) {
				$obj = new $className();
				$obj->init();
				self::$objects[$nameObj] = $obj;
				return $obj;
			} else {
				// TODO: log
				return null;
			}
		}
	}

}
