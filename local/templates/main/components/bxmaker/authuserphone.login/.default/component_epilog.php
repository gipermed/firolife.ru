<?php

if (!\defined("B_PROLOG_INCLUDED") || \B_PROLOG_INCLUDED !== \true) {
    die;
}
if ($arParams['IS_ENABLED_PHONE_MASK'] == 'Y') {
    \CJSCore::Init(['phone_number']);
}