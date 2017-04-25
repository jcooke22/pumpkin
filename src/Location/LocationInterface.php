<?php

namespace Pumpkin\Location;

interface LocationInterface
{
    /**
     * @return string
     */
    public function country(): string;

    /**
     * @return string
     */
    public function city(): string;
}