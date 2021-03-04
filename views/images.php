<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        Select Image File to Upload:
        <input value="<?php echo $model->file_name ?>" type="file" name="file_name">
        <button class="w-32 shadow bg-indigo-400 hover:bg-indigo-300 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
            <?php echo $lang['submit'] ?>
        </button>
    </div>
</form>