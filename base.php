<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 09/01/2019
 * Time: 22:38
 */

use enum\Cons;
require_once( __DIR__ . '/vendor/autoload.php');

require('libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ . '/smarty/templates');
$smarty->setCompileDir(__DIR__ . '/smarty/templates_c');
$smarty->setCacheDir(__DIR__ . '/smarty/cache');
$smarty->setConfigDir(__DIR__ . '/smarty/configs');

use user\Login;

session_name(Cons::SESSION_NAME);
session_start();

$loggedIn = Login::validateLogin();
$smarty->assign('loggedIn', $loggedIn);
