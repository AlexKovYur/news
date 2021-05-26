<?php

namespace App\Console\Commands;

use App\Models\Weather;
use Illuminate\Console\Command;
use phpQuery;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser_weather:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing weather data';

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
     * @return int
     */
    public function handle()
    {
        $url = 'https://www.gismeteo.ru';
        $file = file_get_contents($url);

        $doc = phpQuery::newDocument($file);

        //Город
        $city = pq('.weather_current_link')->text();
        //Темпиратура
        $tempurature = trim(pq('.js_meas_container .unit_temperature_c')->text() , $characters = " \n\r\t\v\0" );
        //Облачно, Малооблачно и т.д
        $description = trim(pq('.description')->text() , $characters = " \n\r\t\v\0" );
        //Влажность
        $humidityTitle = pq('._additional')->find('.info_item:eq(1)')->find('.info_label')->text();
        $humidity = $humidityTitle === 'Влажность' ?
            (int)pq('._additional')->find('.info_item:eq(1)')->find('.value')->text() :
                null;

        Weather::create([
            'city' => $city,
            'tempurature' => $tempurature,
            'description' => $description,
            'humidity' => $humidity,
            'source' => $url,
        ]);

    }
}
