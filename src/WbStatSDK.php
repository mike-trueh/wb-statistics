<?php

namespace WbStat;

use DateTime;
use WbStat\Exceptions\RequestException;
use WbStat\Exceptions\WbStatException;

class WbStatSDK extends Request
{
    /**
     * Дата на которую нужно получить данные
     *
     * @var DateTime|null
     */
    private $dateTime;

    public function __construct(string $token, DateTime $dateTime = null)
    {
        $this->token = $token;
        $this->dateTime = $dateTime;
    }

    /**
     * Получить текущий токен
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Задать дату для запросов
     *
     * @param DateTime|null $dateTime
     * @return $this
     */
    public function setDate(DateTime $dateTime = null): WbStatSDK
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Получить установленную дату
     *
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->dateTime;
    }

    /**
     * Поставки
     *
     * @param DateTime|null $dateTime
     * @return mixed
     * @throws RequestException
     * @throws WbStatException
     */
    public function incomes(DateTime $dateTime = null)
    {
        return $this->request('incomes', ['dateFrom' => $dateTime ?? $this->dateTime ?? null]);
    }

    /**
     * Склад
     *
     * @param DateTime|null $dateTime Начальная дата периода
     * @return mixed
     * @throws RequestException
     * @throws WbStatException
     */
    public function stocks(DateTime $dateTime = null)
    {
        return $this->request('stocks', ['dateFrom' => $dateTime ?? $this->dateTime ?? null]);
    }

    /**
     * Заказы
     *
     * @param DateTime|null $dateTime Начальная дата периода
     * @param int $flag Если параметр flag=0 (или не указан в строке запроса), при вызове API возвращаются данные у которых значение поля lastChangeDate (дата время обновления информации в сервисе) больше переданного в вызов значения параметра dateFrom. При этом количество возвращенных строк данных варьируется в интервале от 0 до примерно 100000
     * @return mixed
     * @throws RequestException
     * @throws WbStatException
     */
    public function orders(DateTime $dateTime = null, int $flag = 0)
    {
        if ($flag < 0 || $flag > 1) throw new WbStatException('Значение flag должно быть 0 или 1');

        return $this->request('orders', ['dateFrom' => $dateTime ?? $this->dateTime ?? null, 'flag' => $flag]);
    }

    /**
     * Продажи
     *
     * @param DateTime|null $dateTime Начальная дата периода
     * @param int $flag Если параметр flag=0 (или не указан в строке запроса), при вызове API возвращаются данные у которых значение поля lastChangeDate (дата время обновления информации в сервисе) больше переданного в вызов значения параметра dateFrom. При этом количество возвращенных строк данных варьируется в интервале от 0 до примерно 100000
     * @return mixed
     * @throws RequestException
     * @throws WbStatException
     */
    public function sales(DateTime $dateTime = null, int $flag = 0)
    {
        if ($flag < 0 || $flag > 1) throw new WbStatException('Значение flag должно быть 0 или 1');

        return $this->request('sales', ['dateFrom' => $dateTime ?? $this->dateTime ?? null]);
    }

    /**
     * Отчет о продажах по реализации
     *
     * @param DateTime $dateTo Конечная дата периода
     * @param int $limit Максимальное количество строк отчета получаемых в результате вызова API. Рекомендуем загружать отчет небольшими частями, например, по 100 000 строк на один вызов
     * @param int $rrdid Уникальный идентификатор строки отчета. Необходим для получения отчета частями
     * @param DateTime|null $dateTime Начальная дата периода
     * @return mixed
     * @throws RequestException
     * @throws WbStatException
     */
    public function reportDetailByPeriod(DateTime $dateTo, int $limit = 1000, int $rrdid = 0, DateTime $dateTime = null)
    {
        return $this->request('reportDetailByPeriod', ['dateFrom' => $dateTime ?? $this->dateTime ?? null, 'dateTo' => $dateTo, 'limit' => $limit, 'rrdid' => $rrdid,]);
    }
}