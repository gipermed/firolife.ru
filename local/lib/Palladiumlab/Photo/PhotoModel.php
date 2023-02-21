<?php


namespace Palladiumlab\Photo;


class PhotoModel
{
	protected string $description;
	protected int $fileId;
	protected string $photo2xPath = "";

	public function __construct($description, $fileId)
	{
		$this->description = $description;
		$this->fileId = $fileId;
	}

	public function isNull()
	{
		return false;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	/**
	 * @return int
	 */
	public function getFileId(): int
	{
		return $this->fileId;
	}

	/**
	 * @param int $fileId
	 */
	public function setFileId(int $fileId): void
	{
		$this->fileId = $fileId;
	}

	public function getPhotoPath()
	{
		return \CFile::GetPath($this->fileId);
	}

	/**
	 * @return string
	 */
	public function getPhoto2xPath(): string
	{
		if ($this->photo2xPath == "")
		{
			$fileImg = \CFile::GetFileArray($this->fileId);
			$arImg = \CFile::ResizeImageGet($this->fileId, array('width'  => $fileImg['WIDTH'] * 2,
																 'height' => $fileImg['HEIGHT'] * 2
				), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
			$this->photo2xPath = $arImg["src"];
		}
		return $this->photo2xPath;
	}


}