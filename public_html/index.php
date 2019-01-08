<?php
require( "header.php" );
$db = new \db\Connect();
$query = $db->query( "SELECT value FROM _settings;" ) ;


    if (in_array('2019-01-02', $query ) ) {
        echo "Yes, the date is in the array!";
    } else {
        echo "No, the date is not in the array!";
    }


/**
 * Created by PhpStorm.
 * User: chris
 * Date: 29/12/2018
 * Time: 18:20
 */
require( "header.php" );
