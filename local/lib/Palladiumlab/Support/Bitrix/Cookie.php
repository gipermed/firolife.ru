<?php


namespace Palladiumlab\Support\Bitrix;


use Bitrix\Main\Context;
use Bitrix\Main\HttpRequest;
use Bitrix\Main\HttpResponse;
use Bitrix\Main\Request;
use Bitrix\Main\Response;
use Bitrix\Main\Web\Cookie as WebCookie;

class Cookie
{
    /**
     * @var HttpResponse|Response
     */
    protected $response;
    /**
     * @var HttpRequest|Request
     */
    protected $request;

    public function __construct()
    {
        $this->response = Context::getCurrent()->getResponse();
        $this->request = Context::getCurrent()->getRequest();
    }

    public function add(string $name, string $value, int $time): Cookie
    {
        $this->response->addCookie(new WebCookie($name, $value, time() + $time))->writeHeaders();

        return $this;
    }

    public function remove(string $name): Cookie
    {
        $this->response->addCookie(new WebCookie($name, null, time() - 3600))->writeHeaders();

        return $this;
    }

    public function get(string $name): ?string
    {
        return $this->request->getCookie($name);
    }
}