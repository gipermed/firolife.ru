<?

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\Type;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CFavorites extends \CBitrixComponent
{
	const CACHE_PATH = "/" . SITE_ID . "/rngdv/" . __CLASS__ . "/";
	const COOKIE_NAME = 'CATALOG_FAV';

	const HL_ID = "ID";
	const HL_ITEM = "UF_ITEM_ID";
	const HL_USER = "UF_USER_ID";
	const HL_AUTH = "UF_IS_AUTHORIZED";
	const HL_DATE = "UF_DATETIME";

	const COMPONENT = "rngdvfavs";
	const ACTION_ADD = "add-to-fav";
	const ACTION_DEL = "del-from-fav";

	private $req;
	private $res;

	private $hlEntity;

	private $arFavs;
	private $userId;
	private $userIsAuthorized = false;

	public function onPrepareComponentParams($arParams)
	{
		$arParams["CACHE_TIME"] = (int)$arParams["CACHE_TIME"];

		if (!$arParams["FILTER_NAME"]) $arParams["FILTER_NAME"] = "arrFilter";

		return $arParams;
	}

	public function executeComponent()
	{
		$context = \Bitrix\Main\Application::getInstance()->getContext();
		$this->req = $context->getRequest();
		$this->res = $context->getResponse();


		$this->getUserID();

		$isAjax = $this->req->isAjaxRequest() && $this->req->get("component") === self::COMPONENT;

		$this->req->getCookie(self::COOKIE_NAME);


		if ($isAjax)
		{
			$GLOBALS["APPLICATION"]->RestartBuffer();

			$itemId = $this->req->get("id");
			$action = $this->req->get("action");

			switch ($action)
			{
				case self::ACTION_ADD:
					$this->addFav($itemId);
					break;
				case self::ACTION_DEL:
					$this->delFav($itemId);
					break;
				default:
					break;
			}

			$arItems = is_array($this->getFavList()) && count($this->getFavList()) ? array_keys($this->getFavList()) : [];

			echo json_encode($arItems);
			die();
		} else
		{
			$arItems = $this->getFavList();

			if (!$arItems) $arItems = [];


			$this->arResult = array(
				"COMPONENT"  => self::COMPONENT,
				"ACTION_ADD" => self::ACTION_ADD,
				"ACTION_DEL" => self::ACTION_DEL,
				"ITEMS"      => array_keys($arItems)
			);

			$filter = false;
			if (count($arItems))
			{
				$tmp = array_keys($arItems);
				if (count($tmp)) $filter = $tmp;
			}

			$GLOBALS[$this->arParams["FILTER_NAME"]] = array(
				"ID" => $filter
			);

			$this->includeComponentTemplate();
		}
	}

	private function getUserID()
	{
		$tempId = $this->req->getCookie(self::COOKIE_NAME);

		global $USER;
		if ($USER->IsAuthorized())
		{
			$this->userId = $USER->GetID();
			$this->userIsAuthorized = true;

			if ($tempId)
			{
				$this->moveToAuthUser($tempId);

				$cookie = new \Bitrix\Main\Web\Cookie(self::COOKIE_NAME, "", time() - 3600);
				$this->res->addCookie($cookie);
			}
		} else
		{
			if (!$tempId)
			{
				$tempId = md5(session_id());
				$cookie = new \Bitrix\Main\Web\Cookie(self::COOKIE_NAME, $tempId);
				$this->res->addCookie($cookie);
			}

			$this->userId = $tempId;
		}
	}

	public function moveToAuthUser($tempId)
	{

		$hlEntity = $this->getHlEntity();

		$arFilter = array(
			self::HL_AUTH => 0,
			self::HL_USER => $tempId,
		);

		$rs = $hlEntity::getList(array(
			"filter" => $arFilter
		));

		$arUpdate = array(
			self::HL_AUTH => 1,
			self::HL_USER => $this->userId,
		);


		while ($rw = $rs->fetch())
		{
			$hlEntity::update($rw[self::HL_ID], $arUpdate);
		}
	}


	private function getHlEntity()
	{
		if ($this->hlEntity) return $this->hlEntity;

		\CModule::IncludeModule('highloadblock');

		$name = $this->arParams["HL_ENTITY_NAME"];
		$filter = array("NAME" => $name);
		$query = array("filter" => $filter);
		$hldata = \Bitrix\Highloadblock\HighloadBlockTable::getList($query)->fetch();

		$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
		$this->hlEntity = $entity->getDataClass();

		return $this->hlEntity;
	}

	public function addFav($itemId)
	{
		if (!$itemId) return;

		$arFavs = $this->getFavList();
		if ($arFavs[$itemId]) return;

		$hlEntity = $this->getHlEntity();
		$hlEntity::add(array(
			self::HL_ITEM => $itemId,
			self::HL_USER => $this->userId,
			self::HL_AUTH => $this->userIsAuthorized,
			self::HL_DATE => \Bitrix\Main\Type\DateTime::createFromTimestamp(time()),
		));

		$this->dropFavCache();
	}

	private function getFavList()
	{
		if (!isset($this->arFavs))
		{
			$this->arFavs = $this->getFavListCached();
		}

		return $this->arFavs;
	}

	private function getFavListCached()
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();

		$cacheTtl = $this->arParams["CACHE_TIME"];
		$cacheId = $this->userId;
		$cachePath = self::CACHE_PATH;

		$value = array();

		if ($cache->initCache($cacheTtl, $cacheId, $cachePath))
		{
			$value = $cache->getVars();
		} elseif ($cache->startDataCache())
		{
			$value = $this->getFavListUncached();
			$cache->endDataCache($value);
		}

		return $value;
	}

	private function getFavListUncached()
	{
		$hlEntity = $this->getHlEntity();

		$arFilter = array(
			self::HL_USER => $this->userId,
		);

		$rs = $hlEntity::getList(array(
			"filter" => $arFilter
		));

		while ($rw = $rs->fetch())
		{
			$id = $rw[self::HL_ID];
			$itemId = (int)$rw[self::HL_ITEM];

			if ($itemId) $arFav[$itemId] = $id;
		}

		return $arFav;
	}

	private function dropFavCache()
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();
		$cache->clean($this->userId, self::CACHE_PATH);
		$this->arFavs = null;
	}

	private function delFav($itemId)
	{
		$arFavs = $this->getFavList();
		$id = $arFavs[$itemId];

		if ($id)
		{
			$hlEntity = $this->getHlEntity();
			$hlEntity::delete($id);

			$this->dropFavCache();
		}
	}


}