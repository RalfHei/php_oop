<?php

namespace app\core\exception;

use app\core\Application;

class ForbiddenRoute extends \Exception
{
    protected $message;
    protected $code = 403;

    public function __construct()
    {
        $this->message = Application::$app->lang['forbidden'];
    }
}
