/**
 * Cookie Consent plugin for Craft CMS
 *
 * Cookie Consent JS
 *
 * @author    acribis AG
 * @copyright Copyright (c) 2018 acribis AG
 * @link      https://acribis.ch/
 * @package   CookieConsent
 * @since     2.0.0-beta.1
 */

import _ from 'lodash';
import 'cookieconsent';
import 'cookieconsent/build/cookieconsent.min.css';

import '../css/cookieconsent.css';

window.addEventListener('load', () => {
    const defaults = {
        container: document.querySelector(cookieconsentConfig.container),
    };

    window.cc = window.cookieconsent.initialise(
        _.defaultsDeep(defaults, cookieconsentConfig),
    );
});
