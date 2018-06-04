<?php
/**
 * Cookie Consent plugin for Craft CMS 3.x
 *
 * This is a generic Craft CMS plugin
 *
 * @link      https://acribis.ch/
 * @copyright Copyright (c) 2018 acribis AG
 */

namespace acribis\cookieconsent;

use acribis\cookieconsent\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\helpers\ConfigHelper;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    acribis AG
 * @package   CookieConsent
 * @since     2.0.0-beta.1
 *
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class CookieConsent extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * CookieConsent::$plugin
     *
     * @var CookieConsent
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '2.0.0-beta.1';

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * CookieConsent::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        $config = Craft::$app->config->getConfigFromFile($this->handle);

        if (!Craft::$app->request->isCpRequest && !Craft::$app->request->isAjax) {
            Craft::$app->view->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css');
            Craft::$app->view->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js');

            $message = ConfigHelper::localizedValue($config['message'], Craft::$app->locale->id);

            $configuration = [
                'palette' => [
                    'popup' => [
                        'background' => CookieConsent::getSettings()->paletteBanner,
                        'text' => CookieConsent::getSettings()->paletteBannerText,
                    ],
                    'button' => [
                        'background' => (CookieConsent::getSettings()->layout === 'wire' ? 'transparent' : CookieConsent::getSettings()->paletteButton),
                        'text' => (CookieConsent::getSettings()->layout === 'wire' ? CookieConsent::getSettings()->paletteButton : CookieConsent::getSettings()->paletteButtonText),
                        'border' => (CookieConsent::getSettings()->layout === 'wire' ? CookieConsent::getSettings()->paletteButton : 'undefined'),
                    ],
                ],
                'theme' => CookieConsent::getSettings()->layout,
                'showLink' => CookieConsent::getSettings()->showLink,
                'position' => (CookieConsent::getSettings()->position === 'toppush' ? 'top' : CookieConsent::getSettings()->position),
                'static' => CookieConsent::getSettings()->position === 'toppush',
                'content' => [
                    'message' => ConfigHelper::localizedValue($config['message'], Craft::$app->locale->id),
                    'dismiss' => ConfigHelper::localizedValue($config['dismiss'], Craft::$app->locale->id),
                    'allow' => ConfigHelper::localizedValue($config['allow'], Craft::$app->locale->id),
                    'deny' => ConfigHelper::localizedValue($config['deny'], Craft::$app->locale->id),
                    'link' => ConfigHelper::localizedValue($config['learnMoreLinkText'], Craft::$app->locale->id),
                    'href' => (CookieConsent::getSettings()->learnMoreLink === '' ? ConfigHelper::localizedValue($config['link'], Craft::$app->locale->id) : Craft::$app->elements->getElementById(CookieConsent::getSettings()->learnMoreLink[0])->getUrl()),
                ],
                'law' => [
                    'regionalLaw' => false,
                ],
                'onPopupOpen' => 'function() {
                    if (window.innerWidth >= 415) {
                        window.cookieconsent.utils.isMobile = () => false;
                    }
                }',
            ];

            Craft::$app->view->registerJs('window.addEventListener("load", function(){window.cookieconsent.initialise(' . json_encode((array) $configuration) . ');});');
        }

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

/**
 * Logging in Craft involves using one of the following methods:
 *
 * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
 * Craft::info(): record a message that conveys some useful information.
 * Craft::warning(): record a warning message that indicates something unexpected has happened.
 * Craft::error(): record a fatal error that should be investigated as soon as possible.
 *
 * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
 *
 * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
 * the category to the method (prefixed with the fully qualified class name) where the constant appears.
 *
 * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
 * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
 *
 * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
 */
        Craft::info(
            Craft::t(
                'cookie-consent',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'cookie-consent/settings',
            [
                'settings' => CookieConsent::getSettings()
            ]
        );
    }
}
