<?php

namespace app;

class UploadedFile
{
    const STATUS_SUCCESS = 0;

    private $file;
    private $defaultWidth = 320;
    private $defaultHeight = 240;

    public $uploadsPath = 'web/images';
    public $allowExtensions = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

    public function hasFiles()
    {
        if ($_FILES) {

            return true;
        }

        return false;
    }

    public function upload($folder, $subFolder = null)
    {
        if (!$this->hasFiles() || !$folder) {
            return false;
        }
        if ($subFolder) {
            $folder .= '/' . $subFolder;
        }

        foreach ($_FILES as $name => $file) {
            if ($file['error'] === self::STATUS_SUCCESS) {
                if (in_array(strtolower($file['type']), $this->allowExtensions)) {

                    if (!file_exists($this->uploadsPath . '/' . $folder)) {
                        mkdir($this->uploadsPath . '/' . $folder, 0777, true);
                    }
                    $newFile = "{$this->uploadsPath}/{$folder}/{$file['name']}";

                    $this->createNewImage($file['tmp_name'], $newFile);

                    return $newFile;
                }
            }
        }
        return null;
    }

    public function createNewImage($tmpFile, $newFile, $quality = 80)
    {
        $type = pathinfo($newFile, PATHINFO_EXTENSION);

        switch ($type) {
            case 'jpeg':
            case 'jpg': {
                $this->file = imagecreatefromjpeg($tmpFile);
                $this->resize($this->defaultWidth, $this->defaultHeight);
                $result = imagejpeg($this->file, $newFile, $quality);
                break;
            }
            case 'png': {
                $this->file = imagecreatefrompng($tmpFile);
                $this->resize($this->defaultWidth, $this->defaultHeight);
                imagesavealpha($this->file, true);
                $quality = (int)(100 - $quality) / 10 - 1;

                $result = imagepng($this->file, $newFile, $quality);

                break;

            }
            case 'gif': {
                $this->file = imagecreatefromgif($tmpFile);
                $this->resize($this->defaultWidth, $this->defaultHeight);
                $result = imagegif($this->file, $newFile);
                break;
            }

            default:
                return false;
        }

        imagedestroy($this->file);

        return $result;
    }

    public function checkSize()
    {
        if ($this->getWidth() < $this->defaultWidth && $this->getHeight() < $this->defaultHeight) {
            return true;
        }

        return false;
    }

    public function getWidth()
    {
        return imagesx($this->file);
    }

    public function getHeight()
    {
        return imagesy($this->file);
    }

    private function resize($width, $height)
    {
        $newImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($newImage, $this->file, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());

        return $this->file = $newImage;
    }
}