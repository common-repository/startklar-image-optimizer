<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite1449c6ec1eb595133c616d3a1235e2c
{
    public static $files = array (
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Component\\Process\\' => 26,
            'Symfony\\Component\\OptionsResolver\\' => 34,
            'Startklar\\ImageOptimizer\\' => 25,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'Symfony\\Component\\OptionsResolver\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/options-resolver',
        ),
        'Startklar\\ImageOptimizer\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static $prefixesPsr0 = array (
        'I' => 
        array (
            'ImageOptimizer' => 
            array (
                0 => __DIR__ . '/..' . '/ps/image-optimizer/src',
            ),
        ),
    );

    public static $classMap = array (
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite1449c6ec1eb595133c616d3a1235e2c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite1449c6ec1eb595133c616d3a1235e2c::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite1449c6ec1eb595133c616d3a1235e2c::$prefixesPsr0;
            $loader->classMap = ComposerStaticInite1449c6ec1eb595133c616d3a1235e2c::$classMap;

        }, null, ClassLoader::class);
    }
}
