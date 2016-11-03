<?php

namespace System;

class BaseController
{
    public $params;

    protected function view($viewPath, $title = null, $templatePath = null)
    {
        global $_GLOBAL_CLASS_PATH;

        if($title != null && $template != null) {
            global $BASE_TEMPLATE_THEME;
            global $BASE_TEMPLATE_TITLE;

            global $PARAMS;
            $PARAMS = $this->params;

            $BASE_TEMPLATE_THEME = str_replace('\\', '/', $_GLOBAL_CLASS_PATH . "/Views/" . $viewPath . ".php");
            $BASE_TEMPLATE_TITLE = $title;

            return include_once "$templatePath.php";
        } else {

            if(!is_null($this->params))extract($this->params);

            $fullViewPath = str_replace('\\', '/', $_GLOBAL_CLASS_PATH . "/Views/".$viewPath.".php");

            return require_once $fullViewPath;
        }

    }

    protected function addParams($Key, $Value) {
       $this->params[$Key] = $Value;
    }

}