<form action="" method="post" enctype="multipart/form-data">
    <div class="max-w-2xl bg-white py-10 px-5 m-auto w-full mt-10">

        <div class="text-3xl mb-6 text-center ">
            <?php echo $lang['postNew'] ?>
        </div>

        <div class="grid grid-cols-2 gap-4 max-w-xl m-auto">

            <div class="col-span-2 lg:col-span-1">
                <label class="block text-gray-500 font-bold mb-1 md:mb-0 pl-4" for="inline-full-name">
                    <?php echo $lang['postTitle'] ?>
                </label>
                <input type="text" value="<?php echo $model->title ?>" name="title" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight
            focus:outline-none focus:bg-white focus:border-indigo-200 md:text-xl w-full" placeholder="Title" />
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError('title') ?></p>
            </div>

            <div class="col-span-2">
                <textarea value="<?php echo $model->blogPost ?>" name="blogPost" cols="30" rows="8" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-200 w-full" placeholder="<?php echo $lang['postText'] ?>"></textarea>
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError('blogPost') ?></p>
            </div>

            <div class="col-span-2 lg:col-span-2">
                <label class="block text-gray-500 font-bold mb-1 md:mb-0 pl-4" for="img_url">
                    <?php echo $lang['postImg'] ?>
                </label>
                <input value="<?php echo $model->img_xl ?>" type="file" name="img_file">
                <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError('img_xl') ?></p>
            </div>
            <div class="col-span-2 text-right">
                <a class="text-indigo-400 w-32 font-bold py-2 px-4" href="/"><?php echo $lang['back'] ?></a>
                <button class="w-32 shadow bg-indigo-400 hover:bg-indigo-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                    <?php echo $lang['submit'] ?>
                </button>
            </div>

        </div>
    </div>
</form>