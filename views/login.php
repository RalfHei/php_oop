<form action="" method="post" class="w-full max-w-sm lg:rounded lg:bg-white lg:overflow-hidden lg:shadow-lg p-4">
  <div class="form-group">
    <h1 class="font-semibold text-2xl tracking-tight text-gray-700 pb-6 lg:px-4"><?php echo $lang['login'] ?></h1>
    <div class="md:flex items-center md:justify-center mb-6">
      <div class="md:w-3/12">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
          Email
        </label>
      </div>
      <div class="md:w-2/3">
        <input value="<?php echo $model->email ?>" class="form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-200" id="inline-full-name" type="text" name="email">
        <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError('email') ?></p>
      </div>
    </div>
    <div class="md:flex md:items-center md:justify-center mb-6">
      <div class="md:w-3/12">
        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-password">
          <?php echo $lang['password'] ?>
        </label>
      </div>
      <div class="md:w-2/3">
        <input value="<?php echo $model->password ?>" class="form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-200" id="inline-password" type="password" name="password" placeholder="******************">
        <p class="text-red-500 text-xs italic"><?php echo $model->getFirstError('password') ?></p>
      </div>

    </div>

    <div class="w-full md:flex md:items-center md:justify-center mb-6 mt-8">
      <button class="w-32 shadow bg-indigo-400 hover:bg-indigo-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
        <?php echo $lang['login'] ?>
      </button>
    </div>
    <div class="w-full md:flex md:items-center md:justify-center mb-6">
      <h3 class="text-gray-500 mr-2">
        <?php echo $lang['noAccountText'] ?>
      </h3>
      <a class="inline-block align-baseline font-bold 
    text-sm text-indigo-500 hover:text-indigo-300" href="/register">
        <?php echo $lang['register'] ?>
      </a>
    </div>
  </div>
</form>