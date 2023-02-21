<?php


namespace Palladiumlab\Sku;

use Illuminate\Support\Collection;
use Palladiumlab\Catalog\CharacteristicsToPhoto;
use Palladiumlab\Photo\NullPhotoModel;
use Palladiumlab\Photo\PhotoModel;

class SkuModel
{
	/**
	 * @var string
	 */
	private string $color;
	/**
	 * @var string
	 */
	private string $size;
	/**
	 * @var string
	 */
	private string $fileNameSize = "";
	/**
	 * @var string
	 */
	private string $fileNameColor = "";


	public function __construct($size = "", $color = "")
	{
		$this->size = trim($size, " ");
		$this->color = trim($color, " ");
	}

	/**
	 * @return string
	 */
	public function getColor(): string
	{
		return $this->color;
	}

	/**
	 * @param string $color
	 */
	public function setColor(string $color): void
	{
		$this->color = $color;
	}

	/**
	 * @return string
	 */
	public function getSize(): string
	{
		return $this->size;
	}

	/**
	 * @param string $size
	 */
	public function setSize(string $size): void
	{
		$this->size = $size;
	}

	/**
	 * @return string
	 */
	public function getSizeFormatted()
	{
		return $this->checkForEmpty($this->size, "Размер: ");
	}

	private function checkForEmpty($field, $name)
	{
		$res = "";
		if ($field !== "")
		{
			$res = $name . $field;
		}
		return $res;
	}

	/**
	 * @return string
	 */
	public function getColorFormatted()
	{
		return $this->checkForEmpty($this->color, "Цвет: ");
	}

	/**
	 * @param Collection $files
	 * @return Collection
	 */
	public function searchSkuModelPhoto(Collection $files): Collection
	{
		$res = new Collection();
		foreach ($files as $file)
		{
			$descr = $file->getDescription();
			$startPosSku = strrpos($descr, "__");
			if ($startPosSku !== false)
			{
				$skuStr = substr($descr, $startPosSku + 2);//+2 - length of __
				if ($skuStr !== false)
				{
					$arSku = explode("_", $skuStr);
					if ($this->getFileNameSize() == $arSku[0] && $this->getFileNameColor() == $arSku[1]) $res->push($file);
				}
			}
		}
		if ($res->isEmpty()) $res->push(new NullPhotoModel());
		return $res;
	}

	/**
	 * @return string
	 */
	public function getFileNameSize(): string
	{
		return $this->checkAndFillFileNameSkuProperty("size");
	}

	private function checkAndFillFileNameSkuProperty(string $property)
	{
		$fileNameProperty = "fileName" . ucfirst($property);
		if ($this->$fileNameProperty == "")
		{
			$coll = CharacteristicsToPhoto::find();
			if (is_numeric($this->$property))
			{
				return $this->$fileNameProperty = $this->$property;
			}
			$res = $coll->where("name", $this->$property)->first()->code;
			if ($res == null)
			{
				return $this->$fileNameProperty = "";
			}
			$this->$fileNameProperty = $res;
			unset($coll);
			return $this->$fileNameProperty;
		} else
			return $this->$fileNameProperty;
	}

	/**
	 * @return string
	 */
	public function getFileNameColor(): string
	{
		return $this->checkAndFillFileNameSkuProperty("color");
	}
}