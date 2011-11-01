<?php 
require_once('FirePHPCore/FirePHP.class.php');
ob_start();

$firephp = FirePHP::getInstance(true);
 
$var = array('i'=>10, 'j'=>20);
 
$firephp->log($var, 'Iterators');
?>