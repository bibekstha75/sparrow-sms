<?php

namespace Bibekshrestha\SparrowSms\Contracts;

interface SparrowSmsInterface
{
    public function send(array $data);

    public function sendBulk(array $data);

    public function checkCredits();
}
