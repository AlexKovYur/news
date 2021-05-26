<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use phpQuery;

class GetCurrencyExchange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser_currency_exchange:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing currency exchange data';

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
        $url = 'https://ru.investing.com/crypto';
        $context = stream_context_create(
            array(
                'http' => array(
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36',
                ),
            ));
        $file = file_get_contents($url, false, $context);

        $doc = phpQuery::newDocument($file);

        $cryptoTableTr = pq('.js-top-crypto-table tbody')->find('tr');

        $flag = 0;
        foreach ($cryptoTableTr as $keyTableTr => $valTableTr){

            //Записываем 3 первые монеты
            if ($flag === 3) {
                break;
            }

            //Название монеты
            $currencyName = pq($valTableTr)->find('.js-currency-name a')->text();
            //Символ монеты
            $currencySymbol = pq($valTableTr)->find('.js-currency-symbol')->text();
            //Стоимость монеты
            $cost = pq($valTableTr)->find('.js-currency-price a')->text();
            //Находим точку отделяющую тысячные и удаляем
            $cost = str_replace('.','', $cost);
            //Заменяем запятую отделяющую сотые на точку
            $cost = str_replace(',','.', $cost);
            //Изменения за 24 часа
            $change24h = pq($valTableTr)->find('.js-currency-change-24h')->text();

            Currency::create([
                'currency_symbol' => $currencySymbol,
                'cost' => $cost,
                'change_24h' => $change24h,
                'currency_name' => $currencyName,
            ]);

            $flag++;
        }

    }
}
