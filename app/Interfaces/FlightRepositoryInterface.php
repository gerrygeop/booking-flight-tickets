<?php

namespace App\Interfaces;

interface FlightRepositoryInterface
{
    public function getAllFlights($filter = null);
    public function getAirportByFlightNumber($flightNumber);
}
