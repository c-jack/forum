<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 09/01/2019
 * Time: 22:20
 */

use forum\Forum;

$threads = Forum::getThreads( $threadId, 0, 10 );
