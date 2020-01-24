<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id'          => 'oabirthday',
    'title'       => [
        'de' => 'Geburtstagsgruss',
        'en' => 'Birthday wishes',
    ],
    'description' => [
        'de' => 'Das Modul zeigt einen Geburtstagsgruss',
        'en' => 'This module shows a greeting on the users birthday',
    ],
    'thumbnail'   => '',
    'version'     => '1.0',
    'author'      => 'wgmv',
    'url'         => '',
    'email'       => '',
    'extend'      => [
        OxidEsales\Eshop\Application\Model\User::class => \OxidAcademy\Birthday\Model\User::class,
        OxidEsales\Eshop\Application\Model\VoucherSerie::class => \OxidAcademy\Birthday\Model\VoucherSerie::class,
        OxidEsales\Eshop\Application\Model\Basket::class => \OxidAcademy\Birthday\Model\Basket::class,
        OxidEsales\Eshop\Application\Model\Voucher::class => \OxidAcademy\Birthday\Model\Voucher::class,
    ],
    'blocks'      => [
        [
            'template' => 'page/shop/start.tpl',
            'block'    => 'start_welcome_text',
            'file'     => 'views/blocks/start__start_welcome_text.tpl',
        ],
    ],
    'settings'    => [
        [
            'group' => 'oabirthday_settings',
            'name' => 'blOaBirthdayWishes',
            'type' => 'str',
            'value' => 'Happy Birthday'
        ],
        [
            'group' => 'oabirthday_settings',
            'name' => 'oaVoucherSeriesId',
            'type' => 'str',
            'value' => ''
        ],
    ],
    'events'      => [
    ],
];
