<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class FormEmail extends \CBitrixComponent
{
	private $namespace;
	private $component;
	private $req;

	public function executeComponent()
	{
		$this->setConstants();
		$this->req = \Bitrix\Main\Context::getCurrent()->getRequest();

		$isAjax = $this->req->isAjaxRequest() && $this->req->get("component") == $this->component;


		if ($isAjax) $this->handleAjax(); else $this->includeComponentTemplate("button");
	}

	private function setConstants()
	{
		$dir = explode("/", __DIR__);
		do
		{
			$this->component = array_pop($dir);
		} while (strlen($this->component) <= 0 && count($dir) > 0);
		do
		{
			$this->namespace = array_pop($dir);
		} while (strlen($this->namespace) <= 0 && count($dir) > 0);

		$this->arResult["COMPONENT"] = $this->component;
		//$this->arResult["AJAX_URL"] = "/local/components/$namespace/$component/ajax.php";
	}

	private function handleAjax()
	{
		if ($this->req->get("form_submitted") != "Y")
		{
			$this->includeComponentTemplate();
		} else
		{
			$requestParams = [
				"NAME"    => "Укажите имя",
				"PHONE"   => "Укажите телефон",
				"EMAIL"   => false,
				"COMMENT" => false,
			];

			$requestParamValues = $this->checkForErrors($requestParams);
			$this->acceptForm($requestParamValues);
		}
	}

	private function checkForErrors($requestParams)
	{
		$errors = [];

		foreach ($requestParams as $param => $error)
		{
			$val = trim($this->req->get($param));

			if ($error && strlen($val) == 0) $errors[] = $error; else $requestParams[$param] = $val;
		}


		if (!check_bitrix_sessid()) $errors[] = "sid";


		if (count($errors) == 0) return $requestParams;


		echo json_encode([
			"success" => false,
			"errors"  => $errors
		]);
		die();
	}

	private function acceptForm($requestParamValues)
	{
		\Bitrix\Main\Diag\Debug::writeToFile($requestParamValues, "", "___info.txt");


		$to = $this->arParams["EMAIL"];
		$subject = "Получено сообщение с формы '" . $this->arResult["NAME"] . "'";
		$message = "";
		foreach ($requestParamValues as $name => $val)
		{
			$message .= "{$name}\r\n{$val}\r\n\r\n";
		}

		$result = mail($to, $subject, $message);

		if ($result)
		{
			echo json_encode(["success" => true]);
		} else
		{
			$this->checkForErrors(["Ошибка при отправке"]);
		}
	}
}