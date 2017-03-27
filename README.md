Paysera App
===========

This package is a pre-employment test for Paysera.

This document contains information on how to download and start using Paysera App.

## Getting Paysera App


### a) Having downloaded zip file:
If you have Paysera.zip file, unpack into new directory of your choice, say, named *paysera*, and `cd` into that directory

### b) For Git Installers:

Run the following commands:

    git clone git@github.com:akvara/paysera.git
    cd paysera

## Installation


Run the following commands:

    php composer.phar install

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s https://getcomposer.org/installer | php

## Running commands

It is suggested that you add ./bin/ directory to your PATH: in this case you'll be able to run commands without adding ./bin/ prefix.

To run application, enter:

    paysera [import-file-name]
    
where [import-file-name] is the file you want to process.
 
## Running tests

Tests are run by executing command:

    phpunit

Or, you you do not have ./bin/ directory in your PATH:

    ./bin/phpunit


Enjoy!
