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

class UserPasswordRestoreComponent extends CBitrixComponent
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
        if ($action === 'password_restore' && check_bitrix_sessid() && $this->request->isPost()) {
            $this->restore();
        }
    }

    protected function restore(): void
    {
        $email = $this->request->getPost('email');

        $user = User::findOne(['=EMAIL' => $email]);

        if ($user) {

            $checkword = md5(CMain::getServerUniqId() . uniqid('', true));
            try {
                $user->save(['CHECKWORD' => $checkword]);
            } catch (Exception $e) {
                $this->errorJson('Не удалось сгенерировать проверочный код, обратитесь к администратору');
            }

            CEvent::send('USER_PASS_REQUEST', SITE_ID, [
                'USER_ID' => $user->id,
                'STATUS' => '', // $user->active ? 'Активен' : 'Не активен',
                'MESSAGE' => '', // Вы запросили Ваши регистрационные данные
                'LOGIN' => $user->login ?? '',
                'URL_LOGIN' => urldecode($user->login ?? ''),
                'CHECKWORD' => $checkword,
                'NAME' => $user->name ?? '',
                'LAST_NAME' => $user->second_name ?? '',
                'EMAIL' => $user->email ?? '',
            ]);
            $this->successJson('Ссылка для восстановления пароля успешно отправлена на ваш Email адрес');

        } else {
            $this->errorJson('Email адрес не найден');
        }
    }
}
