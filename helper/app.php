<?php

function route($index)
{
    global $config;
    if (isset($config['route'][$index])) return $config['route'][$index];
    else return false;
}

function view($viewName, $pageData = [])
{
    $data = $pageData;


    if (file_exists(BASEDIR . '/View/' . $viewName . '.php')) require BASEDIR . '/View/' . $viewName . '.php';
    else return false;
}

function asset($asset)
{

    if (file_exists(BASEDIR . '/public/' . $asset)) return URL . 'public/' . $asset;
    else return false;

}

function lang($text)
{
    global $lang;
    if (isset($lang[$text])) return $lang[$text];
    else {
        return $text;
    }
}

function add_session($index,$value){
    $_SESSION[$index]=$value;
}
function get_session($index){
    if(isset($_SESSION[$index]))  return $_SESSION[$index];
    else return false;
}
function post($index){
    if(isset($_POST[$index])) return htmlspecialchars(trim($_POST[$index]));
    else return false;
}
function get($index){
    if(isset($_GET[$index])) return htmlspecialchars(trim($_GET[$index]));
    else return false;
}
function get_cookie($index){
    if(isset($_COOKIE[$index]))  return trim($_COOKIE[$index]);
    else return false;
}