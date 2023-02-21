<?php

/**
 * @noinspection UnknownInspectionInspection
 * @noinspection AutoloadingIssuesInspection
 * @noinspection PhpUnused
 */

check_prolog();

use Bitrix\Main\Localization\Loc;
use Palladiumlab\Management\User;
use Palladiumlab\Traits\Components\SendJson;

Loc::loadMessages(__FILE__);

class UserAuthComponent extends CBitrixComponent
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

        if ($action === 'auth' && check_bitrix_sessid() && $this->request->isPost()) {
            $this->tryAuth();
        }
    }

    protected function tryAuth(): void
    {
        [$login, $password, $remember] = [
            $this->request->getPost('login'),
            $this->request->getPost('password'),
            (bool)$this->request->getPost('remember'),
        ];

        $result = (new CUser())->login($login, $password, $remember ? 'Y' : 'N');

        if ($result['TYPE'] === 'ERROR') {
            $this->errorJson(strip_tags($result['MESSAGE']));
            return;
        }

        $this->successJson('Вы успешно авторизованы');
    }
}
