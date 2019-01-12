<?php

require_once( __DIR__ . "/../base.php" );

use enum\Cons;
$smarty->display('head.tpl');

if($loggedIn && (isset($_SESSION[Cons::USER_ID], $_SESSION[Cons::USERNAME]))) {
    $smarty->assign('username', $_SESSION[Cons::USERNAME]);
    $smarty->assign('userid', $_SESSION[Cons::USER_ID]);
}
echo "<div id='content' class='container'>";
$smarty->display('header.tpl');


$page = "index";
if(isset($_GET['p'])) {
    switch ($_GET['p']) {
        case "login":
            //do something login
            require_once('inc/login.php');
            break;
        case "logout":
            require_once('inc/login.php');
            break;
        case "test":
            $page = $_GET['p'];
            break;
    }
}


$smarty->display($page.'.tpl');


echo "</div>";
