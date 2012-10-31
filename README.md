LosLicense
=======================

Introduction
------------
This is a module to manage license keys for your application.

It can create and validate licenses based on configurable options:
- IP address
- MAC address
- Date (ie. evaluation time or expiry date. Can use start, end or both)
- Domain (e.g. test.com)
- Server OS (e.g. Linux, Mac, Windows, ...)
- Server name (e.g. server.test.com)
- PHP Version (comparison is possible, e.g. >= 5.3.1)

ATTENTION!!!
------------
This module does not encode your application or protects your code in ANY way (like Zend Guard and ionCube), 
just offers a way to generate and validate license informations.


Installation
------------
Just drop this module inside your vendor directory and enable it in your config/application.config.php.

To change the options, copy the file loslicense.global.php.dist to your config/autoload/ , rename it to 
loslicense.global.php and change the default options.

Example:
<?php
return array(
    'modules' => array(
        'Application',
        'LosLicense'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);

Usage
-----
