<?php

namespace mikeTrueh\WbStat;

use mikeTrueh\WbStat\Exception\RequestException;
use mikeTrueh\WbStat\Exception\WbStatException;

abstract class Request
{
    const URL = 'https://suppliers-stats.wildberries.ru/api/v1/supplier';

    /**
     * Токен доступа партнера
     *
     * @var string
     */
    protected $token;

    /**
     * Формирование запроса к API Wildberries
     *
     * @param string $url
     * @param array $params
     * @param string $method
     * @param bool $auth
     * @return mixed
     * @throws RequestException
     * @throws WbStatException
     */
    protected function request(string $url, array $params = [], string $method = 'get', bool $auth = true)
    {
        $headers = ['Content-Type: application/json'];

        if ($auth) {
            if (!$this->token) throw new WbStatException('Не указан токен партнёра');

            $params['key'] = $this->token;
        }

        return $this->requestCurl($url, $params, $method, $headers);
    }

    /**
     * @param string $url
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param int $timeout
     * @return mixed
     * @throws RequestException
     */
    protected function requestCurl(string $url, array $params = [], string $method = 'GET', array $headers = [], int $timeout = 30)
    {
        $ch = curl_init();

        if (count($params)) {
            if ($method === 'get') {
                $url .= '?' . http_build_query($params);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            }
        }

        if ($method === 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
        }

        curl_setopt($ch, CURLOPT_URL, self::URL . '/' . $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if (count($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);

        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($errno) {
            throw new RequestException('Запрос произвести не удалось: ' . $error, $errno);
        }

        return json_decode($response, true);
    }
}