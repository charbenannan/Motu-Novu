<?php 

spl_autoload_register(function ($class) {
    $baseNamespace = 'classes\\';

    if (strpos($class, $baseNamespace) === 0) {
        $classWithoutNamespace = substr($class, strlen($baseNamespace));

        $baseDirectory = __DIR__ . '/classes/';

        $classFilePath = str_replace('\\', '/', $classWithoutNamespace) . '.php';

        $classFile = $baseDirectory . $classFilePath;

        if (file_exists($classFile)) {
            include $classFile;
        }
    }
});



?>