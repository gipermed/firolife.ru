<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


use \Bitrix\Main;
use \Bitrix\Main\Application;
use \Bitrix\Main\Entity\ExpressionField;
use \Bitrix\Highloadblock\HighloadBlockTable;

class CReviewsList extends CBitrixComponent
{
	const CACHE_PATH = "/" . SITE_ID . "/rngdv/" . __CLASS__ . "/";

	private $hlRates = false;
	private $req;


	public function executeComponent()
	{
		$this->req = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

		$isAjax = $this->req->isAjaxRequest();
		$action = $this->req->get("action");

		$this->arResult["AJAX_URL"] = $this->getAjaxPath();


		if ($isAjax)
		{
			switch ($action)
			{
				case "popup":
					$this->IncludeComponentTemplate("template_popup");
					break;

				case "submit":
					$this->processForm();
					break;

				case "rate":
					$this->processReviewRate();
					break;

				default:
					$this->getList();
					$this->IncludeComponentTemplate("template_list");
					break;
			}
		} else
		{
			$this->arResult["SUMMARY"] = $this->getSummary();
			$this->arResult["AJAX_URL"] = $this->getAjaxPath();

			$this->IncludeComponentTemplate();
		}
	}


	private function getAjaxPath()
	{
		return str_replace($_SERVER["DOCUMENT_ROOT"], "", __DIR__) . "/ajax.php";
	}


	private function processForm()
	{
//		var_dump($_FILES);
//		var_dump($_REQUEST);
		$errors = [];


		global $USER;

		if (!$USER->IsAuthorized())
		{
			$errors[] = "Чтобы оставить отзыв необходимо авторизоваться";
		}


		$rate = (int)$this->req->get("rate");
		$target = (int)$this->req->get("target");
		$advantages = trim($this->req->get("advantages"));
		$disadvantages = trim($this->req->get("disadvantages"));
		$comment = trim($this->req->get("comment"));


		if (!$rate) $errors[] = "Оцените товар";
		if (!$target) $errors[] = "Ошибка в выборе";
//		if ( !$advantages ) $errors[] = "Укажите достоинства товара";
//		if ( !$disadvantages ) $errors[] = "Укажите недостатки товара";

//		if ( !$email ) $errors[] = "Введите E-mail";
//		if ( !$phone ) $errors[] = "Введите контактный телефон";


		if (count($errors))
		{
			echo json_encode([
				"success" => false,
				"errors"  => $errors
			]);
			die();
		}

		\CModule::IncludeModule("iblock");
		$cibe = new \CIBlockElement();

		$id = $cibe->Add([
			"NAME"            => $USER->GetFullName(),
			"PREVIEW_TEXT"    => $advantages,
			"DETAIL_TEXT"     => $disadvantages,
			"IBLOCK_ID"       => 6,
			"PROPERTY_VALUES" => [
				"USER"        => $USER->GetID(),
				"TARGET"      => $target,
				"TARGET_RATE" => $rate,
				"COMMENT"     => [
					"TEXT" => $comment,
					"TYPE" => "text"
				]
			]
		]);

		$res = $id ? ["success" => true] : [
			"success" => false,
			"errors"  => [$cibe->LAST_ERROR]
		];

		if ($res["success"])
		{
			$to = "alteross13@ya.ru";
			$subject = "Новый отзыв на сайте gipermed.com";

			$el = \CIBlockElement::GetList([], ["ID" => $target])->GetNext();
			$publicProductUrl = "https://gipermed.com" . $el["DETAIL_PAGE_URL"];
			$privateProductUrl = "https://gipermed.com/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=1&type=ru&ID=$target";
			$privateReviewUrl = "https://gipermed.com/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=6&type=ru&ID=$id";


			$message = "<b>Достоинства:</b>$advantages<br><br>" . "<b>Недостатки:</b>$disadvantages<br><br>" . "<b>Комментарий:</b>$comment<br><br>" . "<a href='$privateReviewUrl'>Отзыв в админке:</a><br>" . "<a href='$privateProductUrl'>Товар в админке:</a><br>" . "<a href='$publicProductUrl'>Товар на сайте:</a><br>" . "<b>НЕ ЗАБУДЬТЕ СБРОСИТЬ КЕШ НА СТРАНИЦЕ ТОВАРА!</b>";

			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			mail($to, $subject, $message, $headers);
		}

		echo json_encode($res);
		die();
	}

	private function processReviewRate()
	{
		$reviewId = (int)$this->req->get("id");
		$targetId = $this->req->get("target");
		$rate = $this->req->get("rate") === "good";
		$active = $this->req->get("active") === "y";


		$userId = $_COOKIE["BX_USER_ID"];
		if (!$userId) return;
		if (!$reviewId) return;
		if (!$targetId) return;


		$hlRates = $this->getHlRates();

		$rs = $hlRates::getList([
			"select" => ["*"],
			"filter" => [
				"UF_USER_ID"   => $userId,
				"UF_REVIEW_ID" => $reviewId
			]
		]);

		//		if	set any rate 	&&	rates are equal			do nothing
		//		if	drop any rate 	&& 	rates are not equal 	do nothing	error
		//		if 	drop any rate 	&&	rate is not exists		do nothing

		//		if	set any rate	&&	rates are not equal		update
		//		if	drop any rate 	&&	rates are equal			delete
		//		if 	set any rate 	&&	rate is not exists		create

		$err = false;
		if ($rw = $rs->fetch())
		{
			$id = $rw["ID"];
			$oldRate = $rw["UF_RATE"];

			if ($active)
			{
				if ($rate != $oldRate)
				{
					$hlRates::update($id, ["UF_RATE" => $rate]);
				}
			} else
			{
				if ($rate == $oldRate)
				{
					$hlRates::delete($id);
				} else
				{
					$err = true;
				}
			}
		} else
		{
			if ($active)
			{
				$hlRates::add([
					"UF_USER_ID"   => $userId,
					"UF_REVIEW_ID" => $reviewId,
					"UF_RATE"      => $rate
				]);
			}
		}

		Application::getInstance()->getTaggedCache()->clearByTag("review_target_rates_$targetId");


		$rs = $hlRates::getList([
			"select"  => [
				"UF_RATE",
				"CNT"
			],
			"filter"  => ["UF_REVIEW_ID" => $reviewId],
			"group"   => [
				"UF_REVIEW_ID",
				"UF_RATE"
			],
			"runtime" => [new ExpressionField("CNT", "COUNT(*)")]
		]);

		$res = [
			"good" => 0,
			"bad"  => "0"
		];
		while ($row = $rs->fetch())
		{
			$rate = $row["UF_RATE"] ? "good" : "bad";
			$cnt = $row["CNT"];

			$res[$rate] = $cnt;
		}

		$GLOBALS["APPLICATION"]->RestartBuffer();
		echo json_encode([
			"rates"  => $res,
			"errCnt" => $err
		]);
		die();
	}

	private function getHlRates()
	{
		if ($this->hlRates) return $this->hlRates;

		CModule::IncludeModule('highloadblock');

		$filter = ["TABLE_NAME" => "hl_review_rates"];
		$query = ["filter" => $filter];
		$hldata = HighloadBlockTable::getList($query)->fetch();
		$entity = HighloadBlockTable::compileEntity($hldata);
		$this->hlRates = $entity->getDataClass();
		return $this->hlRates;
	}

	private function getList()
	{
		$this->arResult = $this->getReviews();

		$this->getPersonalRates();
		$rates = $this->getRates();

		foreach ($rates as $id => $item)
		{
			$this->arResult["ITEMS"][$id]["RATES"] = $item;
		}
	}

	private function getReviews()
	{
		$arNavParams = ["nPageSize" => $this->arParams["ITEMS_COUNT"]];
		if (!$this->req->get("navNum")) $arNavParams["iNumPage"] = 1;

		$sort = $this->req->get("sort") ?: $this->arParams["SORT"][0]["CODE"];

		$cache = \Bitrix\Main\Data\Cache::createInstance();

		$cacheTtl = $this->arParams["CACHE_TIME"];
		$cachePath = self::CACHE_PATH . $this->arParams["TARGET"] . "/";
		$cacheId = md5(serialize([
			$this->arParams,
			$sort,
			CDBResult::GetNavParams($arNavParams)
		]));

		$value = [];


		if ($cache->initCache($cacheTtl, $cacheId, $cachePath))
		{
			$value = $cache->getVars();
			//var_dump(["from cache"]);
		} elseif ($cache->startDataCache())
		{
			$value = $this->getReviewsRaw($arNavParams, $sort);
			//var_dump(["HOT"]);

			$cache_manager = \Bitrix\Main\Application::getInstance()->getTaggedCache();
			$cache_manager->startTagCache($cachePath);
			$cache_manager->registerTag("review_target_" . $this->arParams["TARGET"]); //clearByTag
			$cache_manager->endTagCache();

			$cache->endDataCache($value);
		}

		return $value;
	}

	private function getReviewsRaw($arNavParams, $sort)
	{
		\CModule::IncludeModule("iblock");
		$arResult = ["ITEMS" => []];

		foreach ($this->arParams["SORT"] as $arSort)
		{
			if ($arSort["CODE"] === $sort) break;
		}

		$arSort = [
			$arSort["PARAM"] => $arSort["ORDER"]
		];
		$arFilter = [
			"IBLOCK_ID"              => $this->arParams["IBLOCK_ID"],
			"ACTIVE"                 => "Y",
			"!PROPERTY_IS_PUBLISHED" => false,
			"PROPERTY_TARGET"        => $this->arParams["TARGET"]
		];


		$rs = \CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams);

		while ($el = $rs->GetNextElement())
		{
			$arItem = $el->GetFields();
			$id = $arItem["ID"];
			$arItem["PROPERTIES"] = $el->GetProperties();

			$arResult["ITEMS"][$id] = $arItem;
		}


		$navComponentObject = false;
		$arResult["NAV_STRING"] = $rs->GetPageNavStringEx($navComponentObject, $this->arParams["PAGER_TITLE"], $this->arParams["PAGER_TEMPLATE"], false, null, []);


		$arResult["PAGEN_TEMPLATE"] = $navComponentObject->__template->__folder;
		$arResult["NAV_NUM"] = $rs->NavNum;
		$arResult["PAGE_NUM"] = $rs->NavPageNomer;

		$arResult["AJAX_URL"] = $this->getAjaxPath();

		return $arResult;
	}

	private function getPersonalRates()
	{
		$userId = $_COOKIE["BX_USER_ID"];
		if (!$userId) return;

		$hlRates = $this->getHlRates();

		$rs = $hlRates::getList([
			"select" => [
				"UF_REVIEW_ID",
				"UF_RATE"
			],
			"filter" => [
				"UF_USER_ID"   => $userId,
				"UF_REVIEW_ID" => array_keys($this->arResult["ITEMS"])
			]
		]);

		$res = [];
		while ($row = $rs->fetch())
		{
			$id = $row["UF_REVIEW_ID"];
			$rate = $row["UF_RATE"];


			$this->arResult["ITEMS"][$id]["PERSONAL_RATE"] = $rate ? "Y" : "N";
		}

		return $res;
	}

	private function getRates()
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();

		$cacheTtl = $this->arParams["CACHE_TIME"];
		$cachePath = self::CACHE_PATH . $this->arParams["TARGET"] . "_" . $this->arResult["PAGE_NUM"] . "/";
		$cacheId = md5(serialize(array_keys($this->arResult["ITEMS"])));

		$value = [];

		if ($cache->initCache($cacheTtl, $cacheId, $cachePath))
		{
			$value = $cache->getVars();
//			var_dump([ "rates cache" ]);
		} elseif ($cache->startDataCache())
		{
			$value = $this->getRatesRaw();
//			var_dump([ "rates HOT" ]);

			$cache_manager = Application::getInstance()->getTaggedCache();
			$cache_manager->startTagCache($cachePath);
			$cache_manager->registerTag("review_target_rates_" . $this->arParams["TARGET"]);
			$cache_manager->endTagCache();

			$cache->endDataCache($value);
		}

		return $value;
	}

	private function getRatesRaw()
	{
		$hlRates = $this->getHlRates();

		$rs = $hlRates::getList([
			"select"  => [
				"UF_REVIEW_ID",
				"UF_RATE",
				"CNT"
			],
			"filter"  => ["UF_REVIEW_ID" => array_keys($this->arResult["ITEMS"])],
			"group"   => [
				"UF_REVIEW_ID",
				"UF_RATE"
			],
			"runtime" => [new ExpressionField("CNT", "COUNT(*)")]
		]);

		$res = [];
		while ($row = $rs->fetch())
		{
			$id = $row["UF_REVIEW_ID"];
			$rate = $row["UF_RATE"];
			$cnt = $row["CNT"];

			$res[$id][$rate] = $cnt;
		}

		return $res;
	}

	private function getSummary()
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();

		$cacheTtl = $this->arParams["CACHE_TIME"];
		$cachePath = self::CACHE_PATH . $this->arParams["TARGET"] . "/";
		$cacheId = md5(serialize($this->arParams["TARGET"]));

		$value = [];


		if ($cache->initCache($cacheTtl, $cacheId, $cachePath))
		{
			$value = $cache->getVars();
			//var_dump(["from cache"]);
		} elseif ($cache->startDataCache())
		{
			$value = $this->getSummaryRaw();
			//var_dump(["HOT"]);

			$cache_manager = \Bitrix\Main\Application::getInstance()->getTaggedCache();
			$cache_manager->startTagCache($cachePath);
			$cache_manager->registerTag("review_target_summary_" . $this->arParams["TARGET"]); //clearByTag
			$cache_manager->endTagCache();

			$cache->endDataCache($value);
		}

		return $value;

	}

	private function getSummaryRaw()
	{
		\CModule::IncludeModule("iblock");
		$arResult = ["ITEMS" => []];

		$arGroupBy = ["PROPERTY_TARGET_RATE"];
		$arSort = ["PROPERTY_TARGET_RATE" => "DESC"];
		$arFilter = [
			"IBLOCK_ID"              => $this->arParams["IBLOCK_ID"],
			"ACTIVE"                 => "Y",
			"!PROPERTY_IS_PUBLISHED" => false,
			"PROPERTY_TARGET"        => $this->arParams["TARGET"]
		];

		$rs = \CIBlockElement::GetList($arSort, $arFilter, $arGroupBy);
		$allSum = 0;
		$allCnt = 0;
		$rates = [];

		while ($el = $rs->Fetch())
		{
			$cnt = $el["CNT"];
			$rate = $el["PROPERTY_TARGET_RATE_VALUE"];

			$allSum += $cnt * $rate;
			$allCnt += $cnt;

			$rates[$rate] = $cnt;
		}

		if ($allCnt > 0)
		{
			for ($rate = 5; $rate > 0; $rate--)
			{
				$cnt = $rates[$rate] ?: 0;
				$percent = round($cnt / $allCnt * 100);

				$arResult["ITEMS"][$rate] = [
					"CNT"     => $cnt,
					"PERCENT" => $percent,
				];
			}

			$avg = $allSum / $allCnt;
			$arResult["AVG"]["NUMBER"] = round($avg, 1);
			$arResult["AVG"]["PERCENT"] = round($avg / 5 * 100);
		}


		return $arResult;
	}
}