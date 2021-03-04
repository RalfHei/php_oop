<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\PostMiddleware;
use app\models\Blog;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new PostMiddleware(['posts']));
        $this->registerMiddleware(new AuthMiddleware(['posts/edit']));
    }


    public function posts(Request $request)
    {
        $_SESSION['lastUri'] = $_SERVER["REQUEST_URI"];
        $currentPage = $_GET['page'] ?? 1;
        $max = count(Blog::all());
        $maxPages = ceil($max / 10);
        if (Application::isUser()) {
            $blogs = Blog::findUserLimit((($currentPage - 1) * 10), 10, Application::$app->user->id);
        } else {
            $blogs = Blog::findLimit((($currentPage - 1) * 10), 10);
        }
        $search = $_GET['search'];
        $blog = Blog::findSome(['title' => $search]);
        if (isset($search)) {

            if ($blog !== false && $request->isGet()) {
                $sMax = count($blog);
                $result = array_slice($blog, (($currentPage - 1) * 5), 5);
                $maxPages = ceil($sMax / 5);
                return $this->render('posts', [
                    'blog' => $result,
                    'search' => $search,
                    'max' => $sMax,
                    'maxPages' => $maxPages,
                    'currentPage' => $currentPage,
                ]);
            }
        } else {
            return $this->render('posts', [
                'blog' => $blogs,
                'max' => $max,
                'maxPages' => $maxPages,
                'currentPage' => $currentPage,
            ]);
        }
    }
}
