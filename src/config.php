<?php
/**
 * Cookie Consent plugin for Craft CMS 3.x
 *
 * This is a generic Craft CMS plugin
 *
 * @link      https://acribis.ch/
 * @copyright Copyright (c) 2018 acribis AG
 */

/**
 * Cookie Consent config.php
 *
 * This file exists only as a template for the Cookie Consent settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'cookie-consent.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    'message' => array(
        'en' => 'This website uses cookies to ensure you get the best experience on our website.',
        'de' => 'Diese Website verwendet Cookies um sicherzustellen, dass Sie die beste Erfahrung auf unserer Website erhalten.',
        'fr' => 'Ce site utilise des cookies pour vous assurer la meilleure expérience sur notre site.',
        'es' => 'Este sitio web utiliza cookies para garantizar que obtenga la mejor experiencia en nuestro sitio web.',
    ),

    'learnMoreLinkText' => array(
        'en' => 'Learn More',
        'de' => 'Erfahren Sie mehr',
        'fr' => 'Apprendre encore plus',
        'es' => 'Aprende más',
    ),

    'dismiss' => array(
        'en' => 'Dismiss Notification',
        'de' => 'Hinweis ausblenden',
        'fr' => 'Masquer la notification',
        'es' => 'Descartar la notificación',
    ),

    'allow' => array(
        'en' => 'Allow Cookies',
        'de' => 'Cookies zulassen',
        'fr' => 'Autorise les cookies',
        'es' => 'Permitir cookies',
    ),

    'deny' => array(
        'en' => 'Decline',
        'de' => 'Ablehnen',
        'fr' => 'Déclin',
        'es' => 'Disminución',
    ),
];
