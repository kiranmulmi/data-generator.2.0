<?php

function RenderTitle()
{
    global $BASE_TEMPLATE_TITLE;
    echo $BASE_TEMPLATE_TITLE;
}

function RenderBody()
{
    global $BASE_TEMPLATE_THEME;
    global $PARAMS;

    if(!is_null($PARAMS))extract($PARAMS);

    include_once $BASE_TEMPLATE_THEME;
}

function dd($dump) {
    echo "<pre>";
    var_dump($dump);
    echo "</pre>";
    exit();
}

function RedirectToUrl($url) {
    header("location:{$url}");
    exit();
}


function FlashData($message = null)
{

    if($message != null) {
        $_SESSION["FlashData"] = $message;
    } else {

        $message = "";
        if(isset($_SESSION["FlashData"])) {
            $message = $_SESSION["FlashData"];
            unset($_SESSION["FlashData"]);
        }
        return $message;
    }
}

function showError($message, $where = null) {
    echo $where;
    echo "<br/>";
    echo $message;
    exit();
}