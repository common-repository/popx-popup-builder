<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6894b08652399db5b793325a96d25685
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Popx\\Core\\Fields\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Popx\\Core\\Fields\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core/fields',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Popx\\Core\\Fields\\Border' => __DIR__ . '/../..' . '/core/fields/Border.php',
        'Popx\\Core\\Fields\\Border_Radius' => __DIR__ . '/../..' . '/core/fields/Border_Radius.php',
        'Popx\\Core\\Fields\\Box_Shadow' => __DIR__ . '/../..' . '/core/fields/Box_Shadow.php',
        'Popx\\Core\\Fields\\Color' => __DIR__ . '/../..' . '/core/fields/Color.php',
        'Popx\\Core\\Fields\\Dimension' => __DIR__ . '/../..' . '/core/fields/Dimension.php',
        'Popx\\Core\\Fields\\Fields_Maping' => __DIR__ . '/../..' . '/core/fields/Fields_Maping.php',
        'Popx\\Core\\Fields\\Heading' => __DIR__ . '/../..' . '/core/fields/Heading.php',
        'Popx\\Core\\Fields\\Image_Radio_Button' => __DIR__ . '/../..' . '/core/fields/Image_Radio_Button.php',
        'Popx\\Core\\Fields\\Media' => __DIR__ . '/../..' . '/core/fields/Media.php',
        'Popx\\Core\\Fields\\Number' => __DIR__ . '/../..' . '/core/fields/Number.php',
        'Popx\\Core\\Fields\\Select' => __DIR__ . '/../..' . '/core/fields/Select.php',
        'Popx\\Core\\Fields\\Switcher' => __DIR__ . '/../..' . '/core/fields/Switch.php',
        'Popx\\Core\\Fields\\Text' => __DIR__ . '/../..' . '/core/fields/Text.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6894b08652399db5b793325a96d25685::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6894b08652399db5b793325a96d25685::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6894b08652399db5b793325a96d25685::$classMap;

        }, null, ClassLoader::class);
    }
}