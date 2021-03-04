<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Blog;

class SiteController extends Controller
{
    public function search(Request $request, Response $response)
    {
        $lang = Application::$app->lang;
        $uri = $_SESSION['lastUri'];
        $search = $_GET['search'];
        $currentPage = $_GET['page'] ?? 1;
        $result = Blog::findSome(['title' => $search]);
        $maxPages = ceil(count($result) / 5);
        $posts = array_slice($result, (($currentPage - 1) * 5), 5);
        if ($posts !== false && $request->isGet() && strlen($search) >= 2) {

            return $this->render('search', [
                'model' => $posts,
                'count' => count($result),
                'search' => $search,
                'maxPages' => $maxPages,
                'currentPage' => $currentPage,
            ]);
        } else {
            Application::$app->session->setFlash('wrong', $lang['tooShort']);
            return $response->redirect($uri);
        }
    }
    public function blog()
    {
        $_SESSION['lastUri'] = $_SERVER["REQUEST_URI"];
        $currentPage = $_GET['page'] ?? 1;
        $posts = Blog::findLimit((($currentPage - 1) * 5), 5);
        $latest = Blog::findLatest();
        $max = count(Blog::all());
        $maxPages = ceil($max / 5);
        return $this->render('home', [
            'model' => $posts,
            'latest' => $latest,
            'maxPages' => $maxPages,
            'currentPage' => $currentPage,
        ]);
    }
    public function image()
    {
        $post = Blog::findOne(['id' => $_GET['image']]);
        return $this->render('xlimage', [
            'model' => $post
        ]);
    }

    public function blogPost()
    {
        $post = Blog::findOne(['id' => $_GET['post']]);
        if ($post !== false) {
            return $this->render('blogpost', [
                'model' => $post
            ]);
        } else {
            return $this->render("_001");
        }
    }
}
