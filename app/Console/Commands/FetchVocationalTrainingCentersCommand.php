<?php

namespace App\Console\Commands;

use App\Models\VocationalTrainingCenter;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class FetchVocationalTrainingCentersCommand extends Command
{
    protected $signature = 'fetch:vocational-training-centers';

    protected $description = 'Command description';

    /**
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $levels = [
            1, 3, 5, 6, 7, 8, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 205, 206, 207, 208, 209, 210, 211, 212,
        ];
        $client = new Client(
            [
                'base_uri' => 'https://mihnati.mfep.gov.dz/api/orientation/',
                'timeout' => 60.0,
            ]
        );

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Safari/605.1.15',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.864.41 Safari/537.36 Edg/91.0.864.41',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36 OPR/77.0.4054.90',
            'Mozilla/5.0 (Linux; Android 10; Pixel 3 XL) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Android 10; Mobile; LG-M255) Gecko/60.0 Firefox/60.0',
            'Mozilla/5.0 (Linux; Android 10; SM-G973F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Mobile Safari/537.36 SamsungBrowser/14.0',
            'Opera/9.80 (Android; Opera Mini/36.2.2254/100.000; U; en) Presto/2.12.423 Version/12.16',
            'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
            'Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)',
            'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)',
            'DuckDuckBot/1.0; (+http://duckduckgo.com/duckduckbot)',
            'Slackbot 1.0 (+https://api.slack.com/robots)',
        ];

        for ($wilaya = 2; $wilaya <= 59; $wilaya++) {
            foreach ($levels as $level) {
                try {
                    $response = $client->post('offres', [
                        'form_params' => [
                            'passerelle' => 0,
                            'wilaya' => $wilaya,
                            'niveau' => $level,
                            'condition' => null,
                            'datatableOptions' => [
                                'page' => 1,
                                'itemsPerPage' => -1,
                                'sortBy' => [],
                                'sortDesc' => [false],
                                'groupBy' => [],
                                'groupDesc' => [],
                                'mustSort' => false,
                                'multiSort' => false,
                            ],
                            'filter_search' => null,
                            'useServer' => false,
                        ],
                        'headers' => [
                            'User-Agent' => $userAgents[array_rand($userAgents)],
                        ],
                    ]);

                    if ($response->getStatusCode() == 200) {
                        $data = json_decode($response->getBody()->getContents(), true)['data'];

                        if (count($data) > 0) {
                            if ($wilaya === 49) {
                                $wilaya_code = '01';
                            } elseif ($wilaya > 49) {
                                $wilaya_code = str_pad(strval($wilaya - 1), 2, '0', STR_PAD_LEFT);
                            } else {
                                $wilaya_code = str_pad(strval($wilaya), 2, '0', STR_PAD_LEFT);
                            }

                            foreach ($data as $vocationalTrainingCenter) {
                                VocationalTrainingCenter::updateOrCreate([
                                    'e_id' => $vocationalTrainingCenter['epa']['id'],
                                ], [
                                    'e_id' => $vocationalTrainingCenter['epa']['id'],
                                    'code' => $vocationalTrainingCenter['epa']['code'],
                                    'latin_name' => $vocationalTrainingCenter['epa']['libelleLatin'],
                                    'arabic_name' => $vocationalTrainingCenter['epa']['libelleArabe'],
                                    'wilaya_code' => $wilaya_code,
                                ]);
                            }
                        }
                    } else {
                        Log::error($response->getBody()->getContents());
                    }

                    sleep(rand(1, 5));
                } catch (Exception $exception) {
                    continue;
                }
            }

            sleep(rand(1, 5));
        }
    }
}
