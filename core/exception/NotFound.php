<?php

namespace app\core\exception;

use app\core\Application;

class NotFound extends \Exception

{
    protected $message;
    protected $code = 404;

    public function __construct()
    {
        $this->message = Application::$app->lang['notFound'];
    }
}
