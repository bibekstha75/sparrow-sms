<?php

namespace Bibekshrestha\SparrowSms\Facades;

use Illuminate\Support\Facades\Facade;

class SparrowSms extends Facade
{
    /**
     * @method static array send(array $data)
     * @method static array sendBulk(array $data)
     * @method static mixed checkCredits()
     */

    protected static function getFacadeAccessor(): string
    {
        return 'sparrow-sms';
    }
}
