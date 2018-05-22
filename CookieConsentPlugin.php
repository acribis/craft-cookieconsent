<?php
/**
 * Cookie Consent plugin for Craft CMS
 *
 * This is a generic Craft CMS plugin
 *
 * --snip--
 * Craft plugins are very much like little applications in and of themselves. We’ve made it as simple as we can,
 * but the training wheels are off. A little prior knowledge is going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL, as well as some semi-
 * advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 * --snip--
 *
 * @author    acribis AG
 * @copyright Copyright (c) 2018 acribis AG
 * @link      https://acribis.ch/
 * @package   CookieConsent
 * @since     0.1.0
 */

namespace Craft;

class CookieConsentPlugin extends BasePlugin
{
    /**
     * Called after the plugin class is instantiated; do any one-time initialization here such as hooks and events:
     *
     * craft()->on('entries.saveEntry', function(Event $event) {
     *    // ...
     * });
     *
     * or loading any third party Composer packages via:
     *
     * require_once __DIR__ . '/vendor/autoload.php';
     *
     * @return mixed
     */
    public function init()
    {
        parent::init();

        if (!craft()->request->isCpRequest() && !craft()->request->isAjaxRequest) {
            craft()->templates->includeCssFile('//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css');
            craft()->templates->includeJsFile('//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js');

            $configuration = [
                'palette' => [
                    'popup' => [
                        'background' => $this->getSettings()->paletteBanner,
                        'text' => $this->getSettings()->paletteBannerText,
                    ],
                    'button' => [
                        'background' => ($this->getSettings()->layout === 'wire' ? 'transparent' : $this->getSettings()->paletteButton),
                        'text' => ($this->getSettings()->layout === 'wire' ? $this->getSettings()->paletteButton : $this->getSettings()->paletteButtonText),
                        'border' => ($this->getSettings()->layout === 'wire' ? $this->getSettings()->paletteButton : 'undefined'),
                    ],
                ],
                'theme' => $this->getSettings()->layout,
                'showLink' => $this->getSettings()->learnMoreLink !== '',
                'position' => ($this->getSettings()->position === 'toppush' ? 'top' : $this->getSettings()->position),
                'static' => $this->getSettings()->position === 'toppush',
                'content' => [
                    'message' => Craft::t($this->getSettings()->message),
                    'dismiss' => Craft::t($this->getSettings()->dismiss),
                    'allow' => Craft::t($this->getSettings()->allow),
                    'link' => Craft::t($this->getSettings()->learnMoreLinkText),
                    'href' => $this->getSettings()->learnMoreLink,
                ],
                'law' => [
                    'regionalLaw' => false,
                ],
            ];

            $initScript = 'window.addEventListener("load", function(){window.cookieconsent.initialise(' . json_encode((array) $configuration) . ');});';
            craft()->templates->includeJs($initScript);
        }
    }

    /**
     * Returns the user-facing name.
     *
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Cookie Consent');
    }

    /**
     * Plugins can have descriptions of themselves displayed on the Plugins page by adding a getDescription() method
     * on the primary plugin class:
     *
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('This is a generic Craft CMS plugin');
    }

    /**
     * Plugins can have links to their documentation on the Plugins page by adding a getDocumentationUrl() method on
     * the primary plugin class:
     *
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/acribis/cookieconsent/blob/master/README.md';
    }

    /**
     * Plugins can now take part in Craft’s update notifications, and display release notes on the Updates page, by
     * providing a JSON feed that describes new releases, and adding a getReleaseFeedUrl() method on the primary
     * plugin class.
     *
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/acribis/cookieconsent/master/releases.json';
    }

    /**
     * Returns the version number.
     *
     * @return string
     */
    public function getVersion()
    {
        return '0.1.0';
    }

    /**
     * As of Craft 2.5, Craft no longer takes the whole site down every time a plugin’s version number changes, in
     * case there are any new migrations that need to be run. Instead plugins must explicitly tell Craft that they
     * have new migrations by returning a new (higher) schema version number with a getSchemaVersion() method on
     * their primary plugin class:
     *
     * @return string
     */
    public function getSchemaVersion()
    {
        return '0.1.0';
    }

    /**
     * Returns the developer’s name.
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'acribis AG';
    }

    /**
     * Returns the developer’s website URL.
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'https://acribis.ch/';
    }

    /**
     * Returns whether the plugin should get its own tab in the CP header.
     *
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     * Called right before your plugin’s row gets stored in the plugins database table, and tables have been created
     * for it based on its records.
     */
    public function onBeforeInstall()
    {
    }

    /**
     * Called right after your plugin’s row has been stored in the plugins database table, and tables have been
     * created for it based on its records.
     */
    public function onAfterInstall()
    {
    }

    /**
     * Called right before your plugin’s record-based tables have been deleted, and its row in the plugins table
     * has been deleted.
     */
    public function onBeforeUninstall()
    {
    }

    /**
     * Called right after your plugin’s record-based tables have been deleted, and its row in the plugins table
     * has been deleted.
     */
    public function onAfterUninstall()
    {
    }

    /**
     * Defines the attributes that model your plugin’s available settings.
     *
     * @return array
     */
    protected function defineSettings()
    {
        return array(
            // todo Translate default values
            'position' => [AttributeType::String, 'default' => 'bottom'],
            'layout' => [AttributeType::String, 'default' => 'block'],
            'paletteBanner' => [AttributeType::String, 'default' => '#000000'],
            'paletteButton' => [AttributeType::String, 'default' => '#f1d600'],
            'paletteBannerText' => [AttributeType::String, 'default' => '#ffffff'],
            'paletteButtonText' => [AttributeType::String, 'default' => '#000000'],
            'learnMoreLink' => [AttributeType::String, 'default' => 'http://cookiesandyou.com/'],
            'learnMoreLinkText' => [AttributeType::String, 'default' => 'Learn More'],
            'message' => [AttributeType::String, 'default' => 'This website uses cookies to ensure you get the best experience on our website.'],
            'dismiss' => [AttributeType::String, 'default' => 'Got it!'],
            'allow' => [AttributeType::String, 'default' => 'Allow cookies'],
            'deny' => [AttributeType::String, 'default' => 'Decline'],
        );
    }

    /**
     * Returns the HTML that displays your plugin’s settings.
     *
     * @return mixed
     */
    public function getSettingsHtml()
    {
       return craft()->templates->render('cookieconsent/CookieConsent_Settings', array(
           'settings' => $this->getSettings()
       ));
    }

    /**
     * If you need to do any processing on your settings’ post data before they’re saved to the database, you can
     * do it with the prepSettings() method:
     *
     * @param mixed $settings  The plugin's settings
     *
     * @return mixed
     */
    public function prepSettings($settings)
    {
        // Modify $settings here...

        return $settings;
    }

}