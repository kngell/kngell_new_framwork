<?php

class ImageManager
{
    public $sourcePath;
    public $destinationPath;

    public function __construct($source = '', $destination = '')
    {
        $this->sourcePath = $source != '' ? $source : $this->sourcePath;
        $this->destinationPath = $destination != '' ? $destination : $this->destinationPath;
    }

    //=======================================================================
    //Images infos
    //=======================================================================
    public function get_imagesInfos($img_file = '')
    {
        $img = isset($this->sourcePath) ? $this->sourcePath . $img_file : $img_file;
        if (exif_imagetype($img)) {
            return getimagesize($img);
        }
        return false;
    }

    //=======================================================================
    //Image resize
    //=======================================================================
    public function resizeImage($img_infos = [], $img = '', $dest_w = '', $dest_h = '')
    {
        if (isset($img_infos)) {
            $width = $dest_w ? $dest_w : $img_infos[0];
            $height = $dest_h ? $dest_h : $img_infos[1];
            $newImg = imagecreatetruecolor($width, $height);
            switch ($img_infos['mime']) {
                case 'image/png':
                    $sourceImg = imagecreatefrompng($this->sourcePath . $img);
                    break;
                case 'image/jpeg':
                    $sourceImg = imagecreatefromjpeg($this->sourcePath . $img);
                    break;
                case 'image/gif':
                    $sourceImg = imagecreatefromgif($this->sourcePath . $img);
                    break;
                default:
                    return false;
                    break;
            }
            imagecopyresampled($newImg, $sourceImg, 0, 0, 0, 0, $width, $height, $img_infos[0], $img_infos[1]);
            $this->destroyImage($sourceImg);
            return $newImg;
        }
        return false;
    }

    //=======================================================================
    //Image Save
    //=======================================================================
    public function saveImage($img_infos = [], $newImg = null, $img = false)
    {
        $black = imagecolorallocate($newImg, 0, 0, 0);
        imagecolortransparent($newImg, $black);
        if (isset($img_infos) && isset($img)) {
            switch ($img_infos['mime']) {
                case 'image/png':
                    imagepng($newImg, $this->destinationPath . $img);
                    return imagedestroy($newImg);
                    break;
                case 'image/jpeg':
                    return imagejpeg($newImg, $this->destinationPath . $img);
                    break;
                case 'image/gif':
                    return imagegif($newImg, $this->destinationPath . $img);
                    break;
                default:
                    return false;
                    break;
            }
        }
        return false;
    }

    //=======================================================================
    //Image Destroy
    //=======================================================================
    public function destroyImage($img = null)
    {
        if (isset($img)) {
            imagedestroy($img);
        }
        return true;
    }

    //=======================================================================
    //Get Assets
    //=======================================================================
    public static function asset_img($img = '')
    {
        return ASSET_SERVICE_PROVIDER ? ASSET_SERVICE_PROVIDER . US . IMG . $img : IMG . $img;
    }
}
