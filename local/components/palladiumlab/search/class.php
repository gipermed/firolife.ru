<?php

/**
 * @noinspection UnknownInspectionInspection
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpUnused
 */

check_prolog();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class SearchComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['SEARCH_PARAMETERS'] = is_array($arParams['SEARCH_PARAMETERS']) ? $arParams['SEARCH_PARAMETERS'] : [];

        return parent::onPrepareComponentParams($arParams);
    }


    /**
     * @return mixed|void|null
     * @throws Exception
     * @noinspection PhpReturnDocTypeMismatchInspection
     */
    public function executeComponent()
    {
        global $APPLICATION;

        ob_start();

        $result = $APPLICATION->IncludeComponent("bitrix:search.page", ".default", array_merge([
            "RESTART" => "Y",
            "CHECK_DATES" => "Y",
            "USE_TITLE_RANK" => "N",
            "USE_LANGUAGE_GUESS" => "N",
            "DEFAULT_SORT" => "rank",
            "PAGE_RESULT_COUNT" => "999999999",
        ], $this->arParams['SEARCH_PARAMETERS']));

        ob_get_clean();

        if (!is_array($result)) {
            $result = [$result];
        }

        $result = array_filter($result, static function ($id) {
            return $id && is_numeric($id);
        });

        /** @noinspection PhpRedundantOptionalArgumentInspection */
        $query = trim(htmlspecialchars($this->request['q'] ?? '', ENT_QUOTES, 'UTF-8', true));

        if ($this->arParams['SET_TITLE'] === 'Y') {
            $count = count($result);

            $countPlural = plural($count, ['результат', 'результата', 'результатов']);

            if (empty($result) && empty($query)) {
                $APPLICATION->SetPageProperty('title', 'Пустой поисковый запрос');
                $APPLICATION->SetTitle('Пустой поисковый запрос');
            } else {
                $APPLICATION->SetPageProperty('title', "{$count} {$countPlural} по поисковому запросу «{$query}»");
                $APPLICATION->SetTitle("{$count} {$countPlural} по поисковому запросу «{$query}»");
            }
        }

        return [
            'QUERY' => $query,

            'RESULT' => $result,
        ];
    }
}
