<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\core\middlewares\AuthMiddleware;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['admin']));
        $this->registerMiddleware(new AuthMiddleware(['edit']));
    }

    public function userEdit(Request $request, Response $response, Application $app)
    {
        $lang = $app->lang;
        $key = $app->user->id;
        $users = User::findOne(['id' => $_GET['user']]);
        if ($key != $users->id) {
            return $this->render("edit", [
                'model' => $users
            ]);
        } else {
            $response->redirect('/admin');
            $app->session->setFlash('wrong', $lang['flashWrong']);
        }
    }

    public function userUpdate(Request $request, Response $response, Application $app)
    {
        $id = $_GET['id'];
        $user = User::findOne(['id' => $id]);
        $lang = $app->lang;
        if ($request->isPost()) {
            $body = $request->getBody();
            if ($user->update($id, [
                'email' => $body['email'],
                'password' => $body['password'],
                'rights' => $body['rights']
            ])) {
                $response->redirect('/admin');
                $app->session->setFlash('success', $lang['flashEdited']);
            } else {
                return $this->render("edit", [
                    'model' => $user
                ]);
            }
        }
    }

    public function destroy(Request $request, Response $response, Application $app)
    {

        $lang = $app->lang;
        $key = $app->user->id;
        $users = User::findOne(['id' => $_GET['user']]);
        if ($key != $users->id) {
            if ($users->deleteOne($users->id)) {
                $response->redirect('/admin');
                $app->session->setFlash('success', $lang['flashDeleted']);
            }
        } else {
            $response->redirect('/admin');
            $app->session->setFlash('wrong', $lang['flashWrong']);
        }
    }

    public function admin(Request $request)
    {
        $_SESSION['lastUri'] = $_SERVER["REQUEST_URI"];
        $currentPage = $_GET['page'] ?? 1;
        $max = count(User::all());
        $maxPages = ceil($max / 10);
        $users = User::findLimit((($currentPage - 1) * 10), 10);
        $search = $_GET['search'];
        $user = User::findSome(['email' => $search]);
        if (isset($search)) {

            if ($user !== false && $request->isGet()) {
                $sMax = count($user);
                $result = array_slice($user, (($currentPage - 1) * 5), 5);
                $maxPages = ceil($sMax / 5);
                return $this->render('admin', [
                    'user' => $result,
                    'search' => $search,
                    'max' => $sMax,
                    'maxPages' => $maxPages,
                    'currentPage' => $currentPage,
                ]);
            }
        } else {
            return $this->render('admin', [
                'user' => $users,
                'max' => $max,
                'maxPages' => $maxPages,
                'currentPage' => $currentPage,
            ]);
        }
    }
}
