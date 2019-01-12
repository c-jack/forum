<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 09/01/2019
 * Time: 22:20
 */
use user\Login;
if(isset($_POST['email'], $_POST['p']))
{
    $user = $_POST['email'];
    $pass = $_POST['p'];

    $loginAttempt = new Login( $user, $pass );
    echo"<br><br>";
    if($result = $loginAttempt->result) {
        if ($result[0]) {
            $smarty->assign('loggedIn', true);
            $smarty->display('components/loggedIn.tpl');
            die();
        } else {
            echo "Not Logged in";
        }
    }
    else
    {
        echo "fail";
    }
}
else{
    if(isset($_GET['p']) && ($_GET['p'] == "logout"))
    {
        $loggedIn = Login::logOut();
        echo $loggedIn;
        $smarty->assign('loggedIn', $loggedIn);
        $smarty->display('components/loggedOut.tpl');
        exit();
    }
}