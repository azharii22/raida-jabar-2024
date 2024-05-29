<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\Setting;
use \Illuminate\Support\Arr;

class LoadSettingsFromFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:load-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load settings from file, this command is not overriding db values.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = Arr::dot(require config_path('settings.php'));
        foreach ($settings as $key => $value) {
            Setting::query()
                ->firstOrCreate([
                    'key' => $key,
                ], [
                    'value' => $value,
                ]);
        }

        Setting::refreshCache();

        $this->info('Setting file has been loaded successfully.');

        return Command::SUCCESS;
    }
}
