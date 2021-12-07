<?php
/**
* abre, carga todo lo necesario y lo ejecuta en su momento.
**/
session_start();
include "core/autoload.php";

define("ROOT",dirname(__FILE__));

$lb = new Lb();
$lb->loadModule("index");

?>