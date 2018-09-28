<?php

namespace GW2Treasures\GW2Api;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GW2Treasures\GW2Api\Middleware\EffectiveUrlMiddleware;
use GW2Treasures\GW2Api\V2\ApiHandler;
use GW2Treasures\GW2Api\V2\Authentication\AuthenticationHandler;
use GW2Treasures\GW2Api\V2\Endpoint\Account\AccountEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Achievement\AchievementEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Backstory\BackstoryEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Build\BuildEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Character\CharacterEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Color\ColorEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Commerce\CommerceEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Continent\ContinentEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Currency\CurrencyEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Dungeon\DungeonEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Emblem\EmblemEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\File\FileEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Finisher\FinisherEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Glider\GliderEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\GuildEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Guild\RestrictedGuildHandler;
use GW2Treasures\GW2Api\V2\Endpoint\Item\ItemEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Itemstat\ItemstatEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Legend\LegendEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Mailcarrier\MailcarrierEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Map\MapEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Mastery\MasteryEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Material\MaterialEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Mini\MiniEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Mount\MountEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Outfit\OutfitEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Pet\PetEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Profession\ProfessionEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Pvp\PvpEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Quaggan\QuagganEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Race\RaceEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Raid\RaidEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Recipe\RecipeEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Skill\SkillEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Skin\SkinEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Specialization\SpecializationEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Story\StoryEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Title\TitleEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Tokeninfo\TokeninfoEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\Traits\TraitEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\World\WorldEndpoint;
use GW2Treasures\GW2Api\V2\Endpoint\WvW\WvWEndpoint;
use GW2Treasures\GW2Api\V2\IEndpoint;
use GW2Treasures\GW2Api\V2\Localization\LocalizationHandler;
use GW2Treasures\GW2Api\V2\Pagination\PaginationHandler;

class GW2Api {
    /** @var string $apiUrl */
    protected $apiUrl = 'https://api.guildwars2.com/';

    /** @var Client $client */
    protected $client;

    /** @var array $options */
    protected $options;

    /** @var array $handlers */
    protected $handlers = [];

    function __construct( array $options = [] ) {
        $this->options = $this->getOptions( $options );

        $this->extractCacertFile();

        $this->client = new Client( $this->options );

        $this->registerDefaultHandlers();
    }

    protected function getOptions( array $options = [] ) {
        $handler = isset($options['handler']) ? $options['handler'] : HandlerStack::create();
        $handler->push(EffectiveUrlMiddleware::middleware());

        return $options + [
           'base_uri' => $this->apiUrl,
           'handler' => $handler,
           'verify' => $this->getCacertFilePath()
        ];
    }

    /**
     * Returns the path to cacert.pem.
     *
     * @return string
     */
    protected function getCacertFilePath() {
        if( $this->isIncludedAsPhar() ) {
            return sys_get_temp_dir() . '/gw2api-cacert2.pem';
        } else {
            return __DIR__ . '/cacert.pem';
        }
    }

    /**
     * Copies the phar cacert from the phar into the temp directory.
     */
    protected function extractCacertFile() {
        if( $this->isIncludedAsPhar() ) {
            $cacertFilePath = $this->getCacertFilePath();

            if( !file_exists( $cacertFilePath )) {
                copy( __DIR__ . '/cacert.pem', $cacertFilePath );
            }
        }
    }

    /**
     * Checks if the library is included as phar file.
     *
     * @return bool
     */
    protected function isIncludedAsPhar() {
        return strpos( __FILE__, 'phar://' ) === 0;
    }

    /**
     * @param string $handler
     */
    public function registerHandler( $handler ) {
        if( is_null( $handler )) {
            throw new \InvalidArgumentException( '$handler can\'t be null' );
        }

        if( !is_string( $handler )) {
            throw new \InvalidArgumentException( '$handler has to be a string (class name of a valid ApiHandler)' );
        }

        $handlerClass = new \ReflectionClass( $handler );
        if( !$handlerClass->isSubclassOf( ApiHandler::class )) {
            throw new \InvalidArgumentException( '$handler has to be a ApiHandler');
        }

        $firstConstructorParameter = $handlerClass->getConstructor()->getParameters()[0];
        $this->handlers[ $handler ] = $firstConstructorParameter->getClass()->getName();
    }

    protected function registerDefaultHandlers() {
        $this->registerHandler(AuthenticationHandler::class);
        $this->registerHandler(LocalizationHandler::class);
        $this->registerHandler(PaginationHandler::class);
        $this->registerHandler(RestrictedGuildHandler::class);
    }

    public function getClient() {
        return $this->client;
    }

    public function account( $apiKey ) {
        return new AccountEndpoint( $this, $apiKey );
    }

    public function achievements() {
        return new AchievementEndpoint( $this );
    }

    public function backstory() {
        return new BackstoryEndpoint( $this );
    }

    public function build() {
        return new BuildEndpoint( $this );
    }

    public function characters( $apiKey ) {
        return new CharacterEndpoint( $this, $apiKey );
    }

    public function colors() {
        return new ColorEndpoint( $this );
    }

    public function commerce() {
        return new CommerceEndpoint( $this );
    }

    public function continents() {
        return new ContinentEndpoint( $this );
    }

    public function currencies() {
        return new CurrencyEndpoint( $this );
    }

    public function dungeons() {
        return new DungeonEndpoint( $this );
    }

    public function emblem() {
        return new EmblemEndpoint( $this );
    }

    public function files() {
        return new FileEndpoint( $this );
    }

    public function finishers() {
        return new FinisherEndpoint( $this );
    }

    public function gliders() {
        return new GliderEndpoint( $this );
    }

    public function guild() {
        return new GuildEndpoint( $this );
    }

    public function items() {
        return new ItemEndpoint( $this );
    }

    public function itemstats() {
        return new ItemstatEndpoint( $this );
    }

    public function legends() {
        return new LegendEndpoint( $this );
    }

    public function mailcarriers() {
        return new MailcarrierEndpoint($this);
    }

    public function maps() {
        return new MapEndpoint( $this );
    }

    public function masteries() {
        return new MasteryEndpoint( $this );
    }

    public function materials() {
        return new MaterialEndpoint( $this );
    }

    public function minis() {
        return new MiniEndpoint( $this );
    }

    public function mounts() {
        return new MountEndpoint( $this );
    }

    public function outfits() {
        return new OutfitEndpoint( $this );
    }

    public function pets() {
        return new PetEndpoint( $this );
    }

    public function professions() {
        return new ProfessionEndpoint( $this );
    }

    public function pvp() {
        return new PvpEndpoint( $this );
    }

    public function quaggans() {
        return new QuagganEndpoint( $this );
    }

    public function races() {
        return new RaceEndpoint( $this );
    }

    public function raids() {
        return new RaidEndpoint( $this );
    }

    public function recipes() {
        return new RecipeEndpoint( $this );
    }

    public function skills() {
        return new SkillEndpoint( $this );
    }

    public function skins() {
        return new SkinEndpoint( $this );
    }

    public function specializations() {
        return new SpecializationEndpoint( $this );
    }

    public function stories() {
        return new StoryEndpoint( $this );
    }

    public function titles() {
        return new TitleEndpoint( $this );
    }

    public function tokeninfo( $apiKey ) {
        return new TokeninfoEndpoint( $this, $apiKey );
    }

    public function traits() {
        return new TraitEndpoint( $this );
    }

    public function worlds() {
        return new WorldEndpoint( $this );
    }

    public function wvw() {
        return new WvWEndpoint( $this );
    }

    public function attachRegisteredHandlers( IEndpoint $endpoint ) {
        foreach( $this->handlers as $handler => $handles ) {
            if( is_a( $endpoint, $handles )) {
                $endpoint->attach( new $handler( $endpoint ) );
            }
        }
    }
}
