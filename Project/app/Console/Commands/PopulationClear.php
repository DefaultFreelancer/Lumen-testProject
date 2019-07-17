<?php
namespace App\Console\Commands;


use App\City;
use Illuminate\Console\Command;

class PopulationClear extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'population:clear {--directory=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Dump all data to json and clear the database!";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = '/storage/app/';
        if($this->option('directory')){
            $path = $this->option('directory');
        }

        $model = City::all();
        $newJsonString = json_encode($model, JSON_PRETTY_PRINT);
        file_put_contents(base_path($path.'/'.rand(0000, 9999).'_'.time().'_jsonData.json'), stripslashes($newJsonString));

        City::truncate();
        $this->info('Done!');
    }
}
