<div class="bg-white pb-4 px-4 rounded-md w-full max-w-screen-xl">
    <div class="flex justify-between w-full pt-6 ">
        <p class="ml-3 font-bold text-gray-700 text-lg"><?php echo $lang['allPosts'] ?></p>

    </div>
    <div class="grid lg:grid-cols-8 w-full">
        <div class="col-span-2">
            <form method="GET" action="/posts" class="">
                <div class="relative mx-auto text-gray-600">
                    <input class="border-2 w-full border-gray-300 bg-white h-10 px-5 pr-4 rounded-lg text-sm focus:outline-none" type="search" name="search" placeholder="<?php echo $lang['search'] ?>">
                    <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                        <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <div class="flex justify-center">
            <a class="flex items-center justify-center font-bold 
    text-sm text-indigo-500 hover:text-indigo-300" href="/posts"><?php echo $lang['clear'] ?></a>
        </div>
    </div>
    <div class="overflow-x-auto mt-6">
        <form action="" method="post">
            <table class="table-auto border-collapse w-full">
                <thead>
                    <tr class="rounded-lg text-sm font-medium text-gray-700 text-left">
                        <th class="px-4 py-2 bg-indigo-200"><?php echo $lang['postTitle'] ?></th>
                        <th class="hidden md:table-cell px-4 py-2 bg-indigo-200"><?php echo $lang['tableAdded'] ?></th>
                        <th class="hidden md:table-cell px-4 py-2 bg-indigo-200"><?php echo $lang['tableAdded'] ?></th>
                        <th class="hidden md:table-cell px-4 py-2 bg-indigo-200"><?php echo $lang['tableEdited'] ?></th>
                        <th class="px-4 py-2 bg-indigo-200"><?php echo $lang['tableAction'] ?></th>
                    </tr>
                </thead>

                <tbody class="text-md font-normal text-gray-700">
                    <?php
                    if (!empty($blog)) : foreach ($blog as $post) { ?>
                            <tr class="hover:bg-gray-100 border-b border-gray-200 py-10">
                                <td class="px-4 py-2 " value="<?php echo $post['title'] ?>" id="inline-full-name" type="text" name="email"><?php echo $post['title'] ?></td>
                                <td class="px-4 py-2 hidden md:table-cell">
                                    <?php if (!empty($post['img_sm'])) : ?>
                                        <img src="/images/<?php echo $post['img_dir'] . "/" . $post['img_sm'] ?>" class=" h-12 z-0 object-cover" />
                                    <?php else : ?>
                                        <?php echo $lang['noImg'] ?>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2 hidden md:table-cell"><?php echo $post['added']; ?></td>
                                <td class="hidden md:table-cell px-4 py-2 "><?php echo $post['edited']; ?></td>
                                <td class="px-4 py-2 text-indigo-500 font-semibold "><a href="editpost?post=<?php echo $post['id']; ?>"><?php echo $lang['editPost'] ?></a><a class="pl-4" href="deletepost?post=<?php echo $post['id']; ?>"><?php echo $lang['delete'] ?></a></td>
                                </td>

                            </tr>
                    <?php }
                    endif; ?>
                </tbody>
            </table>
        </form>
        <tfoot>
            <div class="bg-white px-4 py-3 flex items-center justify-center border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-center">
                    <?php if (!empty($search) && $maxPages > 1) : ?>
                        <a href="?search=<?php echo $search ?>&page=<?php echo $currentPage - 1; ?>" class="<?php echo $currentPage == 1 ? 'pointer-events-none bg-gray-100' : 'pointer-events-auto'; ?>relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                            <?php echo $lang['previous'] ?> </a>
                    <?php else : ?>
                        <a href="?page=<?php echo $currentPage - 1; ?>" class="<?php echo $currentPage == 1 ? 'pointer-events-none bg-gray-100' : 'pointer-events-auto'; ?>relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                            <?php echo $lang['previous'] ?> </a>
                    <?php endif; ?>
                    <?php if (!empty($search) && $maxPages > 1) : ?>
                        <?php for ($i = 1; $i <= $maxPages; $i++) : ?>
                            <div><a class="hidden <?php echo $currentPage == $i ? 'bg-gray-300' : ''; ?> sm:flex hover:text-indigo-700 hover:bg-gray-100 border-r border-grey-light px-3 py-2" href="?search=<?php echo $search ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></div>
                        <?php endfor; ?>
                    <?php else : ?>
                        <?php for ($i = 1; $i <= $maxPages; $i++) : ?>
                            <div><a class="hidden sm:flex  <?php echo $currentPage == $i ? 'bg-gray-300' : ''; ?> hover:text-indigo-700 hover:bg-gray-100 text-blue border-r border-grey-light px-3 py-2" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></div>
                        <?php endfor; ?>
                    <?php endif; ?>
                    <?php if (!empty($search) && $maxPages > 1) : ?>
                        <a href="?search=<?php echo $search ?>&page=<?php echo $currentPage + 1; ?>" class="<?php echo $currentPage + 1 > $maxPages ? 'pointer-events-none bg-gray-100' : 'pointer-events-auto'; ?>
                        relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                            <?php echo $lang['next'] ?> </a>
                    <?php else : ?>
                        <a href="?page=<?php echo $currentPage + 1; ?>" class="<?php echo $currentPage + 1 > $maxPages ? 'pointer-events-none bg-gray-100' : 'pointer-events-auto'; ?>
                        relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">
                            <?php echo $lang['next'] ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </tfoot>
    </div>

</div>