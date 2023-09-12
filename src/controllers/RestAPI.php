<?php

namespace Lernfeld1011\controllers;

/**
 * Representational State Transfer - Application Programming Interface
 * Maybe a better name for our Interface Controller?
 * This Interface will be accessed by the Frontend for data exchange.
 */
class RestAPI
{
    public function aMethod(): string
    {
        return 'Dies ist ein Test';
    }
}
