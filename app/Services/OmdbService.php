<?php

namespace App\Services;

use GuzzleHttp\Client;

class OmdbService
{
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        $this->apiKey = env('OMDB_API_KEY', 'YOUR_API_KEY_HERE');
        $this->client = new Client([
            'base_uri' => 'http://www.omdbapi.com/',
            'timeout'  => 5.0,
        ]);
    }

    // Cari movie
    public function search($query = 'Marvel', $page = 1)
    {
        try {
            $response = $this->client->get('', [
                'query' => [
                    'apikey' => $this->apiKey,
                    's'      => $query,
                    'page'   => $page,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data ?: [];
        } catch (\Exception $e) {
            return [];
        }
    }

    // Detail movie by imdbID
    public function detail($id)
    {
        try {
            $response = $this->client->get('', [
                'query' => [
                    'apikey' => $this->apiKey,
                    'i'      => $id,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return $data ?: [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
