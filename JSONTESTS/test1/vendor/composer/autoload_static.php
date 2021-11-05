<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit897b7af657be35574f7b3447c2d39faa
{
    public static $prefixLengthsPsr4 = array (
        'J' => 
        array (
            'JsonSchema\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'JsonSchema\\' => 
        array (
            0 => __DIR__ . '/..' . '/justinrainbow/json-schema/src/JsonSchema',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit897b7af657be35574f7b3447c2d39faa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit897b7af657be35574f7b3447c2d39faa::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit897b7af657be35574f7b3447c2d39faa::$classMap;

        }, null, ClassLoader::class);
    }
}