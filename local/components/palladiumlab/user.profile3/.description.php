<?php check_prolog();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
    'NAME' => 'User profile',
    'DESCRIPTION' => '',
    'PATH' => array(
        'ID' => 'utility',
        'CHILD' => array(
            'ID' => 'user',
            'NAME' => 'User profile'
        ),
    ),
);