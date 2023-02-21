<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


class CReviewsAdd extends CBitrixComponent
{

	const CACHE_PATH = "/" . SITE_ID . "/itrack/" . __CLASS__ . "/";

	private $req;


	public function executeComponent()
	{
		$this->req = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

		$target = (int)$this->req->get("target");
		$formIsSent = $this->req->get("send") == "y";

		$this->arResult["CAPTCHA"] = $GLOBALS["APPLICATION"]->CaptchaGetCode();

		if ($formIsSent)
		{
			$this->processForm();
		} elseif ($target)
		{
			$this->arResult["TARGET"] = $target;
			$this->IncludeComponentTemplate("popup");
		} else
		{
			$this->arResult["TARGETS"] = $this->getTargetsCached();
			$this->IncludeComponentTemplate();
		}

	}

	private function processForm()
	{
//		var_dump($_FILES);
//		var_dump($_REQUEST);

		$errors = [];


		$captchaWord = trim($this->req->get("captcha_word"));
		$captchaSid = trim($this->req->get("captcha_sid"));
		$checkCaptcha = $GLOBALS["APPLICATION"]->CaptchaCheckCode($captchaWord, $captchaSid);

		if (!$checkCaptcha)
		{
			$errors[] = "Введите капчу";
		}


		$fio = trim($this->req->get("fio"));
		$phone = trim($this->req->get("phone"));
		$email = trim($this->req->get("email"));
		$target = (int)$this->req->get("target");
		$review = trim($this->req->get("review"));

		$emailPattern = "^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$";


		if (!$fio) $errors[] = "Введите Ваше имя";
		if (!$review) $errors[] = "Введите текст отзыва";

//		if ( !$email ) $errors[] = "Введите E-mail";
//		elseif ( !preg_match($emailPattern, $email) )  $errors[] = "Введите E-mail";

//		if ( !$phone ) $errors[] = "Введите контактный телефон";


		if (count($errors))
		{
			echo json_encode([
				"success" => false,
				"errors"  => $errors,
				"captcha" => $this->arResult["CAPTCHA"]
			]);
			die();
		}


		$files = $_FILES["files"];
		$fileProp = [];

		foreach ($files as $field => $vals)
		{
			foreach ($vals as $i => $val)
			{
				$fileProp["n$i"][$field] = $val;
			}
		}


		\CModule::IncludeModule("iblock");
		$cibe = new \CIBlockElement();

		$res = $cibe->Add([
			"NAME"            => $fio,
			"PREVIEW_TEXT"    => $review,
			"IBLOCK_ID"       => $this->arParams["IBLOCK_ID"],
			"PROPERTY_VALUES" => [
				"OBJECT" => $target,
				"EMAIL"  => $email,
				"PHONE"  => $phone,
				"FILES"  => $fileProp
			]
		]);

		$res = $res ? ["success" => true] : [
			"success" => false,
			"errors"  => [$cibe->LAST_ERROR],
			"captcha" => $this->arResult["CAPTCHA"]
		];

		echo json_encode($res);
		die();
	}
}