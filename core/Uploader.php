<?php

namespace App\Core;

/**
 * Class Uploader
 * @package App\Core
 */
class Uploader
{
    /* Const used to manage errors in file upload method. */
    const FILE_SAVED = 0;
    const ERROR_FILE_HEAVY = 1;
    const FILE_UPLOAD_ERROR = 2;
    const FILE_RESIZE_ERROR = 3;

    /**
     * Rename image for prevents duplicates.
     * New name is made up of current date and hash.
     * @return string
     */
    public function getFileName()
    {
        $currentDate = date('Ymdhis');
        $hash = Hash::generate(10);
        $filename = $currentDate.$hash;
        return $filename;
    }

    /**
     * Get upload file's extension.
     * @param $file
     * @return mixed
     */
    public function getFileExtension($file)
    {
        $fileInfo = pathinfo($file['name']);
        $extension = $fileInfo['extension'];
        return $extension;
    }

    /**
     * Here's a list of allowed extensions.
     * @return array
     */
    public function getExtensionAllowed()
    {
        $extension_allowed = array('jpg', 'jpeg', 'png');
        return $extension_allowed;
    }

    /**
     * Upload a file and save it in a directory chosen by user.
     * @param $file
     * @param $newFileName
     * @param $path
     * @param $targetWidth
     * @param $targetHeight
     * @return int
     */
    public function upload($file, $newFileName, $path, $targetWidth, $targetHeight)
    {
        if (isset($file) AND $file['error'] == 0)
        {
            if ($file['size'] <= 8000000)
            {
                if (in_array($this->getFileExtension($file), $this->getExtensionAllowed()))
                {
                    move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path.basename($newFileName.'.'.$this->getFileExtension($file)));
                    $this->resize($file, $newFileName, $path, $targetWidth, $targetHeight);
                    return self::FILE_SAVED;
                }
            } else {
                return self::ERROR_FILE_HEAVY;
            }
        } else {
            return self::FILE_UPLOAD_ERROR;
        }
    }

    /**
     * Resize a file.
     * @param $file
     * @param $newFileName
     * @param $path
     * @param $targetWidth
     * @param $targetHeight
     * @return int
     */
    public function resize($file, $newFileName, $path, $targetWidth, $targetHeight)
    {
        $sourceProperties = getimagesize($_SERVER['DOCUMENT_ROOT'].$path.$newFileName.'.'.$this->getFileExtension($file));
        $imageType = $sourceProperties[2];
        switch ($imageType)
        {
            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].$path.$newFileName.'.'.$this->getFileExtension($file));
                $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                imagepng($targetLayer, $_SERVER['DOCUMENT_ROOT'].$path.basename($newFileName.'.'.$this->getFileExtension($file)));
                break;
            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($_SERVER['DOCUMENT_ROOT'].$path.$newFileName.'.'.$this->getFileExtension($file));
                $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                imagegif($targetLayer, $_SERVER['DOCUMENT_ROOT'].$path.basename($newFileName.'.'.$this->getFileExtension($file)));
                break;
            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$path.$newFileName.'.'.$this->getFileExtension($file));
                $targetLayer = $this->imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1], $targetWidth, $targetHeight);
                imagejpeg($targetLayer, $_SERVER['DOCUMENT_ROOT'].$path.basename($newFileName.'.'.$this->getFileExtension($file)));
                break;
            default:
                return self::FILE_RESIZE_ERROR;
                break;
        }
    }

    /**
     * Build the new resized image.
     * @param $imageResourceId
     * @param $width
     * @param $height
     * @param $targetWidth
     * @param $targetHeight
     * @return resource
     */
    public function imageResize($imageResourceId, $width, $height, $targetWidth, $targetHeight)
    {
        $targetLayer = imagecreatetruecolor($targetWidth,$targetHeight);
        imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        return $targetLayer;
    }
}