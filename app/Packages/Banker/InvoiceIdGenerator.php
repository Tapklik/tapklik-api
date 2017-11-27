<?php

use App\Contracts\BankerInterface;

/**
 * Class InvoiceIdGenerator
 *
 * @package \\${NAMESPACE}
 */
class InvoiceIdGenerator
{
    public function generate(BankerInterface $banker)
    {
        $banker->orderBy('id', 'desc')->first();
    }
}
