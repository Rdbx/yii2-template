<?php

namespace common\components\services;

use yii\httpclient\Client;

class TelegramService
{
    public $baseUrl = "https://api.telegram.org/bot";
    public $botToken = null;
    public $parseMode = "HTML";

    public function __construct()
    {
        $this->botToken = \Yii::$app->params['telegramToken'];
    }

    public static function send($telegramId, $message)
    {
        $service = new self;

        $client = new Client([
            'baseUrl' => $service->baseUrl.$service->botToken,
        ]);

        $params = [
            'chat_id'    => $telegramId,
            'text'       => $message,
            'parse_mode' => $service->parseMode
        ];

        $response = $client->createRequest()
            ->setUrl('sendMessage')
            ->setData($params)
            ->send();

        return $response->data;
    }
}
