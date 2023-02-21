<?php

/**
 * @noinspection UnknownInspectionInspection
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpUnused
 */

check_prolog();
global $USER;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Security\Password;
use Palladiumlab\Management\User;
use Palladiumlab\Support\Bitrix\Bitrix;
use Palladiumlab\Traits\Components\SendJson;

Loc::loadMessages(__FILE__);

/**
 * @property User user
 *
 * Class UserProfileComponent
 */
class UserProfileComponent extends CBitrixComponent
{
    use SendJson;

    public function __construct($component = null)
    {
//        $this->user = User::current();
        global $USER;
        $this->user = $USER->GetId();

        parent::__construct($component);
    }

    public function executeComponent()
    {
        if ($this->user) {
            $this->processRequest();

            $this->includeComponentTemplate();
        }
    }

    protected function processRequest()
	{
		$action = $this->request->getPost('action');

		if ($this->request->isPost() && check_bitrix_sessid())
		{
			if ($action === 'update-profile')
			{
				$newPassword = $this->request->getPost("password");
				$confirmPassword = $this->request->getPost("confirm_password");
				$oldPassword = $this->request->getPost("old_password");
				$arrList = $this->request->getPostList()->toArray();
				$currentHash = $this->user->password;
				unset($this->user->password);
				if ($arrList['birthday'] !== '') $arrList['birthday'] = (new DateTime($arrList['birthday']))->format("d.m.Y h:m:s");
				$arrList['gender'] = $this->request->getPost("cabinet-profile-gender") === "Мужской" ? "M" : "F";
				$arrList['promotion'] = $this->request->getPost("promotion") === "on" ? "1" : "0";
//проверить password на old password, если задан
				if ($newPassword || $confirmPassword || $oldPassword)
				{
					if ($newPassword !== $confirmPassword)
					{
						$this->arResult["ERROR"] = "Новый пароль не совпадает с подтверждением";
						return false;
					}

					if (!Password::equals($currentHash, $oldPassword))
					{
						$this->arResult["ERROR"] = "Старый пароль не верен";
						return false;
					}
				}
				try
				{
					$this->user->setAttributes($arrList)->save();
				} catch (Exception $e)
				{
					// Error :(
					$this->arResult["ERROR"] = $e->getMessage();
				}
			} elseif ($action === 'delete-profile')
			{
				$this->user->remove();
				LocalRedirect(Bitrix::globalApplication()->getCurPage());
			}
			// LocalRedirect(Bitrix::globalApplication()->getCurPage());
		}
    }
}