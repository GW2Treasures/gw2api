# gw2treasures/gw2api

<!-- badges -->
[![version][packagist-badge]][packagist]
[![license][license-badge]][packagist]
[![Travis][travis-badge]][travis]
[![Coverage][coverage-badge]][coverage]

[packagist-badge]: https://img.shields.io/packagist/v/gw2treasures/gw2api.svg?style=flat-square
[license-badge]: https://img.shields.io/packagist/l/gw2treasures/gw2api.svg?style=flat-square
[travis-badge]: https://img.shields.io/travis/GW2Treasures/gw2api.svg?style=flat-square
[coverage-badge]: https://img.shields.io/codecov/c/github/GW2Treasures/gw2api.svg?style=flat-square
[packagist]: https://packagist.org/packages/gw2treasures/gw2api
[travis]: https://travis-ci.org/GW2Treasures/gw2api
[coverage]: https://codecov.io/github/GW2Treasures/gw2api

**PHP wrapper for the Guild Wars 2 API**.

## Features
 - Support for all v2 endpoints (including authenticated)
 - Parallel requests for pagination and bulk expansion

## Requirements
 - PHP >= 5.5

## Setup

### Using [composer](https://getcomposer.org) (recommended)

```sh
composer require gw2treasures/gw2api
```

If you haven't included composers autoloader yet,
you will have to add this before being able to use the GW2 API Wrapper.

```php
include 'vendor/autoload.php';
```

### Using the gw2api.phar archive

You need to download the [latest gw2api.phar](https://github.com/GW2Treasures/gw2api/releases/latest)
and the [guzzle.phar of the latest 6.x version](https://github.com/guzzle/guzzle/releases/latest) of the
[guzzle](https://github.com/guzzle/guzzle) library and place both files in your project directory.
Now you can include both files to start using the GW2 API wrapper.

```php
include __DIR__ . '/gw2api.phar';
include __DIR__ . '/guzzle.phar';
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
 /v2/account/achievements     | [Account\AchievementEndpoint][Account\AchievementEndpoint] <br>`GW2Api::account()->achievement()`  | 🔒
 /v2/account/bank             | [Account\BankEndpoint][Account\BankEndpoint]               <br>`GW2Api::account()->bank()`         | 🔒
 /v2/account/dyes             | [Account\DyeEndpoint][Account\DyeEndpoint]                 <br>`GW2Api::account()->dyes()`         | 🔒
 /v2/account/inventory        | [Account\InventoryEndpoint][Account\InventoryEndpoint]     <br>`GW2Api::account()->inventory()`    | 🔒
 /v2/account/materials        | [Account\MaterialEndpoint][Account\MaterialEndpoint]       <br>`GW2Api::account()->materials()`    | 🔒
 /v2/account/minis            | [Account\MiniEndpoint][Account\MiniEndpoint]               <br>`GW2Api::account()->minis()`        | 🔒
 /v2/account/skins            | [Account\SkinEndpoint][Account\SkinEndpoint]               <br>`GW2Api::account()->skins()`        | 🔒
 /v2/account/wallet           | [Account\WalletEndpoint][Account\WalletEndpoint]           <br>`GW2Api::account()->wallet()`       | 🔒
 /v2/achievements             | [Achievement\AchievementEndpoint][AchievementEndpoint]     <br>`GW2Api::achievements()`            | 📦🌏
 /v2/achievements/categories  | [Achievement\CategoryEndpoint][Achievement\CategoryEndpoint]<br>`GW2Api::achievements()->categories()`| 📦🌏
 /v2/achievements/daily       | [Achievement\DailyEndpoint][Achievement\DailyEndpoint]     <br>`GW2Api::achievements()->daily()`   |
 /v2/achievements/groups      | [Achievement\GroupEndpoint][Achievement\GroupEndpoint]     <br>`GW2Api::achievements()->groups()`  | 📦🌏
 /v2/build                    | [Build\BuildEndpoint][BuildEndpoint]                       <br>`GW2Api::build()`                   |
 /v2/characters               | [Character\CharacterEndpoint][CharacterEndpoint]           <br>`GW2Api::characters()`              | 🔒📦
 /v2/characters/:id/equipment | [Character\EquipmentEndpoint][Character\EquipmentEndpoint] <br>`GW2Api::characters()->equipment()` | 🔒
 /v2/characters/:id/inventory | [Character\InventoryEndpoint][Character\InventoryEndpoint] <br>`GW2Api::characters()->inventory()` | 🔒
 /v2/characters/:id/recipes   | [Character\RecipeEndpoint][Character\RecipeEndpoint]       <br>`GW2Api::characters()->recipes()`   | 🔒
 /v2/characters/:id/specializations | [Character\SpecializationEndpoint][Character\SpecializationEndpoint] <br>`GW2Api::characters()->specializations()` | 🔒
 /v2/colors                   | [Color\ColorEndpoint][ColorEndpoint]                       <br>`GW2Api::colors()`                  | 📦🌏
 /v2/commerce/exchange        | [Commerce\ExchangeEndpoint][Commerce\ExchangeEndpoint]     <br>`GW2Api::commerce()->exchange()`    |
 /v2/commerce/listings        | [Commerce\ListingEndpoint][Commerce\ListingEndpoint]       <br>`GW2Api::commerce()->listings()`    | 📦
 /v2/commerce/prices          | [Commerce\PriceEndpoint][Commerce\PriceEndpoint]           <br>`GW2Api::commerce()->prices()`      | 📦
 /v2/commerce/transactions    | [Commerce\Transaction\TransactionEndpoint][Commerce\TransactionEndpoint] <br>`GW2Api::commerce()->transactions()` | 🔒📄
 /v2/continents               | [Continent\ContinentEndpoint][ContinentEndpoint]           <br>`GW2Api::continents()`              | 📦🌏
 /v2/currencies               | [Currency\CurrencyEndpoint][CurrencyEndpoint]              <br>`GW2Api::currencies()`              | 📦🌏
 /v2/emblem                   | [Emblem\EmblemEndpoint][EmblemEndpoint]                    <br>`GW2Api::emblem()`                  |
 ~~/v2/events~~               | *disabled*                                                                                         | 🌏🚫
 ~~/v2/events-state~~         | *disabled*                                                                                         | 🚫
 /v2/files                    | [File\FileEndpoint][FileEndpoint]                          <br>`GW2Api::files()`                   | 📦
 ~~/v2/guild/:id~~            | *disabled*                                                                                         | 🚫
 ~~/v2/guild/:id/inventory~~  | *disabled*                                                                                         | 🔒🚫
 /v2/guild/:id/log            | [Guild\LogEndpoint][Guild\LogEndpoint]                     <br>`GW2Api::guild()->log()`            | 🔒
 /v2/guild/:id/members        | [Guild\MemberEndpoint][Guild\MemberEndpoint]               <br>`GW2Api::guild()->members()`        | 🔒
 /v2/guild/:id/ranks          | [Guild\RankEndpoint][Guild\RankEndpoint]                   <br>`GW2Api::guild()->ranks()`          | 🔒
 /v2/guild/permissions        | [Guild\PermissionEndpoint][Guild\PermissionEndpoint]       <br>`GW2Api::guild()->permissions()`    | 📦🌏
 /v2/guild/upgrades           | [Guild\UpgradeEndpoint][Guild\UpgradeEndpoint]             <br>`GW2Api::guild()->upgrades()`       | 📦🌏
 /v2/items                    | [Item\ItemEndpoint][ItemEndpoint]                          <br>`GW2Api::items()`                   | 📦🌏
 ~~/v2/leaderboards~~         | *disabled*                                                                                         | 🚫
 /v2/maps                     | [Map\MapEndpoint][MapEndpoint]                             <br>`GW2Api::maps()`                    | 📦🌏
 /v2/materials                | [Material\MaterialEndpoint][MaterialEndpoint]              <br>`GW2Api::materials()`               | 📦🌏
 /v2/minis                    | [Mini\MiniEndpoint][MiniEndpoint]                          <br>`GW2Api::minis()`                   | 📦🌏
 /v2/pvp/games                | [Pvp\GameEndpoint][Pvp\GameEndpoint]                       <br>`GW2Api::pvp()->games()`            | 🔒📦
 /v2/pvp/stats                | [Pvp\StatsEndpoint][Pvp\StatsEndpoint]                     <br>`GW2Api::pvp()->stats()`            | 🔒
 /v2/quaggans                 | [Quaggan\QuagganEndpoint][QuagganEndpoint]                 <br>`GW2Api::quaggans()`                | 📦
 /v2/recipes                  | [Recipe\RecipeEndpoint][RecipeEndpoint]                    <br>`GW2Api::recipes()`                 | 📦
 /v2/recipes/search           | [Recipe\SearchEndpoint][Recipe\SearchEndpoint]             <br>`GW2Api::recipes()->search()`       |
 /v2/skills                   | [Skill\SkillEndpoint][SkillEndpoint]                       <br>`GW2Api::skills()`                  | 📦🌏
 /v2/skins                    | [Skin\SkinEndpoint][SkinEndpoint]                          <br>`GW2Api::skins()`                   | 📦🌏
 /v2/specializations          | [Specialization\SpecializationEndpoint][SpecializationEndpoint] <br>`GW2Api::specializations()`    | 📦🌏
 /v2/tokeninfo                | [Tokeninfo\TokeninfoEndpoint][TokeninfoEndpoint]           <br>`GW2Api::tokeninfo()`               | 🔒
 /v2/traits                   | [Traits\TraitEndpoint][TraitEndpoint]                      <br>`GW2Api::traits()`                  | 📦🌏
 /v2/worlds                   | [World\WorldEndpoint][WorldEndpoint]                       <br>`GW2Api::worlds()`                  | 📦🌏
 ~~/v2/wvw/abilities~~        | *disabled*                                                                                         | 🌏🚫
 /v2/wvw/matches              | [WvW\MatchEndpoint][WvW\MatchEndpoint]                     <br>`GW2Api::wvw()->matches()`          | 📦
 /v2/wvw/objectives           | [WvW\ObjectiveEndpoint][WvW\ObjectiveEndpoint]             <br>`GW2Api::wvw()->objectives()`       | 📦🌏

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

`\GW2Treasures\GW2Api\V2\Authentication\IAuthenticatedEndpoint` ([source](src/V2/Authentication/IAuthenticatedEndpoint.php))

All endpoints requiring authentication implement the interface `IAuthenticatedEndpoint`.
Throws [AuthenticationException][AuthenticationException]
and [InvalidPermissionsException][InvalidPermissionsException].

#### BulkEndpoint
[BulkEndpoint]: #bulkendpoint

`\GW2Treasures\GW2Api\V2\Bulk\IBulkEndpoint` ([source](src/V2/Bulk/IBulkEndpoint.php))

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

##### Example
```php
$api->items()->all();
// => returns array with all items

$api->items()->ids();
// => returns array with all item ids

$api->items()->get(1);
// => returns item with id 1

$api->items()->many([1,2,3]);
// => returns items with ids 1, 2 and 3
```


#### LocalizedEndpoint
[LocalizedEndpoint]: #localizedendpoint

`\GW2Treasures\GW2Api\V2\Localization\ILocalizedEndpoint` ([source](src/V2/Localization/ILocalizedEndpoint.php))

All endpoints supporting localization implement the interface `ILocalizedEndpoint`.
Defaults to `en`.
Throws [InvalidLanguageException][InvalidLanguageException].

##### Methods
 - `lang(string $lang):$this` Change the language of the endpoint.

##### Example
```php
$api->items()->lang('de')->get(1)
// => returns german item 1
```

#### PaginatedEndpoint
[PaginatedEndpoint]: #paginatedendpoint

`\GW2Treasures\GW2Api\V2\Pagination\IPaginatedEndpoint` ([source](src/V2/Pagination/IPaginatedEndpoint.php))

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

#### Example
```php
$api->items()->all();
// => returns all items

$api->items()->page(0, 10);
// => returns first page of 10 items

$api->items()->batch(function($items) {
    // $items contains items of current batch.
    // gets called multiple times with different items untill all items have been processed.
});
```

#### RestrictedGuildEndpoint
[RestrictedGuildEndpoint]: #restrictedguildendpoint

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\IRestrictedGuildEndpoint` ([source](src/V2/Endpoint/Guild/IRestrictedGuildEndpoint.php))

All guild endpoints requiring you to be a member implement the interface `RestrictedGuildEndpoint`.
Throws [GuildLeaderRequiredException][GuildLeaderRequiredException] or [MembershipRequiredException][MembershipRequiredException].



### Exceptions

#### ApiException
[ApiException]: #apiexception

`\GW2Treasures\GW2Api\Exception\ApiException` ([source](src/Exception/ApiException.php))

Gets thrown by all endpoints when the API returns an error.
Extends `\Exception`.

##### Methods
 - `getResponse():ResponseInterface` The response that was returned by the API.

##### Example
```php
try {
    $api->items()->get('invalid item id');
} catch(ApiException $exception) {
    $exception->getMessage() === "no such id"
}
```

#### AuthenticationException
[AuthenticationException]: #authenticationexception

`\GW2Treasures\GW2Api\V2\Authentication\Exception\AuthenticationException`
([source](src/V2/Authentication/Exception/AuthenticationException.php))

Gets thrown by [AuthenticatedEndpoints][AuthenticatedEndpoint] when the endpoint needs authentication
but no API key was specified or the API key was invalid.
Extends [ApiException][ApiException].

##### Example
```php
try {
    $api->account('INVALID_API_KEY')->get();
} catch(AuthenticationException $exception) {
    $exception->getMessage() === "invalid key"
}
```

#### InvalidPermissionsException
[InvalidPermissionsException]: #invalidpermissionsexception

`\GW2Treasures\GW2Api\V2\Authentication\Exception\InvalidPermissionsException`
([source](src/V2/Authentication/Exception/InvalidPermissionsException.php))

Gets thrown by [AuthenticatedEndpoints][AuthenticatedEndpoint] when the API key is missing permissions
to access the endpoint.
Extends [AuthenticationException][AuthenticationException].

##### Methods
 - `getMissingScope():string` The permission that was missing to access the endpoint.

##### Example
```php
try {
    $api->characters('API_KEY_WITHOUT_CHARACTERS_SCOPE')->get();
} catch(InvalidPermissionsException $exception) {
    $exception->getMessage() === "requires scope characters"
    $exception->getMissingScope() === "characters"
}
```


#### InvalidLanguageException
[InvalidLanguageException]: #invalidlanguageexception

`\GW2Treasures\GW2Api\V2\Localization\Exception\InvalidLanguageException`
([source](src/V2/Localization/Exception/InvalidLanguageException.php))

Gets thrown by [LocalizedEndpoints][LocalizedEndpoint] when the API responds with a different language than requested.
Extends [ApiException][ApiException].

##### Methods
 - `getRequestLanguage():string` The requested language.
 - `getResponseLanguage():string` The language the API responded with.

##### Example
```php
try {
    $api->items()->lang('invalid')->get(1);
} catch(InvalidLanguageException $exception) {
    $exception->getMessage() === "Invalid language (expected: invalid; actual: en)"
    $exception->getRequestLanguage() === "invalid"
    $exception->getResponseLanguage() === "en"
}
```


#### PageOutOfRangeException
[PageOutOfRangeException]: #pageoutofrangeexception

`\GW2Treasures\GW2Api\V2\Pagination\Exception\PageOutOfRangeException`
([source](src/V2/Pagination/Exception/PageOutOfRangeException.php))

Gets thrown by [PaginatedEndpoints][PaginatedEndpoint] when requesting a page that doesn't exist.
Extends [ApiException][ApiException].

##### Example
```php
try {
    $api->items()->page(9001);
} catch(PageOutOfRangeException $exception) {
    $exception->getMessage() === "page out of range. Use page values 0 - 826."
}
```


#### GuildException
[GuildException]: #guildexception

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\Exception\GuildException`
([source](src/V2/Endpoint/Guild/Exception/GuildException.php))

Parent class of all guild exceptions.
Extends [ApiException][ApiException].


#### GuildLeaderRequiredException
[GuildLeaderRequiredException]: #guildleaderrequiredexception

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\Exception\GuildLeaderRequiredException`
([source](src/V2/Endpoint/Guild/Exception/GuildLeaderRequiredException.php))

Gets thrown by [RestrictedGuildEndpoint][RestrictedGuildEndpoint] when requesting informations of a guild you are not
the leader of.
Extends [GuildException][GuildException].

##### Example
```php
try {
    $api->guild()->members('API_KEY', 'GUILD_ID_YOU_ARE_NOT_LEADER_OF');
} catch(GuildLeaderRequiredException $exception) {
    $exception->getMessage() === "access restricted to guild leaders"
}
```


#### MembershipRequiredException
[MembershipRequiredException]: #membershiprequiredexception

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\Exception\GuildLeaderRequiredException`
([source](src/V2/Endpoint/Guild/Exception/GuildLeaderRequiredException.php))

Gets thrown by [RestrictedGuildEndpoint][RestrictedGuildEndpoint] when requesting informations of a guild you are not
a member of.
Extends [GuildException][GuildException].

##### Example
```php
try {
    $api->guild()->members('API_KEY', 'GUILD_ID_YOU_ARE_NOT_A_MEMBER_OF');
} catch(GuildLeaderRequiredException $exception) {
    $exception->getMessage() === "membership required"
}
```


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


#### /v2/account/achievements
[Account\AchievementEndpoint]: #v2accountachievements

`\GW2Treasures\GW2Api\V2\Endpoint\Account\AchievementEndpoint`
([source](src/V2/Endpoint/Account/AchievementEndpoint.php))

The [AchievementEndpoint][AchievementEndpoint] can be used to look up the achievements returned by this endpoint.
Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get account achievement progression.

##### Example
```php
$api->account('API_KEY')->achievements()->get();
// => [ { id: 1, current: 1, max: 1000, done: false }, … ]
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


#### /v2/account/dyes
[Account\DyeEndpoint]: #v2accountdyes

`\GW2Treasures\GW2Api\V2\Endpoint\Account\DyeEndpoint`
([source](src/V2/Endpoint/Account/DyeEndpoint.php))

The [ColorEndpoint][ColorEndpoint] can be used to look up the skins used by this endpoint.
Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get unlocked dyes.

##### Example
```php
$api->account('API_KEY')->dyes()->get();
// => [ 8, 12, 14, 17, … ]
```


#### /v2/account/inventory
[Account\InventoryEndpoint]: #v2accountinventory

`\GW2Treasures\GW2Api\V2\Endpoint\Account\InventoryEndpoint`
([source](src/V2/Endpoint/Account/InventoryEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Returns a list of item stacks representing the account's shared inventory slots.

##### Example
```php
$api->account('API_KEY')->inventory()->get();
// => [ null, { id: 12138, count: 250 }, null ]
```


#### /v2/account/materials
[Account\MaterialEndpoint]: #v2accountmaterials

`\GW2Treasures\GW2Api\V2\Endpoint\Account\MaterialEndpoint`
([source](src/V2/Endpoint/Account/MaterialEndpoint.php))

The [MaterialEndpoint][MaterialEndpoint] can be used to get the categories used by this endpoint.
Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get account material storage.

##### Example
```php
$api->account('API_KEY')->materials()->get();
// => [ { id: 19699, category: 5, count: 250 }, … ]
```


#### /v2/account/minis
[Account\MiniEndpoint]: #v2accountminis

`\GW2Treasures\GW2Api\V2\Endpoint\Account\MiniEndpoint`
([source](src/V2/Endpoint/Account/MiniEndpoint.php))

The [MiniEndpoint][MiniEndpoint] can be used to look up the minis returned by this endpoint.
Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get unlocked minis.

##### Example
```php
$api->account('API_KEY')->minis()->get();
// => [ 1, 2, 3, 4, … ]
```


#### /v2/account/skins
[Account\SkinEndpoint]: #v2accountskins

`\GW2Treasures\GW2Api\V2\Endpoint\Account\SkinEndpoint`
([source](src/V2/Endpoint/Account/SkinEndpoint.php))

The [SkinEndpoint][SkinEndpoint] can be used to look up the skins used by this endpoint.
Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get unlocked skins.

##### Example
```php
$api->account('API_KEY')->skins()->get();
// => [ 1, 2, 3, 4, … ]
```


#### /v2/account/wallet
[Account\WalletEndpoint]: #v2accountwallet

`\GW2Treasures\GW2Api\V2\Endpoint\Account\WalletEndpoint`
([source](src/V2/Endpoint/Account/WalletEndpoint.php))

The [CurrencyEndpoint][CurrencyEndpoint] can be used to look up the currencies used by this endpoint.
Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get the account wallet.

##### Example
```php
$api->account('API_KEY')->wallet()->get();
// => [ { id: 1, value: 234885 }, … ]
```


#### /v2/achievements
[AchievementEndpoint]: #v2achievements

`\GW2Treasures\GW2Api\V2\Endpoint\Achievement\AchievementEndpoint`
([source](src/V2/Endpoint/Achievement/AchievementEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]
 - `categories():Achievement\CategoryEndpoint` Gets a new [Achievement\CategoryEndpoint][Achievement\CategoryEndpoint] instance.
 - `daily():Achievement\DailyEndpoint` Gets a new [Achievement\DailyEndpoint][Achievement\DailyEndpoint] instance.
 - `groups():Achievement\GroupEndpoint` Gets a new [Achievement\GroupEndpoint][Achievement\GroupEndpoint] instance.

##### Example
```php
$api->achievements()->get(1);
// => { id: 1, name: "Centaur Slayer", … }
```


#### /v2/achievements/categories
[Achievement\CategoryEndpoint]: #v2achievementscategories

`\GW2Treasures\GW2Api\V2\Endpoint\Achievement\CategoryEndpoint`
([source](src/V2/Endpoint/Achievement/CategoryEndpoint.php))

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->achievements()->categories()->get(50);
// => { id: 50, name: "Twilight Assault", … }
```


#### /v2/achievements/daily
[Achievement\DailyEndpoint]: #v2achievementsdaily

`\GW2Treasures\GW2Api\V2\Endpoint\Achievement\DailyEndpoint`
([source](src/V2/Endpoint/Achievement/DailyEndpoint.php))

##### Methods
 - `get():mixed` Get the current daily achievements.

##### Example
```php
$api->achievements()->daily()->get();
// => { pve: [ { id: 1984, level: { min:1, max: 80 } }, … ], pvp: [ … ], wvw: [ … ] }
```


#### /v2/achievements/groups
[Achievement\GroupEndpoint]: #v2achievementsgroups

`\GW2Treasures\GW2Api\V2\Endpoint\Achievement\GroupEndpoint`
([source](src/V2/Endpoint/Achievement/GroupEndpoint.php))

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->achievements()->groups()->get('65B4B678-607E-4D97-B458-076C3E96A810');
// => { id: "65B4B678-607E-4D97-B458-076C3E96A810", name: "Heart of Thorns", … }
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
 - `recipes():Character\RecipeEndpoint`
   Gets a new [Character\RecipeEndpoint][Character\RecipeEndpoint] instance.
 - `specializations():Character\SpecializationEndpoint`
   Gets a new [Character\SpecializationEndpoint][Character\SpecializationEndpoint] instance.
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


#### /v2/characters/:id/recipes
[Character\RecipeEndpoint]: #v2charactersidrecipes

`\GW2Treasures\GW2Api\V2\Endpoint\Character\RecipeEndpoint`
([source](src/V2/Endpoint/Character/RecipeEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Get unlocked recipes of a character.

##### Example
```php
$api->characters('API_KEY')->recipes('Character Name')->get();
// => [ 7, 8, 9, 10, 11, … ]
```


#### /v2/characters/:id/specializations
[Character\SpecializationEndpoint]: #v2charactersidspecializations

`\GW2Treasures\GW2Api\V2\Endpoint\Character\SpecializationEndpoint`
([source](src/V2/Endpoint/Character/SpecializationEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():array` Gets the characters specializations.

##### Example
```php
$api->characters('API_KEY')->specializations('Character Name')->get();
// => { pve: [ { id: 41, traits: [232, 214, 226] }, … ], … }
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


#### /v2/currencies
[CurrencyEndpoint]: #v2currencies

`\GW2Treasures\GW2Api\V2\Endpoint\Currency\CurrencyEndpoint`
([source](src/V2/Endpoint/Currency/CurrencyEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->currencies()->get(1);
// => { id: 1, name: "Coin", … }
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


#### /v2/emblem
[EmblemEndpoint]: #v2emblem

`\GW2Treasures\GW2Api\V2\Endpoint\Emblem\EmblemEndpoint`
([source](src/V2/Endpoint/Emblem/EmblemEndpoint.php))

##### Methods
 - `backgrounds():Emblem\LayerEndpoint`
   Gets a new [Emblem\LayerEndpoint][Emblem\LayerEndpoint] instance of all background layers.
 - `foregrounds():Emblem\LayerEndpoint`
   Gets a new [Emblem\LayerEndpoint][Emblem\LayerEndpoint] instance of all foreground layers.


#### /v2/emblem/:type
[Emblem\LayerEndpoint]: #v2emblemtype

`\GW2Treasures\GW2Api\V2\Endpoint\Emblem\LayerEndpoint`
([source](src/V2/Endpoint/Emblem/LayerEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]

##### Example
```php
$api->emblem()->foregrounds()->get(1);
// => { id: 1, layers: [ "59641.png", "59643.png", "59645.png" ] }
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

#### /v2/guild/:id/log
[Guild\LogEndpoint]: #v2guildidlog

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\LogEndpoint`
([source](src/V2/Endpoint/Guild/LogEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint] and [RestrictedGuildEndpoint][RestrictedGuildEndpoint].

##### Methods
 - Inherited methods from [🔒AuthenticatedEndpoint][AuthenticatedEndpoint]

##### Example
```php
$api->guild()->log('API_KEY', 'GUILD_ID');
// => [ { id: 1190, time: "…", type: "treasury", user: "Lawton Campbell.9413", … }, … ]
```

#### /v2/guild/:id/members
[Guild\MemberEndpoint]: #v2guildidmembers

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\MemberEndpoint`
([source](src/V2/Endpoint/Guild/MemberEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint] and [RestrictedGuildEndpoint][RestrictedGuildEndpoint].

##### Methods
 - Inherited methods from [🔒AuthenticatedEndpoint][AuthenticatedEndpoint]

##### Example
```php
$api->guild()->members('API_KEY', 'GUILD_ID');
// => [ { name: "darthmaim.6017", rank: "Leader", joined: "2015-12-16T02:50:26.000Z" } ]
```


#### /v2/guild/:id/ranks
[Guild\RankEndpoint]: #v2guildidranks

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\RankEndpoint`
([source](src/V2/Endpoint/Guild/RankEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint] and [RestrictedGuildEndpoint][RestrictedGuildEndpoint].

##### Methods
- Inherited methods from [🔒AuthenticatedEndpoint][AuthenticatedEndpoint]

##### Example
```php
$api->guild()->ranks('API_KEY', 'GUILD_ID');
// => [ { id: "Leader", order: 1, permissions: [ "Admin", … ], icon: "…" }, … ]
```


#### /v2/guild/permissions
[Guild\PermissionEndpoint]: #v2guildpermissions

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\PermissionEndpoint`
([source](src/V2/Endpoint/Guild/PermissionEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->guild()->permissions()->ids();
// => [ "ClaimableEditOptions", "EditBGM", "ActivatePlaceables", … ]
```


#### /v2/guild/upgrades
[Guild\UpgradeEndpoint]: #v2guildupgrades

`\GW2Treasures\GW2Api\V2\Endpoint\Guild\UpgradeEndpoint`
([source](src/V2/Endpoint/Guild/UpgradeEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->guild()->upgrades()->get(38);
// => { id: 38, name: "Guild Armorer 1", … }
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


#### /v2/minis
[MiniEndpoint]: #v2minis

`\GW2Treasures\GW2Api\V2\Endpoint\Mini\MiniEndpoint`
([source](src/V2/Endpoint/Mini/MiniEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->minis()->get(1);
// => { id: 1, name: "Miniature Rytlock", … }
```


#### /v2/pvp/games
[Pvp\GameEndpoint]: #v2pvpgames

`\GW2Treasures\GW2Api\V2\Endpoint\Pvp\GameEndpoint`
([source](src/V2/Endpoint/Pvp/GameEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint] and [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited from [📦BulkEndpoint][BulkEndpoint].

##### Example
```php
$api->pvp('API_KEY')->games()->get('A9F9FD97-F114-4F97-B2CA-5E814DF0340E');
// => { id: "A9F9FD97-F114-4F97-B2CA-5E814DF0340E", map_id: 795, … }
```


#### /v2/pvp/stats
[Pvp\StatsEndpoint]: #v2pvpstats

`\GW2Treasures\GW2Api\V2\Endpoint\Pvp\StatsEndpoint`
([source](src/V2/Endpoint/Pvp/StatsEndpoint.php))

Implements [🔒AuthenticatedEndpoint][AuthenticatedEndpoint].

##### Methods
 - `get():mixed` Get pvp stats.

##### Example
```php
$api->pvp('API_KEY')->stats()->get();
// => { pvp_rank: 57, aggregate: { wins: 343, … }, … }
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


#### /v2/skills
[SkillEndpoint]: #v2skills

`\GW2Treasures\GW2Api\V2\Endpoint\Skill\SkillEndpoint`
([source](src/V2/Endpoint/Skill/SkillEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->skills()->get(1);
// => { name: "Bandage", facts: [ { text: "Recharge", type: "Recharge", icon: "…", value: 5 } ], … }
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


#### /v2/specializations
[SpecializationEndpoint]: #v2specializations

`\GW2Treasures\GW2Api\V2\Endpoint\Specialization\SpecializationEndpoint`
([source](src/V2/Endpoint/Specialization/SpecializationEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->specializations()->get(1);
// => { id: 1, name: "Dueling", profession: "Mesmer", … }
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


#### /v2/traits
[TraitEndpoint]: #v2traits

`\GW2Treasures\GW2Api\V2\Endpoint\Traits\TraitEndpoint`
([source](src/V2/Endpoint/Traits/TraitEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->traits()->get(214);
// => { id: 214, tier:2, name: "Aeromancer's Training", … }
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


#### /v2/wvw/matches
[WvW\MatchEndpoint]: #v2wvwmatches

`\GW2Treasures\GW2Api\V2\Endpoint\WvW\MatchEndpoint`
([source](src/V2/Endpoint/WvW/MatchEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - `world(int $id):mixed` Get the current match of a world.

##### Example
```php
$api->wvw()->matches()->get('2-6');

// => { id: "2-6", "scores": { red: 169331, blue: 246780, green: 216241 }, … }
```


#### /v2/wvw/objectives
[WvW\ObjectiveEndpoint]: #v2wvwobjectives

`\GW2Treasures\GW2Api\V2\Endpoint\WvW\ObjectiveEndpoint`
([source](src/V2/Endpoint/WvW/ObjectiveEndpoint.php))

Implements [📦BulkEndpoint][BulkEndpoint] and [🌏LocalizedEndpoint][LocalizedEndpoint].

##### Methods
 - Inherited methods from [📦BulkEndpoint][BulkEndpoint]
 - Inherited methods from [🌏LocalizedEndpoint][LocalizedEndpoint]

##### Example
```php
$api->wvw()->objectives()->get('968-98');

// => { id: "968-98", name: "Wurm Tunnel", … }
```


## License

[MIT](LICENSE) © 2015 gw2treasures.com
