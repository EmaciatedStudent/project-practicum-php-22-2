<?php

require_once __DIR__ . '/vendor/autload.php';

use Tgu\Laperdina\User\User;
use Tgu\Laperdina\Comment\Comment;
use Tgu\Laperdina\Article\Article;

spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = str_replace('Class_', 'Class' . DIRECTORY_SEPARATOR, $file) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});