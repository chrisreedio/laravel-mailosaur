<?php

namespace ChrisReedIO\Mailosaur\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ChrisReedIO\Mailosaur\Mailosaur
 */
class Mailosaur extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ChrisReedIO\Mailosaur\Mailosaur::class;
    }
}
