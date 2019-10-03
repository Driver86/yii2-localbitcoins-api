<?php

namespace app\commands;

use app\models\Account;
use app\models\Balance;
use app\models\Course;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use yii\console\Controller;
use yii\console\ExitCode;

class DaemonController extends Controller
{
    protected $client;

    public function init()
    {
        parent::init();
        $this->client = new Client([
            'base_uri' => 'https://localbitcoins.com',
        ]);
    }

    public function actionBalanceUpdate()
    {
        $endPoint = '/api/wallet/';
        $promises = [];
        foreach (Account::find()->all() as $user) {
            $userId = $user->id;
            $nonce = $this->getNonce();
            $promises[] = $this->client->requestAsync('GET', $endPoint, [
                'headers' => [
                    'Apiauth-Key' => $user->apiKey,
                    'Apiauth-Nonce' => $nonce,
                    'Apiauth-Signature' => $this->getSignature($nonce, $user->apiKey, $user->secretKey, $endPoint),
                ],
            ])->then(function ($response) use ($userId) {
                $response = json_decode($response->getBody());
                $balance = new Balance();
                $balance->ownerId = $userId;
                $balance->value = $response->data->total->balance;
                $balance->save();
            });
        }
        Promise\all($promises)->wait();
        return ExitCode::OK;
    }

    public function actionCourseUpdate()
    {
        $course = new Course();
        $formulas = [
            'usd' => 'usd_in_rub',
            'btc' => 'max(bitstampusd_avg,bitfinexusd_avg)*usd_in_rub',
        ];
        foreach ($formulas as $currency => $formula) {
            $endPoint = "/api/equation/{$formula}";
            $response = $this->client->request('GET', $endPoint);
            $response = json_decode($response->getBody());
            $course->$currency = $response->data;
        }
        $course->save();
        return ExitCode::OK;
    }

    protected function getNonce()
    {
        usleep(1);
        return (int) (microtime(true) * 1000000000);
    }

    protected function getSignature($nonce, $apiKey, $apiSecret, $endPoint, $params = [])
    {
        $message  = $nonce . $apiKey . $endPoint . http_build_query($params); // '?' or ''?
        return strtoupper(hash_hmac('sha256', $message, $apiSecret));
    }
}
