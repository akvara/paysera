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

### Currencies and rounding

Allowed currencies and their rounding accuracy are stored in file ./supported_currencies.csv

### Currency rates

Currency exchange rates to base currency [EUR] are stored in file ./currency_rates.csv

### Applied charges

Applied charges are stored in file ./tariffs.csv

All three mentioned config files MUST be present in App's directory.

## Running commands

It is suggested that you add ./bin/ directory to your PATH: in this case you'll be able to run commands without adding ./bin/ prefix.

To run application, enter:

    paysera calc {data-file-name}
    
where {data-file-name} is the file you want to process.

To run application self-check and user data check, enter:

    paysera check [{data-file-name}]
    
where optional {data-file-name} is the file you want to process.
 
## Running tests

Tests are run by executing commands:

    phpspec run
    ./bin/phpunit
    
the latter can be simplified to

    phpunit
    
if you have ./bin/ directory to your PATH.
    
=====

Trumpai apie sistemą:

Sistema paleidžiama bin/ direktorijoje esančiu vykdomuoju failu ./bin/paysera.

Šiuo metu realizuotos komandos:
- paysera check [failas] - sistemos integralumo ir vartotojo failo atitikimo specifikacijai patikrinimui
- paysera calc failas - komisinių skaičiavimams atlikti

Sistema naudoja konfiguracinius failus csv formatu:

- palaikomos valiutos ir jų apvalinimo tikslumai nurodyti faile supported_currencies.csv,
- valiutų kursai saugomi faile currency_rates.csv,
- šiuo metu naudojami komisinių skaičiavimo tarifai, minimalios komisinių sumos ir nemokamų operacijų limitai saugomi faile tariffs.csv

Sistema tikrina, ar visoms palaikomoms valiutoms yra nurodyti jų kursai.

Duomenų failų, datos formatai ir dalis kitos verslo logikos gali būti konfigūruojama faile Config.php.

Prieš pradėdama skaičiavimus sistema patikrina konfigūracinių failų ir vartotojo failo korektiškumą.

Testams naudojama PHPSpec (verslo logikai) ir PHPUnit (komandinei eilutei).