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
     * Some field model attribute
     *
     * @var string
     */
    public $someAttribute = 'Some Default';

    public $position = 'bottom';
    public $layout = 'block';
    public $paletteBanner = '#000000';
    public $paletteButton = '#f1d600';
    public $paletteBannerText = '#ffffff';
    public $paletteButtonText = '#000000';
    public $showLink = true;
    public $learnMoreLink = 'http://cookiesandyou.com/';
    public $css;

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
            [['someAttribute', 'position', 'layout', 'paletteBanner', 'paletteButton', 'paletteBannerText', 'paletteButtonText', 'css'], 'string'],
            ['showLink', 'boolean'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
