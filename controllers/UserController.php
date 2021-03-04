<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\core\middlewares\AuthMiddleware;

class UserController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['edit']));
    }

    public function userEdit(Request $request, Response $response)
    {
        $lang = Application::$app->lang;
        $key = Application::$app->user->id;

        $users = User::findOne(['id' => $_GET['user']]);
        if ($key != $users->id) {
            return $this->render("edit", [
                'model' => $users
            ]);
        } else {
            $response->redirect('/admin');
            Application::$app->session->setFlash('wrong', $lang['flashWrong']);
        }
    }

    public function userUpdate(Request $request, Response $response)
    {
        $id = $_GET['id'];
        $user = User::findOne(['id' => $id]);
        $lang = Application::$app->lang;

        if ($request->isPost()) {
            $body = $request->getBody();
            if ($user->update($id, [
                'email' => $body['email'],
                'password' => $body['password'],
                'rights' => $body['rights']
            ])) {
                $response->redirect('/admin');
                Application::$app->session->setFlash('success', $lang['flashEdited']);
            } else {
                return $this->render("edit", [
                    'model' => $user
                ]);
            }
        }
    }

    public function destroy(Request $request, Response $response)
    {
        $lang = Application::$app->lang;
        $key = Application::$app->user->id;

        $users = User::findOne(['id' => $_GET['user']]);
        if ($key != $users->id) {
            if ($users->deleteOne($users->id)) {
                $response->redirect('/admin');
                Application::$app->session->setFlash('success', $lang['flashDeleted']);
            }
        } else {
            $response->redirect('/admin');
            Application::$app->session->setFlash('wrong', $lang['flashWrong']);
        }
    }
}
