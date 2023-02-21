<?php


namespace Palladiumlab\DetailUrl;
use Bitrix\Iblock\EO_Element_Entity;
use Bitrix\Main\Entity\ExpressionField;

class ExtenderHelper
{

	public static function extendPathFields( $elementEntity)
	{
		$elementEntity->addField(
			new ExpressionField(
				'SECTION_CODE_PATH',
				'
				CONCAT(
					COALESCE(%s,""),"/",
					COALESCE(%s,""),"/",
					COALESCE(%s,""),"/",
					COALESCE(%s,""),"/",
					COALESCE(%s,""),"/"
				)',
				[
					'IBLOCK_SECTION.PARENT_SECTION.PARENT_SECTION.PARENT_SECTION.PARENT_SECTION.CODE',
					'IBLOCK_SECTION.PARENT_SECTION.PARENT_SECTION.PARENT_SECTION.CODE',
					'IBLOCK_SECTION.PARENT_SECTION.PARENT_SECTION.CODE',
					'IBLOCK_SECTION.PARENT_SECTION.CODE',
					'IBLOCK_SECTION.CODE',
				]
			)
		);
		$elementEntity->addField(
			new ExpressionField(
				'DETAIL_PAGE_URL',
				'
        REPLACE(
            REPLACE(
                REPLACE(
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(
                                        %s, "#ID#", %s
                                    ), "#ELEMENT_CODE#", %s
                                ), "#SECTION_CODE_PATH#", %s
                            ), "#SITE_DIR#", ""
                        ), "//", "/"
                    ), "//", "/"
                ), "//", "/"
            ), "//", "/"
        )',
				['IBLOCK.DETAIL_PAGE_URL', 'ID', 'CODE', 'SECTION_CODE_PATH']
			)
		);
	}
}