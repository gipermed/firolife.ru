<?php


namespace Palladiumlab\Traits\Components;


use Bitrix\Main\ArgumentException;
use Bitrix\Main\Web\Json;
use CMain;

trait SendJson
{
    /**
     * @param callable|array $data
     */
    protected function successJson($data = []): void
    {
        $this->sendJson(array_merge(
            ['error' => ''],
            is_callable($data) ? (array)$data() : (array)$data,
            ['success' => true]
        ));
    }

    /**
     * @param callable|array $data
     */
    protected function sendJson($data = []): void
    {
        global $APPLICATION;

        $APPLICATION->RestartBuffer();
        /** @noinspection PhpStatementHasEmptyBodyInspection */
        /** @noinspection LoopWhichDoesNotLoopInspection */
        /** @noinspection MissingOrEmptyGroupStatementInspection */
        while (ob_end_clean()) {

        }

        header('Content-Type:application/json; charset=UTF-8');
        try {
            echo Json::encode(is_callable($data) ? (array)$data() : (array)$data);
        } catch (ArgumentException $e) {
            echo '{}';
        }

        CMain::FinalActions();
    }

    protected function errorJson(string $message): void
    {
        $this->sendJson(['success' => false, 'error' => $message]);
    }
}