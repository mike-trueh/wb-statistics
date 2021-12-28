# Wildberries Statistics SDK

Wildberries Statistics SDK - PHP SDK пакет для взаимодействия с API [Wildberries](https://images.wbstatic.net/portal/education/Kak_rabotat'_s_servisom_statistiki.pdf)

## Установка

``` bash
$ composer require mike-trueh/wb-stat
```

## Поддерживаемые методы
- incomes
- stocks
- orders
- sales
- reportDetailByPeriod

[Официальная документация](https://images.wbstatic.net/portal/education/Kak_rabotat'_s_servisom_statistiki.pdf)

## Примеры

**incomes**
``` php
use WbStat\WbStatSDK;
...
$date = date_create_from_format('U', time());
$wbStat = new WbStatSDK('YOUR-TOKEN');

$incomes = $wbStat->incomes($date); 
// Дату можно установить через функцию setDate() 
$incomes = $wbStat->setDate($date)->incomes(); 
```