<?php

/**
 * Trida starijici se o zjisteni ktery controller se ma o dany pozadavek postarat 
 * a nacte si do parametru s kterymi se ma spoustet
 */

namespace libs\system;

class router {

    private $domain;
    private $module;
    private $route;
    private $nameController;
    private $params;
    private $allowedQueryParams = array(
        'search'
    );

    /**
     * inicializace routery
     * na zaklade URI a controlleru (z configu app i daneho modulu)
     * najde odpovidajci controller a ten zinicializuje
     */
    public function init() {
        $this->domain = $this->getDomain();
        $this->module = $this->getModule();
        $this->addParams($this->getQueryParams());

        $this->route = $this->getRoute();
        $this->nameController = $this->route['controller'];

        $this->addVariablesToSystem();

        if (!$this->nameController) {
            // TODO - redirect module
            print_r(404);
            exit;
        }
    }

    /**
     * inicializuje controller -> najde ho a spusti initem
     * 
     * @param type $controller
     */
    public function initController() {
        $nameController = $this->nameController;
        $controllerNamespace = 'module\\' . $this->module . '\\controller\\' . $nameController;
        try {
            $controller = new $controllerNamespace($this->params);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            // TODO nanalezena trida controlleru -> zalogovat
            print_r(500);
            exit;
        }
    }

    /**
     * Ziska domenu
     * 
     * @return type
     */
    private function getDomain() {
        $serverDomain = $_SERVER['HTTP_HOST'];
        return $serverDomain;
    }

    /**
     * Z domeny urci o jaky modul se jedna
     * 
     * @return type
     */
    private function getModule() {
        $domains = system::getObj('config')->get('domain');
        $serverDomain = $this->getDomain();
        foreach ($domains as $domain => $module) {
            if ($serverDomain == $domain) {
                $findModule = $module;
                break;
            }
        }
        if (empty($findModule)) {
            // log err
        } else {
            return $findModule;
        }
    }

    private function getQueryParams() {
        $query = $_REQUEST;
        $params = array();
        foreach ($this->allowedQueryParams as $allowedParam) {
            if (!empty($query[$allowedParam])) {
                $params[$allowedParam] = $query[$allowedParam];
            }
        }
        return $params;
    }

    /**
     * Ziska routu a parametry pro ni z URI params
     * ktere zkousi napasovat do vsech controller path
     * prvni ktera bude vyhovovat vyhodi
     * 
     * @return route
     */
    private function getRoute() {
        // prvne musim pridat config z controlleru modulu
        $config = system::getObj('config');
        $config->addModuleConfig($this->module);

        // vyctu si vsechny mozny routy z configu
        $routes = $config->get('route');

        // nyni se juknu co prislo z requestu
        $uriParams = $this->getUriParams($_SERVER['REQUEST_URI']);
        $uriParamsCount = count($uriParams);

        // projdu vsechny routy a jakmile narazim na nejakou
        // ktere odpovida cesta tak to breaknu a vratim controler 
        // plus budu muset vycist promeny z url spolecne s queryParams
        $find = false;

        foreach ($routes as $routeName => $routeParams) {
            $routePathParams = $this->getControllerPathParams($routeParams['path']);
            // kontrola pocetem parametru
            if ($uriParamsCount == count($routePathParams)) {
                // stejny pocet a tak muzu zacit porovnavat
                if ($uriParamsCount > 0) {
                    $checkFail = false;
                    foreach ($routePathParams as $key => $value) {
                        if (!$this->checkParams($routePathParams[$key], $uriParams[$key])) {
                            $checkFail = true;
                            break;
                        }
                    }
                    // nenastala chyba
                    if (!$checkFail) {
                        $find = true;
                        // vyctu params
                        $this->addParams($this->getUriSpecificParams($routePathParams, $uriParams));
                        // zapisu controller
                        $route = $routeParams;
                        break;
                    }
                } else {
                    // ani jeden nema parametry, nalezli jsme nejspis hp
                    // tedy ok a poustim do controlleru, nemusim zapisovat zadny parametry
                    $route = $routeParams;
                    $find = true;
                }
            }
        }
        if ($find) {
            return $route;
        } else {
            return false;
        }
    }

    /**
     * Ziska parametry z URI pozadavku
     * 
     * @param type $uri
     * @return type
     */
    private function getUriParams($uri) {
        $uriReqParams = explode('/', $uri);
        $uriParams = array();

        // ocistim od prazdnych a query params
        foreach ($uriReqParams as $uriReqParam) {
            if (!empty($uriReqParam) && substr($uriReqParam, 0, 1) != '?') {
                if (strpos($uriReqParam, '?') !== FALSE) {
                    $pos = strpos($uriReqParam, '?');
                    $uriReqParam = substr($uriReqParam, 0, $pos);
                }
                $uriParams[] = trim(strtolower($uriReqParam));
            }
        }
        return $uriParams;
    }

    /**
     * Ziska parametry z cesty kontroleru
     * 
     * @param type $path
     * @return params
     */
    private function getControllerPathParams($path) {
        $pathParams = explode('/', $path);
        $params = array();
        if (!empty($pathParams)) {
            foreach ($pathParams as $key => $pathItem) {
                if (!empty($pathItem)) {
                    $params[] = trim(strtolower($pathParams[$key]));
                }
            }
        }

        return $params;
    }

    /**
     * Vycte specificky parametry z uri pro danou routu <engin_id%i>=> engin_id = 1 
     * 
     * @param type $routePar
     * @param type $uriPar
     * @return array
     */
    private function getUriSpecificParams($routePars, $uriPars) {
        $param = array();
        foreach ($routePars as $key => $routePar) {
            if (substr(trim($routePar), 0, 1) == '<') {
                $paramKey = substr($routePar, 1, strpos($routePar, '%') - 1);
                $param[$paramKey] = $uriPars[$key];
            }
        }
        return $param;
    }

    /**
     * zkontroluje route a uri params zda zapadaji
     * pokud neni route obalen <> tak se musi rovnat
     * jinak staci typ route param aby splnoval
     * 
     * @param type $routePar
     * @param type $uriPar
     * @return bool
     */
    private function checkParams($routePar, $uriPar) {
        $check = false;
        // prvne zkontroluji zda je route param staticky nebo promenna
        if (substr(trim($routePar), 0, 1) == '<') {
            // je to promena a musim zistit jeji typ
            $type = substr($routePar, strpos($routePar, '%') + 1, -1);
            switch ($type) {
                case 's':
                    if (is_string($uriPar)) {
                        $check = true;
                    }
                    break;
                case 'i':
                    if (is_numeric($uriPar)) {
                        $check = true;
                    }
                    break;
            }
        } else {
            // je to statik
            if ($routePar == $uriPar) {
                $check = true;
            }
        }
        return $check;
    }

    /**
     * pridani hlavnich parametru do $this->params
     * nove parametry nahrazuji ty stare, pokud je force = true
     * 
     * @param type $params
     * @return array
     */
    private function addParams($params, $force = true) {
        foreach ($params as $key => $param) {
            $param = trim(strtolower($param));
            if (!empty($param)) {
                if ($force) {
                    $this->params[$key] = $param;
                } else {
                    if (empty($this->params[$key])) {
                        $this->params[$key] = $param;
                    }
                }
            }
        }
        return $this->params;
    }

    /**
     * Preda nektere attributz tridz do systemu,
     * tak aby se dali jednoduseji pouzit i jinde
     */
    public function addVariablesToSystem() {
        system::$module = $this->module;
        system::$params = $this->params;
        system::$route = $this->route;
    }

}
