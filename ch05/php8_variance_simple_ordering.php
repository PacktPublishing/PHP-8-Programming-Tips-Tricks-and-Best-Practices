<?php
// /repo/ch05/php8_variance_simple_ordering.php
class Transport
{
    // underwater|water_surface|land|atmospheric|space
    public string $medium = '';
    // civilian|industrial|military
    public string $usage = '';
}
class LandVehicle extends Transport
{
    public string $medium = 'land';
    public string $engineType;
    public string $fuelType;
    public int $numPassengers;
}
class Automobile extends LandVehicle
{
    public int $numTires;
    public int $seats;
    public int $capacity;
}
