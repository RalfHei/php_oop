<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\middlewares\PostMiddleware;
use app\models\Blog;
use app\models\Image;

class BlogController extends Controller
{


    public function __construct()
    {
        $this->registerMiddleware(new PostMiddleware(['newPost']));
        $this->registerMiddleware(new PostMiddleware(['edit']));
    }

    public function newPost(Request $request, Response $response)
    {
        $lang = Application::$app->lang;
        $blogpost = new blog();
        $img = new Image();
        if ($request->isPost()) {
            $blogpost->loadData($request->getBody());
            $blogpost->added_by = Application::$app->user->id;
            $filename = $_FILES["img_file"]["name"];
            if ($blogpost->validate()) {
                if (!empty($filename)) {
                    $img->imgSize($blogpost, $img);
                }
                if ($blogpost->save()) {
                    Application::$app->session->setFlash('success', $lang['flashBlogAdded']);
                    $response->redirect('/');
                }
            }
            return $this->render('newpost', [
                'model' => $blogpost
            ]);
        }
        return $this->render('newpost', [
            'model' => $blogpost
        ]);
    }

    public function edit(Request $request, Response $response)
    {
        $lang = Application::$app->lang;
        $key = Application::$app->user->id;
        $hasRights = Application::$app->user->rights;
        $posts = Blog::findOne(['id' => $_GET['post']]);
        $id = $posts->added_by;
        if (($key === $id) || isset($hasRights) && $hasRights !== 'User') {
            return $this->render("editpost", [
                'model' => $posts
            ]);
        } else {
            Application::$app->session->setFlash('wrong', $lang['flashWrong']);
            return $response->redirect('/');
        }
    }

    public function update(Request $request, Response $response)
    {
        $lang = Application::$app->lang;
        $uri = $_SESSION['lastUri'];
        $id = $_GET['id'];
        $oldPost = Blog::findOne(['id' => $_GET['id']]);
        $dirPath = Application::$ROOT_DIR . "/public/images/" . $oldPost->img_dir;
        $img = new Image;
        $post = new Blog;

        if ($request->isPost()) {
            $body = $request->getBody();
            $post->loadData($body);
            $post->edited_by = Application::$app->user->id;
            if (!empty($_FILES["img_file"]['name'])) {
                if (!empty($oldPost->img_dir)) {
                    if (file_exists($dirPath)) {
                        (new Image)->remove($dirPath);
                    }
                }
                $img->imgSize($post, $img);
            }
            if ($post->validate() && $post->update($id, (array)$post)) {
                Application::$app->session->setFlash('success', $lang['flashBlogEdited']);
                return $response->redirect($uri);
            } else {
                return $this->render("editpost", [
                    'model' => $post
                ]);
            }
        }
    }

    public function destroy(Request $request, Response $response)
    {
        $lang = Application::$app->lang;
        $uri = $_SESSION['lastUri'];
        $post = Blog::findOne(['id' => $_GET['post']]);
        $id = $post->added_by;
        $key = Application::$app->user->id;
        $hasRights = Application::$app->user->rights;
        $dirPath = Application::$ROOT_DIR . "/public/images/" . $post->img_dir;


        if (($key === $id) || isset($hasRights) && $hasRights !== 'User') {
            $post->deleteOne($post->id);
            if (!empty($post->img_dir)) {
                (new Image)->remove($dirPath);
            }
            Application::$app->session->setFlash('success', $lang['flashBlogDeleted']);
            return $response->redirect($uri);
        } else {
            Application::$app->session->setFlash('wrong', $lang['flashBlogWrong']);
            return $response->redirect($uri);
        }
    }
}
