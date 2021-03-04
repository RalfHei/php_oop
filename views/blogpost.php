<?php

use app\core\Application;

if (!empty($model->img_xl)) : ?>
    <div class=" w-screen lg:w-7/12 mx-auto flex flex-col lg:px-10 px-2 my-4 py-6 bg-white rounded-lg shadow-md">
        <a href="/blogpost/img?image=<?php echo $model->id ?>">
            <div class="mb-4 md:mb-0 w-full max-w-screen-lg mx-auto relative" style="height: 24em;">
                <div class="absolute left-0 bottom-0 w-full h-full z-10" style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div>
                <img src="/images/<?php echo $model->img_dir . "/" . $model->img_xl ?>" class="absolute left-0 top-0 w-full h-full z-0 object-cover" />
                <div class="p-4 absolute bottom-0 left-0 z-20">
                    <h2 class="text-4xl font-semibold text-gray-100 leading-tight"><?php echo $model->title ?></h2>
                    <div class="flex mt-3">
                        <p class="font-semibold text-gray-400 text-xs"> <?php echo $model->added ?> </p>
                    </div>
                </div>
            </div>
        </a>

        <div class="px-4 lg:px-0 mt-12 text-gray-700 max-w-screen-md mx-auto text-lg leading-relaxed">
            <p class="pb-6"><?php echo $model->blogPost ?></p>
        </div>
        <button onclick="onClick()" class=" focus:outline-none w-20 text-indigo-400 font-bold py-2 px-4"><?php echo $lang['back'] ?></button>
    </div>
<?php else : ?>
    <div class="lg:max-w-9/12 lg:max-h-80 lg:w-9/12 w-11/12 px-10 my-4 py-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <span class="font-light text-gray-600"><?php echo $model->added ?> </span>
        </div>
        <div class="mt-2">
            <p class="text-2xl text-gray-700 font-bold hover:text-gray-600"><?php echo $model->title ?></p>
            <p class="mt-2 text-gray-600"><?php echo $model->blogPost ?></p>
        </div>
    </div>
<?php endif; ?>

<script>
    function onClick() {
        this.history.go(-1);
    }
</script>