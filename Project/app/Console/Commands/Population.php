<?php

namespace App\Console\Commands;

use App\City;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class Population extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'population:get {--limit=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Get population for most Cities!";

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
        $limit = '100';
        if($this->option('limit') && is_numeric($this->option('limit'))){
            $limit = $this->option('limit');
        }

        $client = new Client([
            'base_uri' => 'https://public.opendatasoft.com/api/records/1.0/search/',
            'verify' => base_path('cacert.pem'),
        ]);
        $data = $client->request('GET','?dataset=worldcitiespop&rows='. $limit .'&facet=country');
        $data = json_decode($data->getBody());
        foreach ($data->records as $val){
            if(City::where(['recordid' => $val->recordid])->first()){
                $model = City::where(['recordid' => $val->recordid])->first();
            }else{
                $model = new City();
            }
            $model->datasetid   = $val->datasetid;
            $model->recordid    = $val->recordid;
            $model->city_name   = $val->fields->city;
            $model->country     = $val->fields->country;
            $model->region      = $val->fields->region;
            $model->longitude   = $val->fields->longitude;
            $model->latitude    = $val->fields->latitude;
            $model->save();
        }
        $this->info($limit. ' tables has been imported!');
    }

}
