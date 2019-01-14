<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/12/2018
 * Time: 14:18
 */

namespace forum;


use enum\Cons;
use enum\Query;
use PDO;

/**
 * Class Forum
 * @package forum
 */
class Forum
{
    public static function getForums() {
        $forumDb = null;

        try {
            $forumDb = new \db\Connect();
        } catch (\Exception $e) {
            # exception
            echo "exception";
        }
        $forumList = $forumDb->query(Query::GET_FORUM_LIST);

        if (!$forumList) {
            //user doesn't exist
            return false;
        } else {
            $endResult = array();
            foreach($forumList as $row)
            {
                if (!isset($endResult[$row['category']]))
                {
                    $endResult[$row['category']] = array();

                }

                $endResult[$row['category']][$row['name']] = array(
                    'id' => $row['id'],
                    'description' => $row['description'],
                    'threads' => $row['threads'],
                    'posts' => $row['posts'],
                );
            }
            return $endResult;
        }
    }    public static function getThreads( $forumId, $limit, $offset ) {
        $forumDb = null;

        try {
            $forumDb = new \db\Connect();
        } catch (\Exception $e) {
            # exception
            echo "exception";
        }

        $params = array(Cons::TBL_FORUM_FORUM_ID=>[$forumId,PDO::PARAM_INT],
                    Cons::QRY_MIN=>[$limit,PDO::PARAM_INT],
                    Cons::QRY_OFFSET=>[$offset,PDO::PARAM_INT]);
        $forumDb->bind_multiple( $params );

        $topicList = $forumDb->query(Query::GET_FORUM_TOPICS);

        if (!$topicList) {
            //user doesn't exist
            return false;
        } else {
            return $topicList;
        }
    }
}