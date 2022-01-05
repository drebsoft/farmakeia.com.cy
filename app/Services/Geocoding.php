<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Str;

class Geocoding
{
    private $original;
    private $coordinates;
    private $address;

    public function translate(string $original)
    {
        $this->original = Str::of($original)->replace(' ', '+');

        return $this;
    }

    public function toCoordinates()
    {
        $this->setCoordinates($this->relayRequest('address'));

        return $this;
    }

    public function toAddress()
    {
        $this->setAddress($this->relayRequest('latlng'));

        return $this;
    }

    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function getCoordinatesArray()
    {
        if (empty($this->coordinates)) {
            return null;
        }

        $array = explode(',', $this->coordinates);
        return [
            'lat' => $array[0],
            'lng' => $array[1],
        ];
    }

    public function getAddress()
    {
        return $this->address;
    }

    private function relayRequest(string $origin)
    {
        $api_key = config('googlemaps.server_api_key');
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?'
            . $origin . '=' . $this->original
            . '&key=' . $api_key;
        $response = Http::get($url)['results'][0] ?? null;

        if ($response === null) {
            return null;
        }

        if ($origin === 'address') {
            return $response['geometry']['location']['lat'] . ',' . $response['geometry']['location']['lng'];
        }

        if ($origin === 'latlng') {
            return $response['formatted_address'];
        }

        return null;
    }
}
