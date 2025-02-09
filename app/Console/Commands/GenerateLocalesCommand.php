<?php

namespace App\Console\Commands;

use App\Enums\Lang;
use Arr;
use File;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JsonException;

class GenerateLocalesCommand extends Command
{
    protected $signature = 'generate:locales';

    protected $description = 'Command description';

    /**
     * @throws FileNotFoundException
     * @throws JsonException
     */
    public function handle(): void
    {
        foreach (Lang::cases() as $lang) {
            $json_file_collection = collect(json_decode(
                File::get(base_path('lang/'.$lang->value.'.json')),
                false,
                512,
                JSON_THROW_ON_ERROR
            ));

            $php_files_collection = collect(File::allFiles(base_path('lang/'.$lang->value)))
                ->flatMap(fn ($file) => Arr::dot(
                    File::getRequire($file->getRealPath()),
                    $file->getBasename('.'.$file->getExtension()).'.'
                ));

            $full_data = $php_files_collection->merge($json_file_collection);

            file_put_contents(
                base_path('public/locales/'.$lang->value.'.json'),
                json_encode($full_data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            );
        }
    }
}
