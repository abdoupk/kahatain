<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\School;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchSchoolsCommand extends Command
{
    protected $signature = 'fetch:schools';

    protected $description = 'Command description';

    public function handle(): void
    {
        $client = new Client([
            'base_uri' => 'https://awlyaa.education.dz/',
            'timeout' => 5.0,
        ]);

        $cookies = 'SERVER_USED=57731568e0e119e5; ci_session=6f135ii9i4fonad37pp6vs9hl6i67bck; csrf_cookie_name=478c19336088fda157fa78c8a1da03ea';

        City::chunk(100, function ($cities) use ($client, $cookies) {
            foreach ($cities as $city) {
                for ($i = 1; $i <= 3; $i++) {
                    $formData = [
                        'cycle' => $i,
                        'commune' => $city->commune_code,
                    ];

                    $response = $client->post('getEtabs', [
                        'form_params' => $formData,
                        'headers' => [
                            'Cookie' => $cookies,
                        ],
                    ]);

                    if ($response->getStatusCode() === 200) {
                        $data = json_decode($response->getBody(), true);

                        for ($index = 0; $index < count($data); $index++) {
                            if (count($data) > 1) {
                                if ($index === 0) {
                                    continue;
                                }

                                School::updateOrCreate([
                                    'e_id' => $data[$index]['val'],
                                ], [
                                    'name' => $data[$index]['text'],
                                    'city_id' => $city->id,
                                    'phase_key' => $i === 1 ? 'elementary_school' : ($i === 2 ? 'middle_school' : 'high_school'),
                                    'e_id' => $data[$index]['val'],
                                ]);
                            }
                        }
                    } else {
                        ray($response->getStatusCode());
                        ray($response->getBody());
                    }

                    sleep(3);
                }
            }
        });
    }
}
