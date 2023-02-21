<?

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\Type;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CIblockDownloadFiles extends \CBitrixComponent
{
	const CACHE_PATH = "/" . SITE_ID . "/rngdv/" . __CLASS__ . "/";

	public function executeComponent()
	{
		$context = \Bitrix\Main\Application::getInstance()->getContext();
		$this->req = $context->getRequest();

		$items = explode(",", $this->req->get("id"));
		$files = [];
		foreach ($items as $id)
		{
			$fileIds = $this->getResultCached($id);

			foreach ($fileIds as $id)
			{
				$files[] = \CFile::GetPath($id);
			}
		}

		try
		{
			$this->sendZip($files);
		} catch (Exception $ex)
		{
			echo $ex->getMessage();
		}
	}

	private function getResultCached($id)
	{
		$cache = \Bitrix\Main\Data\Cache::createInstance();

		$cacheTtl = $this->arParams["CACHE_TIME"];
		$cacheId = md5($id . "_" . $this->arParams["PROP_CODE"]);
		$cachePath = self::CACHE_PATH;

		$value = array();


		if ($cache->initCache($cacheTtl, $cacheId, $cachePath))
		{
			$value = $cache->getVars();
		} elseif ($cache->startDataCache())
		{
			$value = $this->getResult($id);

			$cache_manager = \Bitrix\Main\Application::getInstance()->getTaggedCache();
			$cache_manager->startTagCache($cachePath);
			$cache_manager->registerTag("iblock_id_" . $this->arParams["IBLOCK_ID"]);
			$cache_manager->endTagCache();

			$cache->endDataCache($value);
		}

		return $value;
	}

	private function getResult($id)
	{
		\CModule::IncludeModule('iblock');

		$propCode = "PROPERTY_" . $this->arParams["PROP_CODE"];

		$rs = \CIBlockElement::GetList(array(), array(
				"ID"        => $id,
				"IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
			), false, false, array($propCode));

		$ar = array();
		while ($el = $rs->GetNext()) $ar[] = $el[$propCode . "_VALUE"];

		return $ar;
	}

	private function sendZip($files)
	{
		if (!is_array($files) || count($files) <= 0) throw new Exception("Нет файлов для скачивания");


		if (extension_loaded('zip'))
		{
			$zip = new ZipArchive();
			$zip_name = time() . ".zip";

			if ($zip->open($zip_name, ZIPARCHIVE::CREATE) === true)
			{


				foreach ($files as $i => $file)
				{
					$name = explode("/", $file);
					$name = $name[count($name) - 1];


					$zip->addFile($_SERVER["DOCUMENT_ROOT"] . $file, $name);
				}

				$zip->close();


				$GLOBALS["APPLICATION"]->RestartBuffer();

				if (file_exists($zip_name))
				{
					header('Content-type: application/zip');
					header('Content-Disposition: attachment; filename="' . $zip_name . '"');
					readfile($zip_name);
					unlink($zip_name);
				}

				die();
			} else
			{
				throw new Exception("Sorry ZIP creation failed at this time");
			}
		} else
		{
			throw new Exception("You dont have ZIP extension");
		}

		//https://dev.gipermed.com/personal/orders/download.php?id=7738&clear_cache=Y
	}


}