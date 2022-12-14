<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitea2dbc7ee8514db8e787bb133f7d4b09
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitea2dbc7ee8514db8e787bb133f7d4b09', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitea2dbc7ee8514db8e787bb133f7d4b09', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitea2dbc7ee8514db8e787bb133f7d4b09::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
