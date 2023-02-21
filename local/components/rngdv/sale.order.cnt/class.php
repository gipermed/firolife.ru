<?

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\Type;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class COrderCount extends \CBitrixComponent
{
	const CACHE_PATH = "/" . SITE_ID . "/rngdv/" . __CLASS__ . "/";


	public function executeComponent()
	{
		return $this->getResultCached();
	}


	private function getResultCached()
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();

		$cacheTtl = 360;
		$cacheId = md5($GLOBALS["USER"]->GetID());
		$cachePath = self::CACHE_PATH;

		$value = array();

		if ($cache->initCache($cacheTtl, $cacheId, $cachePath))
		{
			$value = $cache->getVars();
		} elseif ($cache->startDataCache())
		{
			$value = $this->getResult();
			$cache->endDataCache($value);
		}

		return $value;
	}

	private function getResult()
	{
		\Bitrix\Main\Loader::includeModule('sale');

		$filter = [
			"USER_ID" => $GLOBALS["USER"]->GetID(),
			"LID"     => SITE_ID,
		];

		$rs = CSaleOrder::GetList([], $filter, ["COUNT"]);

		return $rs->SelectedRowsCount();
	}


}