<?php

namespace app\core\lang;

use app\core\Request;
use app\core\Session;

class Lang
{
    public function pageLang()
    {
        $locale = Session::getLang();

        if ($locale == 'en') {
            return en::$lang;
        } else if ($locale == 'et') {
            return et::$lang;
        }
    }

    public function changeLang()
    {
        $path = (new Request)->getPath();
        $uri = $_SERVER['REQUEST_URI'];
        if (isset($_SERVER['QUERY_STRING'])) {
            if (isset($_GET['lang'])) {
                parse_str($_SERVER['QUERY_STRING'], $queryStr);
                unset($queryStr['lang']);
                $unsetStr = http_build_query($queryStr);
                $uri = $_SERVER['REQUEST_URI'];
                return $path . "?" . $unsetStr . "&";
            } else {
                return $uri . "&";
            }
        } else {
            return "?";
        }
    }
}
