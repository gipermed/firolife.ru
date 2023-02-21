<?php


namespace Palladiumlab\Catalog;

class Element
{
	private array $arElement = [];
	private array $description = [];
	private array $specifications = [];
	private array $documentation = [];

	public function __construct(array $arResult)
	{
		$this->arElement = $arResult;
		$this->processFiles();
	}

	public function getVideo()
	{
		return $this->arElement["PROPERTIES"]["VIDEO"]["~VALUE"];
	}

	private function processFiles()
	{
		$filesMap = [
			"description",
			"specifications"
		];
		foreach ($this->arElement["PROPERTIES"]["FILES"]["DESCRIPTION"] as $key => $desc)
		{
			$this->extractFile($filesMap, $key, $desc);
			$this->extractDocumentation($key, $desc);
		}
	}

	private function extractFile(array $filesMap, int $key, string $desc)
	{
		foreach ($filesMap as $nameFile) if ($desc === $nameFile)
		{
			$file = \CFile::GetPath($this->arElement["PROPERTIES"]["FILES"]["VALUE"][$key]);
			$retFile = file($_SERVER['DOCUMENT_ROOT'] . $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			$this->$nameFile = $retFile ? $retFile : [];
		}
	}

	private function extractDocumentation(int $key, string $desc)
	{
		$ret = [];
		$end_of_file = "___file";
		if (str_ends_with($desc, $end_of_file))
		{
			$file = \CFile::GetFileArray($this->arElement["PROPERTIES"]["FILES"]["VALUE"][$key]);
			$endSize = " Кб";
			$size = round($file["FILE_SIZE"] / 1024);
			if ($size > 1024)
			{
				$size = round($size / 1024, 1);
				$endSize = " Мб";
			}
			$ret[] = [
				"SRC"       => $file["SRC"],
				"NAME"      => substr($desc, 0, -strlen($end_of_file)),
				"FILE_SIZE" => $size . $endSize
			];
			$this->documentation = $ret;
		}

	}

	public function getDocumentation()
	{
		return $this->documentation;
	}

	public function echoSpecification()
	{
		foreach ($this->specifications as $property):
			$arrProperty = explode(':', $property) ?>
			<tr>
				<td><?= $arrProperty[0] ?></td>
				<td><?= $arrProperty[1] ?></td>
			</tr>
		<?endforeach;
	}

	public function echoDescription()
	{
		foreach ($this->description as $line)
		{
			echo $line;
		}
	}

	public function echoStickers()
	{
		$this->getHit();
		$this->getNew();
	}

	private function getNew()
	{
//		$dtElem = \DateTime::createFromFormat('d.m.Y H:i:s', $this->arElement["TIMESTAMP_X"]);
		$dtElem = \DateTime::createFromFormat('d.m.Y H:i:s', $this->arElement["DATE_CREATE"]);
		if($dtElem){
            $dtElem->add(new \DateInterval("P14D"));
        }
		$dt = new \DateTime();
        //
		if($dt<$dtElem || $this->arElement["PROPERTIES"]['NOVINKA']['VALUE'])
		{
			echo "<div class='product-item-stiker product-item-stiker-new'>Новинка</div>";
		}
	}

	private function getHit()
	{
		if($this->arElement["PROPERTIES"]['KHIT']['VALUE']!="")
		{
			echo "<div class='product-item-stiker product-item-stiker-hit'>Хит</div>";
		}
	}

	public function getIPRA()
	{
		if($this->arElement["PROPERTIES"]['IPRA']['VALUE']!="")
		    return true;
		return false;
	}

	public function getArticles()
	{
		$articles=[];
		//IBLOCK_ARTICLES_ID
		$arFilter = [
			"IBLOCK_ID"=>IBLOCK_ARTICLES_ID
		];
		$arSelect = [
			"NAME","DETAIL_PICTURE","PREVIEW_PICTURE","PREVIEW_TEXT","PROPERTY_VIEW_COUNTER","ID","PROPERTY_VIEW_SECTIONS","DETAIL_PAGE_URL","CODE"
		];
		$obj = \CIBlockElement::GetList(["SORT"=>"ASC"],$arFilter,false,false,$arSelect);
		while($article = $obj->Fetch())
		{
			foreach ($article["PROPERTY_VIEW_SECTIONS_VALUE"] as $val)
			{
				if($this->arElement["IBLOCK_SECTION_ID"]==$val)
				{
					$photo=\CFile::GetFileArray($article["PREVIEW_PICTURE"]);
					$photo2x = \CFile::ResizeImageGet(
						$photo,
						array('width' => $photo['WIDTH']*2, 'height'=>$photo['HEIGHT']*2),
						BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
						true
					);
					$articles[]=[
						"NAME"=>$article["NAME"],
						"PICTURE"=>$photo["SRC"],
						"PICTURE2X"=>$photo2x["src"],
						"DETAIL_PAGE_URL"=>str_replace("#ELEMENT_CODE#",$article["CODE"],$article["DETAIL_PAGE_URL"]),
						"ID"=>$article["ID"],
						"VIEW_COUNTER"=>$article["PROPERTY_VIEW_COUNTER_VALUE"],
						"TEXT"=>$article["PREVIEW_TEXT"]
					];
				}
			}

		}
		return $articles;
	}
	public function getVideoCover()
	{
		$url=$this->arElement["PROPERTIES"]["VIDEO"]["~VALUE"];
		return preg_replace('/.*(:http|https|)(\?\/\/|)(?:www\.|)(?:youtube\.com|youtu\.be)(\?\/embed\/|\/v\/|\/watch\?v=|\/)(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*|[\w-]{10,12}).*/', 'http://img.youtube.com/vi/$4/maxresdefault.jpg', $url);
	}

	public function getShowProperties()
	{
		$ret=[];

		foreach ($this->arElement['PROPERTIES'] as $key => $property)
		{
			if($property['VALUE']!="" && $property['CODE']!="MINIMALNYY_OSTATOK"&&
				$property['CODE']!="KRATKOE_OPISANIE"&&
				$property['CODE']!="MORE_PHOTO"&&
				$property['CODE']!="STRANA"&&
				$property['CODE']!="VIDEO"&&
				$property['CODE']!="PROIZVODITEL"&&
				$property['CODE']!="BLOG_POST_ID"&&
				$property['CODE']!="BLOG_COMMENTS_CNT"&&
				$property['CODE']!="POLNOE_OPISANIE"&&
				$property['CODE']!="IPRA"&&
				$property['CODE']!="FILES"&&
				$property['CODE']!="vote_count"&&
				$property['CODE']!="vote_sum"&&
				$property['CODE']!="rating"&&
				str_contains($property['CODE'],"CML2_")===false)
			{
				$ret[]=	[
						"NAME"=>$property['NAME'],
						"VALUE"=>$property['VALUE']
					];
			}

		}
		return $ret;
	}
}