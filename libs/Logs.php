<?php

/**
 * This class is part of Uploader package.
 * This class is used to write a log in a text file when an error occurred.
 * It can be reused for other projects.
 *
 * Author : Argan Piquet
 */

namespace Gwereve\Libs;

require_once($_SERVER['DOCUMENT_ROOT'].'/uploader/vendor/autoload.php');

/**
 * Class Logs
 * @package App\Libs
 */
class Logs
{
    /**
     * Logfile path.
     * @return string
     */
    public function path()
    {
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploader/logs/';
        return $path;
    }

    /**
     * Initialize logfile name.
     * @param $file
     * @return bool|resource
     */
    public function filename($file)
    {
        $path = $this->path();
        $filename = $path.$file.'.txt';
        $logfile = fopen($filename, 'a+');
        return $logfile;
    }

    /**
     * Initialize message format.
     * @param $message
     * @param $exception
     * @return string
     */
    public function message($message, $exception)
    {
        $message = 'Message : '.$message.' Exception : '.$exception.PHP_EOL;
        return $message;
    }

    /**
     * Write a log in a text file.
     * @param $message
     * @param $exception
     */
    public function write($message, $exception)
    {
        $logfile = $this->filename('logfile');
        fwrite($logfile, $this->message($message, $exception));
        fclose($logfile);
    }
}