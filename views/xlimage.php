<div>
    <button onclick="onClick()" class=" focus:outline-none text-indigo-400 w-32 font-bold py-2 mb-8 px-4"><?php echo $lang['back'] ?></button>
    <img src="/images/<?php echo $model->img_dir . "/" . $model->img_xl ?>" alt="">
</div>


<script>
    function onClick() {
        this.history.go(-1);
    }
</script>