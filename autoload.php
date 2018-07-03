<?php
spl_autoload_register(function ($classname) {
    $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    
    if (strstr($classname, "\\Bandzaai\\Threading\\") === 0) {
        $file = $dir . basename(str_replace('\\', '/', $classname)) . '.php';
        
        if (file_exists($file)) {
            require $file;
        }
    }
});