<?php

namespace infrastructure;

class Factory
{
    private \Configuration $configuration;

    public function __construct(\Configuration $configuration)
    {
        $this->configuration = $configuration;
    }
}