<?php

/**
 * @noinspection UnknownInspectionInspection
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpUnused
 */

check_prolog();

use Bitrix\Main\Localization\Loc;
use Palladiumlab\Traits\Components\SendJson;

Loc::loadMessages(__FILE__);

class UserPasswordResetComponent extends CBitrixComponent
{
    use SendJson;

    /**
     * @return mixed|void|null
     * @throws Exception
     */
    public function executeComponent()
    {
        $this->processRequest();

        $this->includeComponentTemplate();
    }

    protected function processRequest(): void
    {
        $action = $this->request->get('action');
        if ($action === 'password_reset' && check_bitrix_sessid() && $this->request->isPost()) {
            $this->reset();
        }
    }

    protected function reset(): void
    {
        [$login, $checkword] = [
            (string)$this->request->get('USER_LOGIN'),
            (string)$this->request->get('USER_CHECKWORD'),
        ];

        if (empty($login) || empty($checkword)) {
            $this->errorJson('Не корректная ссылка для смены пароля');
            return;
        }

        [$password, $passwordConfirm] = [
            $this->request->getPost('password'),
            $this->request->getPost('password_confirm'),
        ];

        $result = (new CUser())->ChangePassword($login, $checkword, $password, $passwordConfirm);

        if ($result['TYPE'] === 'ERROR') {
            $this->errorJson(strip_tags($result['MESSAGE']));
        } else {
            $this->successJson(strip_tags($result['MESSAGE']));
        }
    }
}
