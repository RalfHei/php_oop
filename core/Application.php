<?php

namespace app\core;

use app\core\database\Database;
use app\core\database\DbModel;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public string $layout = 'main';
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public static Application $app;
    public string $userClass;
    public ?DbModel $user;
    public array $lang = [];

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->userClass = $config['userClass'];
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {

            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public static function isEditor()
    {
        if (self::$app->user->rights == 'Editor') {
            return self::$app->user;
        } else {
            return !self::$app->user;
        }
    }
    public static function isUser()
    {
        if (self::$app->user->rights == 'User') {
            return self::$app->user;
        } else {
            return !self::$app->user;
        }
    }
    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $this->router->renderView('_404', [
                'exception' => $e
            ]);
        }
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }
    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}
