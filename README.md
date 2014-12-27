# LosLicense

## Introduction
This is a module to manage license keys for your application.

It can create and validate licenses based on configurable options:
- Date (ie. evaluation time or expiry date. Can use start, end or both)
- Domain (e.g. test.com)

You can define application features with the license, and check for them at runtime to limit the funcionality (eg. demo version).

You can combine this module with [LosDomain](http://github.com/LansoWeb/LosDomain) to have different license per domain (eg. clients in a SaaS).

## ATTENTION!!!
This module does not encode your application or protects your code in ANY way (like Zend Guard and ionCube), 
just offers a way to generate and validate license informations.

## Instalation
Instalation can be done with composer ou manually

### Installation with composer
For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

  1. Enter your project directory
  2. Create or edit your `composer.json` file with following contents (minimum stability is required since 
     the module still has frequent updates):

     ```json
     {
         "minimum-stability": "alpha",
         "require": {
             "los/loslicense": "0.*"
         }
     }
     ```
  3. Run `php composer.phar install`
  4. Open `my/project/directory/config/application.config.php` and add `LosLicense` to your `modules`
  
    ```php
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
    ```

### Installation without composer

  1. Clone this module [LosLicense](http://github.com/LansoWeb/LosLicense) to your vendor directory
  2. Enable it in your config/application.config.php like the step 4 in the previous section.

## Usage
To change the options, copy the file loslicense.global.php.dist to your config/autoload/ , rename it to 
loslicense.global.php and change the default options. the description of each options is covered in the next section.

## List of options
Coming soon!
