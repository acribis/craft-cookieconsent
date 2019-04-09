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

use acribis\cookieconsent\assetbundles\CookieConsent\CookieConsentAsset;
use acribis\cookieconsent\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\elements\Entry;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;
use yii\base\InvalidConfigException;

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
        $request = Craft::$app->getRequest();

        // Register asset bundle only for non-console site requests
        if ($request->getIsSiteRequest() && !$request->getIsConsoleRequest()) {
            $this->registerFrontendAssets();
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
            Craft::t('cookie-consent', '{name} plugin loaded', [
                'name' => $this->name,
            ]),
            __METHOD__
        );
    }

    /**
     * @throws InvalidConfigException
     */
    public function registerFrontendAssets()
    {
        Craft::$app->view->registerAssetBundle(CookieConsentAsset::class);
        Craft::$app->view->registerCss($this->settings->css);

        Craft::$app->view->registerJsVar('cookieconsentConfig', [
            'container' => $this->settings->containerSelector,
            'palette' => [
                'popup' => [
                    'background' => $this->getSettings()->paletteBanner,
                    'text' => $this->getSettings()->paletteBannerText,
                ],
                'button' => [
                    'background' =>
                        $this->getSettings()->layout === 'wire'
                            ? 'transparent'
                            : $this->getSettings()->paletteButton,
                    'text' =>
                        $this->getSettings()->layout === 'wire'
                            ? $this->getSettings()->paletteButton
                            : $this->getSettings()->paletteButtonText,
                    'border' =>
                        $this->getSettings()->layout === 'wire'
                            ? $this->getSettings()->paletteButton
                            : 'undefined',
                ],
            ],
            'theme' => $this->getSettings()->layout,
            'showLink' => $this->getSettings()->showLink,
            'position' =>
                $this->getSettings()->position === 'toppush'
                    ? 'top'
                    : $this->getSettings()->position,
            'static' => $this->getSettings()->position === 'toppush',
            'law' => [
                'regionalLaw' => false,
            ],
            'type' => $this->settings->type,
            'content' => [
                'message' => Craft::t(
                    'cookie-consent',
                    $this->settings->message
                ),
                'link' => Craft::t(
                    'cookie-consent',
                    $this->settings->learnMore
                ),
                'href' => is_string($this->settings->learnMoreLink)
                    ? $this->settings->learnMoreLink
                    : Entry::find()
                            ->id($this->settings->learnMoreLink)
                            ->one()->url ?? null,
                'dismiss' => Craft::t(
                    'cookie-consent',
                    $this->settings->dismiss
                ),
                'allow' => Craft::t('cookie-consent', $this->settings->allow),
                'deny' => Craft::t('cookie-consent', $this->settings->deny),
            ],
        ]);
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
        return Craft::$app->view->renderTemplate('cookie-consent/settings', [
            'settings' => CookieConsent::getSettings(),
        ]);
    }
}
