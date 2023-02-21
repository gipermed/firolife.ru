<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
    'NAME' => 'User password restore',
    'DESCRIPTION' => '',
    'PATH' => array(
        'ID' => 'utility',
        'CHILD' => array(
            'ID' => 'user',
            'NAME' => 'User password restore'
        ),
    ),
);