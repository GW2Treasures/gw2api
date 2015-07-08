# gw2treasures/gw2api

<!-- badges -->
[![version][packagist-badge]][packagist]
[![license][license-badge]][packagist]
[![Travis][travis-badge]][travis]
[![Coveralls][coveralls-badge]][coveralls]

[packagist-badge]: https://img.shields.io/packagist/v/gw2treasures/gw2api.svg?style=flat-square
[license-badge]: https://img.shields.io/packagist/l/gw2treasures/gw2api.svg?style=flat-square
[travis-badge]: https://img.shields.io/travis/GW2Treasures/gw2api.svg?style=flat-square
[coveralls-badge]: https://img.shields.io/coveralls/GW2Treasures/gw2api/master.svg?style=flat-square
[packagist]: https://packagist.org/packages/gw2treasures/gw2api
[travis]: https://travis-ci.org/GW2Treasures/gw2api
[coveralls]: https://coveralls.io/r/GW2Treasures/gw2api?branch=master

**PHP wrapper for the Guild Wars 2 API**.

## Features
 - Support for all v2 endpoints (including authenticated)
 - Parallel requests for pagination and bulk expansion

## Requirements
 - PHP >= 5.4

## Setup

### Using [composer](https://getcomposer.org):

```sh
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

## Usage

For all examples it is assumed that you have a variable `$api = new GW2Api()`.

### Endpoint Overview

 API Endpoint                 | Class<sup>†</sup>                                          <br>Instance                            | Flags<sup>‡</sup>
 -----------------------------|----------------------------------------------------------------------------------------------------|-------------------
 /v2/account                  | [Account\AccountEndpoint][AccountEndpoint]                 <br>`GW2Api::account()`                 | 🔒
 /v2/account/bank             | [Account\BankEndpoint][Account\BankEndpoint]               <br>`GW2Api::account()->bank()`         | 🔒
 /v2/account/materials        | [Account\MaterialEndpoint][Account\MaterialEndpoint]       <br>`GW2Api::account()->materials()`    | 🔒
 /v2/build                    | [Build\BuildEndpoint][BuildEndpoint]                       <br>`GW2Api::build()`                   |
 /v2/characters               | [Character\CharacterEndpoint][CharacterEndpoint]           <br>`GW2Api::characters()`              | 🔒📦
 /v2/characters/:id/equipment | [Character\EquipmentEndpoint][Character\EquipmentEndpoint] <br>`GW2Api::characters()->equipment()` | 🔒
 /v2/characters/:id/inventory | [Character\InventoryEndpoint][Character\InventoryEndpoint] <br>`GW2Api::characters()->inventory()` | 🔒
 /v2/colors                   | [Color\ColorEndpoint][ColorEndpoint]                       <br>`GW2Api::colors()`                  | 📦🌏
 /v2/commerce/exchange        | [Commerce\ExchangeEndpoint][Commerce\ExchangeEndpoint]     <br>`GW2Api::commerce()->exchange()`    |
 /v2/commerce/listings        | [Commerce\ListingEndpoint][Commerce\ListingEndpoint]       <br>`GW2Api::commerce()->listings()`    | 📦
 /v2/commerce/prices          | [Commerce\PriceEndpoint][Commerce\PriceEndpoint]           <br>`GW2Api::commerce()->prices()`      | 📦
 /v2/commerce/transactions    | [Commerce\Transaction\TransactionEndpoint][Commerce\TransactionEndpoint] <br>`GW2Api::commerce()->transactions()` | 🔒📄
 /v2/continents               | [Continent\ContinentEndpoint][ContinentEndpoint]           <br>`GW2Api::continents()`              | 📦🌏
 ~~/v2/events~~               | *disabled*                                                                                         | 🌏🚫
 ~~/v2/events-state~~         | *disabled*                                                                                         | 🚫
 /v2/files                    | [File\FileEndpoint][FileEndpoint]                          <br>`GW2Api::files()`                   | 📦
 ~~/v2/guild/:id~~            | *disabled*                                                                                         | 🚫
 ~~/v2/guild/:id/inventory~~  | *disabled*                                                                                         | 🔒🚫
 ~~/v2/guild/:id/log~~        | *disabled*                                                                                         | 🔒🚫
 ~~/v2/guild/:id/members~~    | *disabled*                                                                                         | 🔒🚫
 ~~/v2/guild/:id/ranks~~      | *disabled*                                                                                         | 🔒🚫
 ~~/v2/guild/permissions~~    | *disabled*                                                                                         | 🔒🌏🚫
 ~~/v2/guild/upgrades~~       | *disabled*                                                                                         | 🔒🌏🚫
 /v2/items                    | [Item\ItemEndpoint][ItemEndpoint]                          <br>`GW2Api::items()`                   | 📦🌏
 ~~/v2/leaderboards~~         | *disabled*                                                                                         | 🚫
 /v2/maps                     | [Map\MapEndpoint][MapEndpoint]                             <br>`GW2Api::maps()`                    | 📦🌏
 /v2/materials                | [Material\MaterialEndpoint][MaterialEndpoint]              <br>`GW2Api::materials()`               | 📦🌏
 /v2/quaggans                 | [Quaggan\QuagganEndpoint][QuagganEndpoint]                 <br>`GW2Api::quaggans()`                | 📦
 /v2/recipes                  | [Recipe\RecipeEndpoint][RecipeEndpoint]                    <br>`GW2Api::recipes()`                 | 📦
 /v2/recipes/search           | [Recipe\SearchEndpoint][Recipe\SearchEndpoint]             <br>`GW2Api::recipes()->search()`       |
 ~~/v2/skills~~               | *disabled*                                                                                         | 🚫
 /v2/skins                    | [Skin\SkinEndpoint][SkinEndpoint]                     <br>`GW2Api::skins()`                   | 📦🌏
 /v2/tokeninfo                | [Tokeninfo\TokeninfoEndpoint][TokeninfoEndpoint]           <br>`GW2Api::tokeninfo()`               | 🔒
 ~~/v2/traits~~               | *disabled*                                                                                         | 🚫
 /v2/worlds                   | [World\WorldEndpoint][WorldEndpoint]                       <br>`GW2Api::worlds()`                  | 📦🌏
 ~~/v2/wvw/matches~~          | *disabled*                                                                                         | 🚫
 ~~/v2/wvw/objectives~~       | *disabled*                                                                                         | 🚫🌏

† Not FQN, all endpoints are in the namespace `\GW2Treasures\GW2Api\V2\Endpoint`  
‡ Flags:  
&nbsp;&nbsp;&nbsp;&nbsp;[🔒AuthenticatedEndpoint][AuthenticatedEndpoint]  
&nbsp;&nbsp;&nbsp;&nbsp;[📦BulkEndpoint][BulkEndpoint]  
&nbsp;&nbsp;&nbsp;&nbsp;[🌏LocalizedEndpoint][LocalizedEndpoint]  
&nbsp;&nbsp;&nbsp;&nbsp;[📄PaginatedEndpoint][PaginatedEndpoint]  
&nbsp;&nbsp;&nbsp;&nbsp;🚫Disabled in the API

### Abstract Endpoints

#### AuthenticatedEndpoint
[AuthenticatedEndpoint]: #authenticatedendpoint

All endpoints requiring authentication implement the interface `IAuthenticatedEndpoint`.
Throws [AuthenticationException][AuthenticationException]
and [InvalidPermissionsException][InvalidPermissionsException].

#### BulkEndpoint
[BulkEndpoint]: #bulkendpoint

All endpoints supporting bulk expansion implement the interface `IBulkEndpoint`.
Extends [PaginatedEndpoint][PaginatedEndpoint].
Throws [PageOutOfRangeException][PageOutOfRangeException].

##### Methods
 - `all():array` Get all entries.  
   If the endpoint doesn't support `?ids=all` this falls back to [`PaginatedEndpoint::all()`][PaginatedEndpoint].
 - `ids():int[]|string[]` Get all ids.
 - `get(int|string $id):mixed` Get a single entry by id.
 - `many(int[]|string[] $ids):array` Get multiple entries by id.
 - `IPaginatedEndpoint::page(int $page, [int $size]):array`
   Get a specific page of the endpoint.
 - `IPaginatedEndpoint::batch([int $parallelRequests], Closure $callback):void`
   Get all entries in multiple small batches. The callback gets called with new entries until all entries have been processed.  
   Signature of the callback: `function(array $entries):void`.


#### LocalizedEndpoint
[LocalizedEndpoint]: #localizedendpoint

All endpoints supporting localization implement the interface `ILocalizedEndpoint`.
Defaults to `en`.
Throws [InvalidLanguageException][InvalidLanguageException].

##### Methods
 - `lang(string $lang):$this` Change the language of the endpoint.


#### PaginatedEndpoint
[PaginatedEndpoint]: #paginatedendpoint

All endpoints supporting pagination implement the interface `IPaginatedEndpoint`.
Throws [PageOutOfRangeException][PageOutOfRangeException].

##### Methods
 - `all():array` Get all entries.  
   Requests all pages of this endpoint in parallel and returns the merged result.
 - `page(int $page, [int $size]):array` Get a page of entries.
   The `$size` defaults to the maximum page size (200 for most endpoints).
 - `batch([int $parallelRequests], Closure $callback):void`
   Get all entries in multiple small batches. The callback gets called with new entries until all entries have been processed.  
   Signature of the callback: `function(array $entries):void`.

### Exceptions

#### ApiException
[ApiException]: #apiexception

Gets thrown by all endpoints when the API returns an error.
Extends `\Exception`.

##### Methods
 - `getResponse():ResponseInterface` The response that was returned by the API.


#### AuthenticationException
[AuthenticationException]: #authenticationexception

Gets thrown by [AuthenticatedEndpoints][AuthenticatedEndpoint] when the endpoint needs authentication
but no API key was specified or the API key was invalid.
Extends [ApiException][ApiException].


#### InvalidPermissionsException
[InvalidPermissionsException]: #invalidpermissionsexception

Gets thrown by [AuthenticatedEndpoints][AuthenticatedEndpoint] when the API key is missing permissions
to access the endpoint.
Extends [AuthenticationException][AuthenticationException].

##### Methods
 - `getMissingScope():string` The permission that was missing to access the endpoint.


#### InvalidLanguageException
[InvalidLanguageException]: #invalidlanguageexception

Gets thrown by [LocalizedEndpoints][LocalizedEndpoint] when the API responds with a different language than requested.
Extends [ApiException][ApiException].

##### Methods
 - `getRequestLanguage():string` The requested language.
 - `getResponseLanguage():string` The language the API responded with.


#### PageOutOfRangeException
[PageOutOfRangeException]: #pageoutofrangeexception

Gets thrown by [PaginatedEndpoints][PaginatedEndpoint] when requesting a page that doesn't exist.
Extends [ApiException][ApiException].


### Endpoints

#### /v2/account
[AccountEndpoint]: #v2account

`\GW2Treasures\GW2Api\V2\Endpoint\Account\AccountEndpoint`
([source](src/V2/Endpoint/Account/AccountEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():mixed` Get basic account info.
 - `bank():Account\BankEndpoint` Gets a new [Account\BankEndpoint][Account\BankEndpoint] instance.
 - `materials():Account\MaterialEndpoint` Gets a new [Account\MaterialEndpoint][Account\MaterialEndpoint] instance.

##### Example
```php
$api->account('API_KEY')->get();
// => { id: "account-guid", name: "Lawton.1234", … }
```


#### /v2/account/bank
[Account\BankEndpoint]: #v2accountbank

`\GW2Treasures\GW2Api\V2\Endpoint\Account\BankEndpoint`
([source](src/V2/Endpoint/Account/BankEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get account bank.

##### Example
```php
$api->account('API_KEY')->bank()->get();
// => [ null, { id: 46774, slot: 1, count: 1 }, … ]
```


#### /v2/account/materials
[Account\MaterialEndpoint]: #v2accountmaterials

`\GW2Treasures\GW2Api\V2\Endpoint\Account\MaterialEndpoint`
([source](src/V2/Endpoint/Account/MaterialEndpoint.php))

The [Material\MaterialEndpoint][MaterialEndpoint] can be used to get the categories used by this endpoint.
Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get account material storage.

##### Example
```php
$api->account('API_KEY')->materials()->get();
// => [ { id: 19699, category: 5, count: 250 }, … ]
```


#### /v2/build
[BuildEndpoint]: #v2build

`\GW2Treasures\GW2Api\V2\Endpoint\Build\BuildEndpoint`
([source](src/V2/Endpoint/Build/BuildEndpoint.php))

##### Methods
 - `get():int` Gets the current build id.

##### Example
```php
$api->build()->get();
// => 50430
```


#### /v2/characters
[CharacterEndpoint]: #v2characters

`\GW2Treasures\GW2Api\V2\Endpoint\Character\CharacterEndpoint`
([source](src/V2/Endpoint/Character/CharacterEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint] and [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - `equipment():Character\EquipmentEndpoint`
   Gets a new [Character\EquipmentEndpoint][Character\EquipmentEndpoint] instance.
 - `inventory():Character\InventoryEndpoint`
   Gets a new [Character\InventoryEndpoint][Character\InventoryEndpoint] instance.
 - Inherited from [📦BulkEndpoint][BulkEndpoint].

##### Example
```php
$api->characters('API_KEY')->get('Character Name');
// => { name: "Hello", race: "Human", … }
```


#### /v2/characters/:id/equipment
[Character\EquipmentEndpoint]: #v2charactersidequipment

`\GW2Treasures\GW2Api\V2\Endpoint\Character\EquipmentEndpoint`
([source](src/V2/Endpoint/Character/EquipmentEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Gets the characters equipment.

##### Example
```php
$api->characters('API_KEY')->equipment('Character Name')->get();
// => [ { id: 6472, slot: "Coat" }, … ]
```


#### /v2/characters/:id/inventory
[Character\InventoryEndpoint]: #v2charactersidinventory

`\GW2Treasures\GW2Api\V2\Endpoint\Character\InventoryEndpoint`
([source](src/V2/Endpoint/Character/InventoryEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Gets the characters inventory.

##### Example
```php
$api->characters('API_KEY')->inventory('Character Name')->get();
// => [ { id: 8941, size: 4 inventory: [ null, { id: 32134, count: 1 }, … ] }, … ]
```


#### /v2/colors
[ColorEndpoint]: #v2colors

`\GW2Treasures\GW2Api\V2\Endpoint\Color\ColorEndpoint`
([source](src/V2/Endpoint/Color/ColorEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->colors()->lang('de')->all();
// => [ { id: 1, name: "Farbentferner", base_rgb: [128,26,26], … }, … ]
```


#### /v2/commerce/exchange
[Commerce\ExchangeEndpoint]: #v2commerceexchange

`\GW2Treasures\GW2Api\V2\Endpoint\Commerce\ExchangeEndpoint`
([source](src/V2/Endpoint/Commerce/ExchangeEndpoint.php))

##### Methods
 - `gems(int $quantity):mixed` Current gem to coins exchange rate.
 - `coins(int $quantity):mixed` Current coins to gems exchange rate.

##### Example
```php
$api->commerce()->exchange()->gems(50);
// => { coins_per_gem: 1211, quantity: 60579 }
```


#### /v2/commerce/listings
[Commerce\ListingEndpoint]: #v2commercelistings

`\GW2Treasures\GW2Api\V2\Endpoint\Commerce\ListingEndpoint`
([source](src/V2/Endpoint/Commerce/ListingEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]

##### Example
```php
$api->commerce()->listings()->get(24);
// => { id: 24, buys: [ { listings: 1, unit_price: 186, quantity: 250 }, … ] }
```


#### /v2/commerce/prices
[Commerce\PriceEndpoint]: #v2commerceprices

`\GW2Treasures\GW2Api\V2\Endpoint\Commerce\PriceEndpoint`
([source](src/V2/Endpoint/Commerce/PriceEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]

##### Example
```php
$api->commerce()->prices()->get(24);
// => { id: 24, buys: { quantity: 20854, unit_price: 186 }, sells: { quantity: 9787, unit_price: 340 } }
```


#### /v2/commerce/transactions
[Commerce\TransactionEndpoint]: #v2commercetransactions

`\GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction\TransactionEndpoint`
([source](src/V2/Endpoint/Commerce/Transaction/TransactionEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `current():Commerce\Transaction\TypeEndpoint`
   Gets a new [Commerce\Transaction\TypeEndpoint][Commerce\Transaction\TypeEndpoint] instance
   representing current transactions.
 - `history():Commerce\Transaction\TypeEndpoint`
   Gets a new [Commerce\Transaction\TypeEndpoint][Commerce\Transaction\TypeEndpoint] instance
   representing historic transactions.


#### /v2/commerce/transactions/:type
[Commerce\Transaction\TypeEndpoint]: #v2commercetransactionstype

`\GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction\TypeEndpoint`
([source](src/V2/Endpoint/Commerce/Transaction/TypeEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `buys():Commerce\Transaction\ListEndpoint`
   Gets a new [Commerce\Transaction\ListEndpoint][Commerce\Transaction\ListEndpoint] instance
   representing pending/completed buy transactions.
 - `sells():Commerce\Transaction\ListEndpoint`
   Gets a new [Commerce\Transaction\ListEndpoint][Commerce\Transaction\ListEndpoint] instance
   representing pending/completed buy transactions.


#### /v2/commerce/transactions/:type/:list
[Commerce\Transaction\ListEndpoint]: #v2commercetransactionstypelist

`\GW2Treasures\GW2Api\V2\Endpoint\Commerce\Transaction\ListEndpoint`
([source](src/V2/Endpoint/Commerce/Transaction/ListEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint] and [📄PaginatedEndpoint][PaginatedEndpoint].

##### Methods
 - Inherited methods from [📄PaginatedEndpoint][PaginatedEndpoint]

##### Example
```php
$api->commerce()->transactions('API_KEY')->current()->sells()->all();
// => [ { id: 1999, item_id: 19699, price: 1004, quantity: 20, created: "2014-12-15T14:43:36+00:00" }, … ]
```


#### /v2/continents
[ContinentEndpoint]: #v2continents

`\GW2Treasures\GW2Api\V2\Endpoint\Continent\ContinentEndpoint`
([source](src/V2/Endpoint/Continent/ContinentEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]
 - `floors(int $continent_id):Continent\FloorEndpoint` Gets a new [Continent\FloorEndpoint][Continent\FloorEndpoint] instance.

##### Example
```php
$api->continents()->get(1);
// => { name: "Tyria", … }
```


#### /v2/continents/:id/floors
[Continent\FloorEndpoint]: #v2continentsidfloors

`\GW2Treasures\GW2Api\V2\Endpoint\Continent\FloorEndpoint`
([source](src/V2/Endpoint/Continent/FloorEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]

##### Example
```php
$api->continents()->floors(1)->get(0);
// => { texture_dims: [ 32768, 32768 ], … }
```


#### /v2/files
[FileEndpoint]: #v2files

`\GW2Treasures\GW2Api\V2\Endpoint\File\FileEndpoint`
([source](src/V2/Endpoint/File/FileEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]

##### Example
```php
$api->files()->ids();
// => [ "map_complete", "map_dungeon", … ]
```


#### /v2/items
[ItemEndpoint]: #v2items

`\GW2Treasures\GW2Api\V2\Endpoint\Item\ItemEndpoint`
([source](src/V2/Endpoint/Item/ItemEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->items()->ids();
// => [ 1, 2, 6, 11, 24, … ]
```


#### /v2/maps
[MapEndpoint]: #v2maps

`\GW2Treasures\GW2Api\V2\Endpoint\Map\MapEndpoint`
([source](src/V2/Endpoint/Map/MapEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->maps()->get(15);
// => { id: 15, name: "Queensdale", … }
```


#### /v2/materials
[MaterialEndpoint]: #v2materials

`\GW2Treasures\GW2Api\V2\Endpoint\Material\MaterialEndpoint`
([source](src/V2/Endpoint/Material/MaterialEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->materials()->lang('es')->all();
// => [ { id:5, name: "Materiales de cocina", items: [ 12134, … ] }, … ]
```


#### /v2/quaggans
[QuagganEndpoint]: #v2quaggans

`\GW2Treasures\GW2Api\V2\Endpoint\Quaggan\QuagganEndpoint`
([source](src/V2/Endpoint/Quaggan/QuagganEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]

##### Example
```php
$api->quaggans()->many(['cheer', 'party']);
// => [ { id: "cheer", url: "cheer.jpg" }, { id: "party", url: "party.jpg" } ]
```


#### /v2/recipes
[RecipeEndpoint]: #v2recipes

`\GW2Treasures\GW2Api\V2\Endpoint\Recipe\RecipeEndpoint`
([source](src/V2/Endpoint/Recipe/RecipeEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - `search():Recipe\SearchEndpoint` Gets a new [Recipe\SearchEndpoint][Recipe\SearchEndpoint] instance.

##### Example
```php
$api->recipes()->ids();
// => [ 1, 2, 3, 4, 5, … ]
```


#### /v2/recipes/search
[Recipe\SearchEndpoint]: #v2recipessearch

`\GW2Treasures\GW2Api\V2\Endpoint\Recipe\SearchEndpoint`
([source](src/V2/Endpoint/Recipe/SearchEndpoint.php))

##### Methods
 - `input(int $id):mixed` Searches for recipes with `$id` as ingredient.
 - `output(int $id):mixed` Searches for recipes with `$id` as output.

##### Example
```php
$api->recipes()->search()->input(43775);
// => [ 7259, 7260, 7261, 7262, … ]
```


#### /v2/skins
[SkinEndpoint]: #v2skins

`\GW2Treasures\GW2Api\V2\Endpoint\Skin\SkinEndpoint`
([source](src/V2/Endpoint/Skin/SkinEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->skins()->get(1);
// => { name: "Chainmail Leggings", type: "Armor", … }
```


#### /v2/tokeninfo
[TokeninfoEndpoint]: #v2tokeninfo

`\GW2Treasures\GW2Api\V2\Endpoint\Tokeninfo\TokeninfoEndpoint`
([source](src/V2/Endpoint/Tokeninfo/TokeninfoEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():mixed` Get info about the used api key.

##### Example
```php
$api->tokeninfo('API_KEY')->get();
// => { id: "API_KEY", name: "key name", permissions: [ "account", … ] }
```


#### /v2/worlds
[WorldEndpoint]: #v2worlds

`\GW2Treasures\GW2Api\V2\Endpoint\World\WorldEndpoint`
([source](src/V2/Endpoint/World/WorldEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->worlds()->all();
// => [ { id: 1001, name: "Anvil Rock" }, … ]
```


## License

[MIT](LICENSE) © 2015 gw2treasures.com
