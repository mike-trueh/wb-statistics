<?php

namespace Tests;

use WbStat\WbStatSDK;

class WbRequestTest extends TestCase
{
    public $stat;

    public function setUp(): void
    {
        parent::setUp();

        $this->stat = new WbStatSDK(getenv('WBSTAT_TOKEN'));

        usleep(250000); // Sleep to prevent rate limit
    }

    public function testIncomes()
    {
        $this->assertIsArray($this->stat->incomes(date_create()));
    }

    public function testStocks()
    {
        $this->assertIsArray($this->stat->stocks(date_create()));
    }

    public function testOrders()
    {
        $this->assertIsArray($this->stat->orders(date_create()));
    }

    public function testSales()
    {
        $this->assertIsArray($this->stat->sales(date_create()));
    }

    public function testReportDetailByPeriod()
    {
        $this->assertNull($this->stat->setDate(date_create())->reportDetailByPeriod(date_create()));
    }

    public function testExciseGoods()
    {
        $this->assertIsArray($this->stat->exciseGoods(date_create()));
    }
}