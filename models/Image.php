<?php

namespace app\models;

use app\core\Application;

class Image
{
    public string $imgName = '';
    public string $img_dir = '';

    function resize($width, $tempname, $filename, $type, $dirName)
    {
        list($w, $h) = getimagesize($tempname);
        $height = ceil($h * ($width / $w));
        $ratio = max($width / $w, $height / $h);
        $h = ceil($height / $ratio);
        $x = ($w - $width / $ratio) / 2;
        $w = ceil($width / $ratio);
        $path = Application::$ROOT_DIR . "/public/images/" . $dirName . "/" . $width . 'x' . $height . '_' . $filename;
        $this->img_dir = $dirName;
        $this->imgName = $width . 'x' . $height . '_' . $filename;
        $imgString = file_get_contents($tempname);
        /* create image from string */
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($width, $height);
        imagecopyresampled(
            $tmp,
            $image,
            0,
            0,
            $x,
            0,
            $width,
            $height,
            $w,
            $h
        );
        switch ($type) {
            case 'image/jpeg':
                imagejpeg($tmp, $path, 100);
                break;
            case 'image/png':
                imagepng($tmp, $path, 0);
                break;
            case 'image/gif':
                imagegif($tmp, $path);
                break;
        }
        return $path;
        imagedestroy($image);
        imagedestroy($tmp);
    }

    public function imgSize($blogpost, $img)
    {
        $tempname = $_FILES["img_file"]["tmp_name"];
        $filename = $_FILES["img_file"]["name"];
        $type = $_FILES["img_file"]["type"];
        $dirName = uniqid();
        $dirPath = Application::$ROOT_DIR . "/public/images/" . $dirName;
        if (!file_exists($dirPath)) {
            mkdir($dirPath);
            $blogpost->img_dir = $dirName;
            if ($img->resize(75, $tempname, $filename, $type, $dirName)) {
                $blogpost->img_md = $img->imgName;
            }
            if ($img->resize(500, $tempname, $filename, $type, $dirName)) {
                $blogpost->img_sm = $img->imgName;
            }
            if ($img->resize(1000, $tempname, $filename, $type, $dirName)) {
                $blogpost->img_xl = $img->imgName;
            }
        }
    }

    public function remove($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                        $this->remove($dir . DIRECTORY_SEPARATOR . $object);
                    else
                        unlink($dir . DIRECTORY_SEPARATOR . $object);
                }
            }
            rmdir($dir);
        }
    }
}
