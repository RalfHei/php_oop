<?php

namespace app\core;

class Session
{
    protected const FLASH_KEY = 'flash_messages';
    public function __construct()
    {
        session_start();

        $flashMsgs = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMsgs as $key => &$flashMsg) {
            $flashMsg['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMsgs;
    }
    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public static function getLang()
    {
        if (!isset($_SESSION['lang']))
            $_SESSION['lang'] = 'en';
        else if (isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
            if ($_GET['lang'] == 'en')
                $_SESSION['lang'] = 'en';
            else if ($_GET['lang'] == 'et')
                $_SESSION['lang'] = 'et';
        }
        $lang = $_SESSION['lang'];
        return $lang;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $flashMsgs = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMsgs as $key => &$flashMsg) {
            if ($flashMsg['remove']) {
                unset($flashMsgs[$key]);
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMsgs;
    }
}
