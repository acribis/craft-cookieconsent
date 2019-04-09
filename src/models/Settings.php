<?php
/**
 * Cookie Consent plugin for Craft CMS 3.x
 *
 * This is a generic Craft CMS plugin
 *
 * @link      https://acribis.ch/
 * @copyright Copyright (c) 2018 acribis AG
 */

namespace acribis\cookieconsent\models;

use acribis\cookieconsent\CookieConsent;

use Craft;
use craft\base\Model;

/**
 * CookieConsent Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    acribis AG
 * @package   CookieConsent
 * @since     2.0.0-beta.1
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Set the positioning of the popup on the screen
     *
     * @var string
     */
    public $position = 'bottom';

    /**
     * The display style of the popup
     *
     * @var string
     */
    public $layout = 'block';

    /**
     * Popup background color
     *
     * @var string
     */
    public $paletteBanner = '#000000';

    /**
     * Button background color
     *
     * @var string
     */
    public $paletteButton = '#f1d600';

    /**
     * Popup text color
     *
     * @var string
     */
    public $paletteBannerText = '#ffffff';

    /**
     * Button text color
     *
     * @var string
     */
    public $paletteButtonText = '#000000';

    /**
     * The compliance type
     *
     * @var string
     */
    public $type = '';

    /**
     * Toggle the show more link
     *
     * @var bool
     */
    public $showLink = true;

    /**
     * The learn more target as either an url or entry id
     *
     * @var string|int
     */
    public $learnMoreLink = 'http://cookiesandyou.com/';

    /**
     * The id of the element the popup should attach to
     *
     * @var string
     */
    public $containerSelector;

    /**
     * CSS injected into the page
     *
     * @var string
     */
    public $css;

    /**
     * The notification message
     *
     * @var string
     */
    public $message = 'This website uses cookies to ensure you get the best experience on our website.';

    /**
     * The learn more link text
     *
     * @var string
     */
    public $learnMore = 'Learn More';

    /**
     * The dismiss button text
     *
     * @var string
     */
    public $dismiss = 'Dismiss Notification';

    /**
     * The allow button text
     *
     * @var string
     */
    public $allow = 'Allow Cookies';

    /**
     * The decline button text
     *
     * @var string
     */
    public $deny = 'Decline';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'position',
                    'layout',
                    'paletteBanner',
                    'paletteButton',
                    'paletteBannerText',
                    'paletteButtonText',
                    'message',
                    'learnMore',
                    'dismiss',
                    'allow',
                    'deny',
                ],
                'required',
            ],
            [
                [
                    'position',
                    'layout',
                    'paletteBanner',
                    'paletteButton',
                    'paletteBannerText',
                    'paletteButtonText',
                    'type',
                    'containerSelector',
                    'css',
                    'message',
                    'learnMore',
                    'dismiss',
                    'allow',
                    'deny',
                ],
                'string',
            ],
            ['showLink', 'boolean'],
        ];
    }
}
