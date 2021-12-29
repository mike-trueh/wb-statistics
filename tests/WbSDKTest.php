<?php

namespace Tests;

use WbStat\Exceptions\RequestException;
use WbStat\Exceptions\WbStatException;
use WbStat\WbStatSDK;

class WbSDKTest extends TestCase
{
    public function testConstruction()
    {
        $stat = new WbStatSDK('test-token');

        $this->assertSame('test-token', $stat->getToken());

        $testDate = date_create();
        $stat->setDate($testDate);
        $this->assertSame($testDate, $stat->getDate());

        $stat->setDate();
        $this->assertNull($stat->getDate());
    }

    /**
     * @throws RequestException
     */
    public function testTokenAndDateException()
    {
        $stat = new WbStatSDK('test-token');

        $this->expectException(WbStatException::class);
        $stat->incomes();

        $stat->setDate(date_create());

        $this->expectException(RequestException::class);
        $stat->incomes();
    }
}