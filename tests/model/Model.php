<?php

namespace App\Tests;

require_once('../../core/Uploader.php');
require_once('../../libs/Logs.php');

use App\Core\Uploader;
use App\Libs\Logs;

class Model
{
    public function uploadFile()
    {
        try {
            $uploader = new Uploader();
            $filename = $uploader->getFileName();
            $ext = $uploader->getFileExtension($_FILES['myFile']);
            $uploaded = $uploader->upload($_FILES['myFile'], $filename, '/uploader/tests/images/', 200, 200);
        } catch (\Exception $e) {
            $logs = new Logs();
            $logs->write('An error occured during file upload.', $e);
        }

        switch ($uploaded)
        {
            case $uploader::FILE_SAVED:
                // Success
                // Do something...
                echo 'Image successfully uploaded';
                break;
            case $uploader::ERROR_FILE_HEAVY:
                // File heavy
                echo 'Your file is heavy.';
                break;
            case $uploader::FILE_UPLOAD_ERROR:
                // An error occurred during file upload
                echo 'An error occurred.. Please, try again';
                break;
            case $uploader::FILE_RESIZE_ERROR:
                // An error occured during file resizing.
                echo 'An error occurred.. Please, try again';
                break;
        }
    }
}

$m = new Model();
$m->uploadFile();
//header('Location:/uploader/tests/index.html');
