<?php
const BASEDIR='C:\xampp\htdocs\todoApp';
const URL='http://localhost/todoApp/';
const DEV_MOD=true;

try {
    $db=new PDO('mysql:host=localhost;dbname=todoapp;','root','');
}catch (PDOException $e){
    echo $e->getMessage();
}