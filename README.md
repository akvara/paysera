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
    
## Configuration

### Currency rates

Allowed currencies and their rates to base currency [EUR] are stored in file ./curr_rates.csv

### Applied charges

Applied charges are stored in file ./prices.csv

Both files MUST be present in App's directory

## Running commands

It is suggested that you add ./bin/ directory to your PATH: in this case you'll be able to run commands without adding ./bin/ prefix.

To run application, enter:

    paysera calc {data-file-name}
    
where {data-file-name} is the file you want to process.

To run application self-check, enter:

    paysera check [{data-file-name}]
    
where optional {data-file-name} is the file you want to process.
 
## Running tests

Tests are run by executing command:

    phpspec run
    


Enjoy!
