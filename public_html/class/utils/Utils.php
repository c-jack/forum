<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/12/2018
 * Time: 17:12
 */

namespace utils;

use enum\Cons;

class Utils
{

    /**
     * @param array $keys
     * @param array $arr
     * @return array
     */
    public static function array_keys_exist(array $keys, array $arr) : array {

        $diff = array_diff_key( $keys, $arr);

        return array( !$diff, key($diff) );
    }

    /**
     * @param $val
     * @param $type
     * @return string
     */
    public static function clean($val, $type) {
        if ($type == 'text2') {
            $val = htmlspecialchars($val, ENT_COMPAT, Cons::UTF_8);
        }
        if ($type == 'text2') {

            $val = str_replace( "<", "&lt;" , $val );
            $val = str_replace( ">", "&gt;" , $val );
            $val = str_replace( '"', "&quot;", $val );
            $val = str_replace( "(", '&#040;', $val );
            $val = str_replace( ")", '&#041;', $val );
            $val = str_replace( "DROP TABLE", 'NAUGHTY', $val );
            // and some bad stuff
            $val = preg_replace( "/javascript/i" , "j&#097;v&#097;script", $val );
            $val = preg_replace( "/alert/i" , "&#097;lert" , $val );
            $val = preg_replace( "/about:/i" , "&#097;bout:" , $val );
            $val = preg_replace( "/onmouseover/i", "&#111;nmouseover" , $val );
            $val = preg_replace( "/onclick/i" , "&#111;nclick" , $val );
            $val = preg_replace( "/onload/i" , "&#111;nload" , $val );
            $val = preg_replace( "/onsubmit/i" , "&#111;nsubmit" , $val );
            $val = preg_replace( "/document\./i" , "&#100;ocument." , $val );
            $val = htmlspecialchars($val, ENT_COMPAT, Cons::UTF_8);
        }
        if ($type == 'text') {
            $val = filter_var($val, FILTER_SANITIZE_STRING);
            $val = htmlspecialchars($val, ENT_COMPAT, Cons::UTF_8);
            $val = str_replace( "<", "&lt;" , $val );
            $val = str_replace( ">", "&gt;" , $val );
            $val = str_replace( '"', "&quot;", $val );
            $val = str_replace( "(", '&#040;', $val );
            $val = str_replace( ")", '&#041;', $val );
            $val = str_replace( "DROP TABLE", 'NAUGHTY', $val );
            // and some bad stuff
            $val = preg_replace( "/javascript/i" , "j&#097;v&#097;script", $val );
            $val = preg_replace( "/alert/i" , "&#097;lert" , $val );
            $val = preg_replace( "/about:/i" , "&#097;bout:" , $val );
            $val = preg_replace( "/onmouseover/i", "&#111;nmouseover" , $val );
            $val = preg_replace( "/onclick/i" , "&#111;nclick" , $val );
            $val = preg_replace( "/onload/i" , "&#111;nload" , $val );
            $val = preg_replace( "/onsubmit/i" , "&#111;nsubmit" , $val );
            $val = preg_replace( "/document\./i" , "&#100;ocument." , $val );
            $val = filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS);

        }
        if ($type == 'phone') {
            $val = filter_var($val, FILTER_SANITIZE_NUMBER_INT);
            $val = preg_replace('/()-[^0-9]/', '', $val);
            $val = htmlspecialchars($val, ENT_COMPAT, Cons::UTF_8);
        }
        elseif ($type == 'values') {
            $val = filter_var($val, FILTER_SANITIZE_STRING);
            $val = preg_replace("/&(?!#[0-9]+;)/s", '&amp;', $val );
        }
        elseif ($type == 'number') {
            $val = filter_var($val, FILTER_SANITIZE_NUMBER_INT);
            $val = htmlspecialchars($val, ENT_COMPAT, Cons::UTF_8);
        }
        elseif ($type == 'email') {
            $val = filter_var($val, FILTER_SANITIZE_EMAIL);
        }
        elseif ($type == 'url') {
            $val = filter_var($val, FILTER_SANITIZE_URL);
        }
        elseif ($type == 'username') {
            $val = filter_var($val, FILTER_SANITIZE_STRING);
            $val = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $val);

        }
        return trim($val);
    }
}