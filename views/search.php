<div class="flex flex-col items-center lg:mx-10 overflow-hidden">
    <div class="flex justify-center w-full lg:w-screen">
        <h1 class="md:text-3xl text-2xl font-semibold text-gray-600 md:text-4xl mb-6"><?php echo $lang['searchResOne'] ?> <?php echo $count ?> <?php echo $lang['searchResTwo'] ?>
            <span class="text-indigo-400"><?php echo $search ?></span>
        </h1>
    </div>
    <?php if (!empty($model)) : foreach ($model as $post) { ?>
            <?php if (!empty($post['img_md'])) : ?>
                <div>
                    <div class="w-full bg-gray-100 lg:py-12 lg:flex lg:justify-center">
                        <div class="bg-white lg:mx-8 lg:flex lg:max-w-5xl w-screen min-w-9/12 lg:shadow-lg lg:rounded-lg">
                            <div class="lg:w-1/2">
                                <div class="bg-cover lg:rounded-lg h-72" style="background-image:url('/images/<?php echo $post['img_dir'] . "/" . $post['img_sm'] ?>')"></div>
                            </div>
                            <div class="py-12 px-6 max-w-xl lg:max-w-5xl lg:w-1/2">
                                <h2 class="text-3xl text-gray-800 font-bold"><?php echo $post['title'] ?></h2>
                                <p class="mt-4 h-20 truncate text-gray-600"><?php echo $post['blogPost'] ?></p>
                                <div class="mt-8">
                                    <a href="/blogpost?post=<?php echo $post['id']; ?>" class="bg-gray-900 text-gray-100 px-5 py-3 font-semibold rounded"><?php echo $lang['readMore'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="flex items-center w-full flex-col">
                    <div></div>
                    <div class="max-w-screen-lg max-h-64 lg:w-10/12 w-screen px-10 my-4 py-6 bg-white rounded-lg shadow-md">
                        <div class="flex justify-between items-center">
                            <span class="font-light text-gray-600"><?php echo $post['added'] ?> </span>
                        </div>
                        <div class="mt-2">
                            <a class="text-2xl text-gray-700 font-bold hover:text-gray-600" href="#"><?php echo $post['title'] ?></a>
                            <p class="mt-2 truncate text-gray-600"><?php echo $post['blogPost'] ?></p>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <a class="text-blue-600 hover:underline" href="/blogpost?post=<?php echo $post['id']; ?>"><?php echo $lang['readMore'] ?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
    <?php }
    endif; ?>
    <ul class="flex list-reset border border-grey-light rounded w-auto font-sans">
        <li class="">
            <a class="<?php echo $currentPage == 1 ? 'pointer-events-none bg-gray-400' : 'pointer-events-auto bg-gray-700'; ?> block hover:bg-gray-600 text-white border-r border-grey-light px-3 py-2 " href="?search=<?php echo $search ?>&page=<?php echo $currentPage - 1; ?>"><?php echo $lang['previous'] ?></a>
        </li>
        <?php for ($i = 1; $i <= $maxPages; $i++) : ?>
            <li><a class="hidden sm:block <?php echo $currentPage == $i ? 'bg-gray-600 text-white' : 'text-gray-700'; ?> bg-gray-300 hover:bg-gray-400  border-r border-grey-light px-3 py-2" href="?search=<?php echo $search ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <li><a class="<?php echo $currentPage + 1 > $maxPages ? 'pointer-events-none bg-gray-400' : 'pointer-events-auto bg-gray-700'; ?> block  hover:bg-gray-600 text-white px-3 py-2" href="?search=<?php echo $search ?>&page=<?php echo $currentPage + 1; ?>"><?php echo $lang['next'] ?></a></li>
    </ul>
</div>