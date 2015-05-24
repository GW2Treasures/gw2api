# gw2treasures/gw2api

[![version](https://img.shields.io/packagist/v/gw2treasures/gw2api.svg?style=flat-square)](https://packagist.org/packages/gw2treasures/gw2api) [![license](https://img.shields.io/packagist/l/gw2treasures/gw2api.svg?style=flat-square)](https://packagist.org/packages/gw2treasures/gw2api) [![Travis](https://img.shields.io/travis/GW2Treasures/gw2api.svg?style=flat-square)](https://travis-ci.org/GW2Treasures/gw2api) [![Coveralls](https://img.shields.io/coveralls/GW2Treasures/gw2api/master.svg?style=flat-square)](https://coveralls.io/r/GW2Treasures/gw2api?branch=master)

PHP wrapper for the Guild Wars 2 API.

## Requirements

 - PHP >= 5.4

## Setup

### Using [composer](https://getcomposer.org):

```
composer require gw2treasures/gw2api
```

## Examples

```php
// create new api instance
$api = new \GW2Treasures\GW2Api\GW2Api();

// get all worlds
$worlds = $api->worlds()->all();

// get some happy quaggans
$quaggans = $api->quaggans()->many([ 'cheer', 'party' ]);

// get item details in german
$ektoplasmakugel = $api->items()->lang('de')->get(19721);

// search recipes
$recipes = $api->recipes()->search()->input(46746);

// get all character names
$characters = $api->characters('api_key')->ids();

// get 10 recently bought items
$recentlyBought = $api->commerce()->transactions('api_key')->history()->buys()->page(0, 10);
```

## License

[MIT](LICENSE) © 2015 gw2treasures.com
