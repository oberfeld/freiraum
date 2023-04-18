<?php

/**
 * Router script for development (When mod_rewrite is not available)
 * 
 * Routes all requests to the root index.php file,
 * except for files that exist in the public directory.
 * 
 * Usage: php -S localhost:8000 -t public bin/router.php
 *
 * @link http://stackoverflow.com/a/38926070/6260
 */
chdir(__DIR__ . '/../public');
$www = getcwd();
$filePath = explode('?', $_SERVER["REQUEST_URI"])[0];
$filePath = str_replace('%20', ' ', $filePath);
$filePath = realpath(ltrim($filePath, '/'));

if ($filePath && is_file($filePath)) {
    // 1. check that file is not outside of this directory for security
    // 2. check for circular reference to router.php
    // 3. don't serve dotfiles
    if (
        strpos($filePath, $www . DIRECTORY_SEPARATOR) === 0 &&
        $filePath != __DIR__ . DIRECTORY_SEPARATOR . 'router.php' &&
        substr(basename($filePath), 0, 1) != '.'
    ) {
        if (strtolower(substr($filePath, -4)) == '.php') {
            // php file; serve through interpreter
            include $filePath;
        } else {
            // asset file; serve from filesystem
            return false;
        }
    } else {
        // disallowed file
        header("HTTP/1.1 404 Not Found");
        echo "404 Not Found";
    }
} else {
    // rewrite to our index file
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    include 'index.php';
}
