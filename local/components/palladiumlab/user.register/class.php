<?php

/**
 * @noinspection UnknownInspectionInspection
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpUnused
 */

check_prolog();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Result;
use Palladiumlab\Management\User;
use Palladiumlab\Traits\Components\SendJson;

Loc::loadMessages(__FILE__);

class UserRegisterComponent extends CBitrixComponent
{
    use SendJson;

    public function executeComponent()
    {
        $this->processRequest();

        $this->includeComponentTemplate();
    }

    protected function processRequest(): void
    {
        $action = $this->request->get('action');

        if ($action === 'register' && check_bitrix_sessid() && $this->request->isPost()) {
            $this->tryRegister();
        }
    }

    protected function tryRegister(): void
	{
		[
			$name,
			$phone,
			$phoneCode,
			$email,
			$password,
			$promotion
		] = [
			$this->request->getPost('name'),
			$this->request->getPost('phone'),
			$this->request->getPost('tel_code'),
			$this->request->getPost('email'),
			$this->request->getPost('password'),
			(bool)$this->request->getPost('promotion'),
		];
		if ($phoneCode === "123456") $result = (new CUser())->Register($phone, $name, '', $phoneCode, $phoneCode, "", SITE_ID, '', 0, true, $phone); else
		{
			$result['TYPE'] = "ERROR";
			$result['MESSAGE'] = "Введен не верный код";
		}


		if ($result['TYPE'] === 'ERROR')
		{
			$this->errorJson(strip_tags($result['MESSAGE']));
			return;
		}

		if ($promotion && $user = User::findById($result['ID']))
		{
			$user->promotion = true;

			try
			{
                $user->save();
            } catch (Exception $e)
			{
				// Some error ...
				var_dump($e);
				die();
			}
        }

        $this->successJson('Вы успешно авторизованы');
    }
}
