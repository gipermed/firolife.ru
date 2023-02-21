<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$PARTNER_ID = "prymery";
$PRYMERY_COMPONENT_NAME = 'PRYMERY.GEOIP.CITY';

$arComponentDescription = array(
    "NAME" => GetMessage($PRYMERY_COMPONENT_NAME."_COMPONENT_NAME"),
    "DESCRIPTION" => GetMessage($PRYMERY_COMPONENT_NAME."_COMPONENT_DESCRIPTION"),
    "ICON" => "",
    "PATH" => array(
        "ID" => $PARTNER_ID,
        "NAME" => GetMessage($PRYMERY_COMPONENT_NAME.'_DEVELOP_GROUP'),
        "CHILD" => array(
            "ID" => "location",
            "NAME" => GetMessage($PRYMERY_COMPONENT_NAME.'_LOCATION_COMPONENT_GROUP')
        )
    ),
);
unset($PARTNER_ID,$PRYMERY_COMPONENT_NAME);
