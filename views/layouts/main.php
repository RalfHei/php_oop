<?php

use app\core\Application;
use app\core\lang\Lang;

$lang = Application::$app->lang;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>PHP R</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
  <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://unpkg.com/@tailwindcss/custom-forms/dist/custom-forms.min.css" rel="stylesheet">


</head>

<body onload="hideLoadingDiv()" class="bg-gray-100">
  <nav class="flex items-center justify-between flex-wrap bg-gray-800 p-4 h-full">
    <div class="flex items-center flex-shrink-0 text-white mr-6">
      <span class="font-semibold text-xl tracking-tight text-indigo-200"><a href="/"><?php echo $lang['title'] ?></a></span>
    </div>
    <div>
      <form method="GET" action="/search" class="w-full">
        <div class="pt-2 relative mx-auto text-gray-600">
          <input class="border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none" type="search" name="search" placeholder="<?php echo $lang['search'] ?>">
          <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
              <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
            </svg>
          </button>
        </div>
      </form>
    </div>
    <div class="block lg:hidden">
      <button id="navBtn" onclick="navToggle();" class="flex items-center px-3 py-2 border rounded text-gray-300 border-gray-300 hover:text-white hover:border-white">
        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <title><?php echo $lang['menu'] ?></title>
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
      </button>
    </div>
    <div id="navMenu" class="hidden w-full block flex-grow lg:flex lg:items-center lg:w-auto">
      <div class="text-sm lg:flex-grow">
        <?php if (isset(Application::$app->user->rights) && Application::$app->user->rights == 'Admin') : ?>
          <a href="/admin" class="block mt-4 lg:inline-block lg:mt-0 mx-6 text-gray-200 hover:text-white">
            <?php echo $lang['adminPanel'] ?>
          </a>
        <?php endif ?>
        <?php if (!Application::isGuest()) : ?>
          <a href="/posts" class="block mt-4 lg:inline-block lg:mt-0 mx-6 text-gray-200 hover:text-white">
            <?php echo $lang['posts'] ?>
          </a>
          <a href="/newpost" class="block mt-4 lg:inline-block lg:mt-0 mx-6 text-gray-200 hover:text-white">
            <?php echo $lang['newPost'] ?>
          </a>
        <?php endif ?>
      </div>
      <div class="self-center font-semibold text-gray-300 px-4 mt-2 md:mt-0"><a href="<?php echo (new Lang)->changeLang() . "lang=et" ?>">ET </a>|<a href="<?php echo (new Lang)->changeLang() . "lang=en" ?>"> EN</a></div>
      <?php if (Application::isGuest()) : ?>
        <div>
          <a href="/login" class="inline-block text-sm px-4 py-2 leading-none border 
        rounded text-gray-300 border-gray-300 hover:border-gray-500 
        hover:text-gray-500 hover:bg-gray-800 mt-4 lg:mt-0"><?php echo $lang['login'] ?></a>
        </div>
      <?php else : ?>
        <div class="flex flex-row mt-6 md:mt-0 items-right">
          <p class="self-center font-semibold text-gray-500 px-4"><?php echo Application::$app->user->email ?></p>
          <a href="/logout" class="self-center inline-block text-sm px-4 py-2 leading-none border 
        rounded text-gray-300 border-gray-300 hover:border-gray-500 
        hover:text-gray-500 hover:bg-gray-800 md:mt-4 lg:mt-0"><?php echo $lang['logout'] ?></a>
        </div>
      <?php endif ?>
    </div>
  </nav>
  <div class="flex px-4 py-4 lg:mt-16 justify-center">
    <?php if (Application::$app->session->getFlash('success')) : ?>
      <div id="flash" class="absolute z-20 inset-x-auto bottom-0 mb-4 bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
        <div class="flex">
          <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
            </svg></div>
          <div>
            <p class="font-bold"><?php echo Application::$app->session->getFlash('success') ?></p>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if (Application::$app->session->getFlash('wrong')) : ?>
      <div id="flash" class="absolute inset-x-auto bottom-0 mb-4 bg-red-100 border-t-4 border-red-500 rounded-b text-red-700 px-4 py-3 shadow-md" role="alert">
        <div class="flex">
          <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
            </svg></div>
          <div>
            <p class="font-bold"><?php echo Application::$app->session->getFlash('wrong') ?></p>
          </div>
        </div>
      </div>
    <?php endif; ?>

    {{content}}
  </div>

  <script>
    function navToggle() {
      var btn = document.getElementById('navBtn')
      var nav = document.getElementById('navMenu')

      nav.classList.toggle('hidden')
    }

    function hideLoadingDiv() {
      if (document.getElementById('flash') !== null) {
        setTimeout(function() {
          document.getElementById('flash').classList.add('hidden');
        }, 2000)

      } else {
        return
      }
    }
  </script>

</body>

</html>