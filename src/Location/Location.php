<?php

namespace Pumpkin\Location;

use InvalidArgumentException;

class Location implements LocationInterface
{
    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $city;

    /**
     * Location constructor.
     * @param string $country
     * @param string $city
     */
    public function __construct(string $country, string $city)
    {
        $country = strtoupper($country);
        $this->validateCountry($country);
        $this->country = $country;
        $this->validateCity($city);
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function country(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function city(): string
    {
        return $this->city;
    }

    /**
     * @param string $country
     *
     * @throws InvalidArgumentException
     */
    private function validateCountry(string $country)
    {
        if (!preg_match("/^[A-Z]{2}$/", $country)) {
            throw new InvalidArgumentException(sprintf("Invalid country supplied (%s)", $country));
        }
    }

    /**
     * @param string $city
     * 
     * @throws InvalidArgumentException
     */
    private function validateCity(string $city)
    {
        if (trim($city) == '') {
            throw new InvalidArgumentException(sprintf("Invalid city supplied (%s)", $city));
        }
    }
}
