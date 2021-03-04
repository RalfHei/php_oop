<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\DbModel;
use app\core\Request;
use app\core\Model;
use app\core\Response;
use app\models\LoginModel;
use app\models\User;

class AuthController extends Controller
{


    public function login(Request $request, Response $response)
    {
        $loginModel = new LoginModel;
        if ($request->isPost()) {
            $loginModel->loadData($request->getBody());
            if ($loginModel->validate() && $loginModel->login()) {
                $response->redirect('/');
                return;
            }
        }
        return $this->render('login', [
            'model' => $loginModel
        ]);
    }

    public function register(Request $request, Response $response)
    {
        $lang = Application::$app->lang;
        $user = new User();
        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save()) {
                $loginModel = new LoginModel;
                if ($request->isPost()) {
                    $loginModel->loadData($request->getBody());
                    if ($loginModel->validate() && Application::isGuest()) {
                        $loginModel->login();
                        Application::$app->session->setFlash('success', $lang['regSucsess']);
                        $response->redirect('/');
                        return;
                    } elseif ($loginModel->validate() && !Application::isGuest()) {
                        Application::$app->session->setFlash('success', $lang['regSucsess']);
                        $response->redirect('/admin');
                        return;
                    }
                }
            }
            return $this->render('register', [
                'model' => $user
            ]);
        }
        return $this->render('register', [
            'model' => $user
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
}
