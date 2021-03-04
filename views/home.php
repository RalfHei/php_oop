<?php

use app\core\Application;

$admin = isset(Application::$app->user->rights) && Application::$app->user->rights == 'Admin';
$editor = isset(Application::$app->user->rights) && Application::$app->user->rights == 'Editor';
?>
<div class=" container mx-auto overflow-hidden">
    <div class="flex justify-center">
        <span class="text-3xl font-semibold text-gray-600 md:text-4xl mb-6"><?php echo $lang['latestPost'] ?></span>
    </div>
    <div class=" w-full lg:min-w-9/12 flex-justify-center">

        <?php if (!empty($latest->img_xl)) : ?>
            <a href="/blogpost?post=<?php echo $latest->id ?>">
                <div class="flex lg:min-w-9/12 flex-col items-center">
                    <div id="img" class="mb-4 md:mb-0 w-full max-w-screen-xl relative" style="height: 24em;">
                        <div class="absolute left-0 bottom-0 w-full z-10" style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div>
                        <img src="/images/<?php echo $latest->img_dir . "/" . $latest->img_xl ?>" class="absolute left-0 top-0 w-full h-full z-0 object-cover" />
                        <div class="p-4 absolute bottom-0 left-0 z-20">
                            <h2 class="text-4xl font-semibold text-gray-100 leading-tight"><?php echo $latest->title ?></h2>
                            <div class="flex mt-3">
                                <p class="font-semibold text-gray-400 text-xs"> <?php echo $latest->added ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        <?php else : ?>
            <div class="flex items-center w-full flex-col">
                <div class="lg:max-w-9/12 max-h-64 lg:w-9/12 w-11/12 px-10 my-4 py-6 bg-white rounded-lg shadow-md">
                    <div class="flex justify-between items-center">
                        <span class="font-light text-gray-600"><?php echo $latest->added ?> </span>
                    </div>
                    <div class="mt-2">
                        <p class="text-2xl text-gray-700 font-bold hover:text-gray-600"><?php echo $latest->title ?></p>
                        <p class="mt-2 truncate text-gray-600"><?php echo $latest->blogPost ?></p>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <a class="text-blue-600 hover:underline" href="/blogpost?post=<?php echo $latest->id ?>"><?php echo $lang['readMore'] ?></a>
                        <div>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
            <div class="flex justify-center">
                <span class="text-3xl my-6 font-semibold text-gray-600 md:text-4xl"><?php echo $lang['allPosts'] ?></span>
            </div>
            <div class="flex items-center w-full flex-col lg:min-w-9/12">


                <?php if (!empty($model)) : foreach ($model as $post) { ?>
                        <div class="lg:max-w-9/12 lg:min-w-9/12 max-h-64 lg:w-9/12 w-11/12 px-10 my-4 py-6 bg-white rounded-lg shadow-md">
                            <div class="flex justify-between items-center">
                                <span class="font-light text-gray-600"><?php echo $post['added'] ?> </span>
                                <?php
                                if ($admin || $editor || isset(Application::$app->user->id) && Application::$app->user->id === intval($post['added_by'])) : ?>
                                    <a class="px-2 py-1 bg-gray-600 text-gray-100 font-bold rounded hover:bg-gray-500" href="/editpost?post=<?php echo $post['id']; ?>"><?php echo $lang['editPost'] ?></a>
                                <?php endif ?>
                            </div>
                            <div class="mt-2">
                                <p class="text-2xl text-gray-700 font-bold"><?php echo $post['title'] ?></p>
                                <p class="mt-2 truncate text-gray-600"><?php echo $post['blogPost'] ?></p>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <a class="text-blue-600 hover:underline" href="/blogpost?post=<?php echo $post['id']; ?>"><?php echo $lang['readMore'] ?></a>
                                <div>
                                </div>
                            </div>
                        </div>
                <?php }
                endif; ?>
            </div>
            <div class="flex items-center justify-center">
                <ul class="flex list-reset border border-grey-light rounded w-auto font-sans">
                    <li class="">
                        <a class="<?php echo $currentPage == 1 ? 'pointer-events-none bg-gray-400' : 'pointer-events-auto bg-gray-700'; ?> block hover:bg-gray-600 text-white border-r border-grey-light px-3 py-2 " href="/?page=<?php echo $currentPage - 1; ?>"><?php echo $lang['previous'] ?></a>
                    </li>
                    <?php for ($i = 1; $i <= $maxPages; $i++) : ?>
                        <li><a class="hidden sm:block <?php echo $currentPage == $i ? 'bg-gray-600 text-white' : 'text-gray-700'; ?> bg-gray-300 hover:bg-gray-400  border-r border-grey-light px-3 py-2" href="/?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                    <li><a class="<?php echo $currentPage + 1 > $maxPages ? 'pointer-events-none bg-gray-400' : 'pointer-events-auto bg-gray-700'; ?> block  hover:bg-gray-600 text-white px-3 py-2" href="/?page=<?php echo $currentPage + 1; ?>"><?php echo $lang['next'] ?></a></li>
                </ul>
            </div>

            </div>