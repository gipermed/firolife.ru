<?php


namespace Palladiumlab\Photo;


class NullPhotoModel extends PhotoModel
{
	public function __construct()
	{
	}

	public function isNull()
	{
		return true;
	}

	public function getPhotoPath()
	{
		return "";
	}

	public function getPhoto2xPath(): string
	{
		return "";
	}
}