<?php

namespace App\Libs;

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
        $path = '/uploader/logs/';
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
        $logfile = fopen($filename, 'w');
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