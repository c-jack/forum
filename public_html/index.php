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
        case "forums":
            if(!isset($_GET['t'])) {
                require_once('inc/forums.php');
                $smarty->assign('forumList', $forums);
                $page = "components/forumList";
            }
            else {
                $threadId = $_GET['t'];
                require_once('inc/forum_threads.php');
                $smarty->assign('threadList', $threads);
                $page = "components/threadList";
            }
            break;
        case "test":
            $page = $_GET['p'];
            break;
    }
}


$smarty->display($page.'.tpl');


echo "</div>";
$smarty->display('footer.tpl');