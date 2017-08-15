<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\PrzesylkiZagraniczne;

class Ems extends Model {

    protected $fillable = [
        'kraje',
        'unique_id',
        'masa',
        'ubezpieczenie',
        'date',
    ];
    protected $table = 'ems';
    /**
     * Tabela pomocnicza zaciągnieta ze strony wskazująca id dla poszczególnych państw.
     * @var type 
     */
    public $strefySmall = [
        '563' => [
            'Albania',
            'Andora',
            'Austria',
            'Belgia',
            'Białoruś',
            'Bułgaria',
            'Czarnogóra',
            'Chorwacja',
            'Cypr',
            'Czechy',
            'Dania',
            'Estonia',
            'Finlandia',
            'Francja',
            'Gibraltar',
            'Grecja',
            'Guernesey (Wyspa)',
            'Hiszpania i Wyspy Kanaryjskie',
            'Holandia',
            'Irlandia (Eire)',
            'Islandia',
            'Izrael',
            'Jersey',
            'Liechtenstein',
            'Litwa',
            'Luksemburg',
            'Łotwa',
            'Macedonia',
            'Malta',
            'Mołdawia (Mołdowa)',
            'Monako',
            'Niemcy',
            'Norwegia',
            'Owcze Wyspy',
            'Portugalia z Azorami i Maderą',
            'Rosja',
            'Rumunia',
            'San Marino',
            'Serbia',
            'Słowacja',
            'Słowenia',
            'Szwajcaria',
            'Szwecja',
            'Turcja',
            'Ukraina',
            'Watykan',
            'Węgry',
            'Wielka Brytania i Irlandia Północna oraz Wyspa Man',
            'Włochy'],
        '564' => [
            'Algieria',
            'Benin (ex Dahomej)',
            'Bermudy',
            'Burkina Faso',
            'Czad',
            'Dżibuti',
            'Egipt',
            'Etiopia',
            'Gambia',
            'Ghana',
            'Grenlandia',
            'Gwinea (Republika)',
            'Kanada',
            'Kenia',
            'Kongo (Republika Demokratyczna d. Zair)',
            'Malawi',
            'Mali',
            'Maroko',
            'Mauritius',
            'Majotta (wyspa)',
            'Meksyk',
            'Niger',
            'Nigeria',
            'Republika Południowej Afryki',
            'Republika Środkowoafrykańska (Centrafrique)',
            'Senegal',
            'Seszele',
            'Sierra Leone',
            'Stany Zjednoczone',
            'Suazi (Swaziland)',
            'Święty Piotr i Miquelon',
            'Tanzania',
            'Togo',
            'Tunezja',
            'Uganda',
            'Wybrzeże Kości Słoniowej',
            'Zambia',
            'Zimbabwe',
        ],
        '565' => [
            'Anguilla',
            'Arabia Saudyjska',
            'Argentyna',
            'Armenia',
            'Aruba',
            'Azerbejdżan',
            'Bahamy',
            'Bahrajn',
            'Bangladesz',
            'Barbados',
            'Bhutan',
            'Boliwia',
            'Brazylia',
            'Brunei - Darussalam',
            'Chile',
            'Chińska Republika Ludowa',
            'Curacao',
            'Ekwador',
            'Filipiny',
            'Gruzja',
            'Gujana',
            'Gujana Francuska',
            'Gwadelupa',
            'Hongkong',
            'Indie',
            'Indonezja',
            'Irak',
            'Iran',
            'Japonia',
            'Jordania',
            'Kajmany',
            'Katar',
            'Kazachstan',
            'Kirgistan',
            'Kolumbia',
            'Korea Południowa',
            'Kuba',
            'Kuwejt',
            'Makau (Makao)',
            'Malediwy',
            'Malezja',
            'Martynika',
            'Oman',
            'Pakistan',
            'Panama',
            'Peru',
            'Singapur',
            'Sri Lanka',
            'Syria',
            'Święta Łucja',
            'Tadżykistan',
            'Tajlandia',
            'Tajwan',
            'Trynidad i Tobago',
            'Turkmenistan',
            'Urugwaj',
            'Wietnam',
            'Zjednoczone Emiraty Arabskie'
        ],
        '566' => [
            'Australia',
            'Nowa Zelandia',
            'Salomona Wyspy',
            'Vanuatu'
        ],
        '567' => [
            'Botswana',
            'Dominikana',
            'Fidżi',
            'Gabon',
            'Grenada',
            'Gwatemala',
            'Honduras',
            'Jamajka',
            'Kamerun',
            'Kostaryka',
            'Lesotho',
            'Madagaskar',
            'Mauretania',
            'Mozambik',
            'Namibia',
            'Nikaragua',
            'Nowa Kaledonia',
            'Papua Nowa Gwinea',
            'Paragwaj',
            'Reunion',
            'Salwador',
            'Sudan',
            'Surinam',
            'Wenezuela'
        ]
    ];

    /**
     * Metoda odpowiedzialna za zapisanie do tabeli ems wszytkich pozycji EMS 
     */
    public static function saveToEms() {

        $ems_to_save = PrzesylkiZagraniczne::getEms();
        foreach ($ems_to_save as $row) {
            EMS::insert([
                'kraj' => $row->kraj,
                'unique_id' => $row->unique_id,
                'masa' => $row->masa,
                'ubezpieczenie' => $row->ubezpieczenia,
                'date' => $row->date,
            ]);
        }
    }

    /**
     * Funkcja odpowiedzialna za pobranie pliku json i zwrócenie go w formie tablicy
     * @return type
     */
    public static function getPricesFromJson() {
        $path = storage_path('/cenniki_poczta/ems_output.json');
        $array_json = json_decode(file_get_contents($path), true);

        return $array_json;
    }


    /**
     * Metoda sprawdza czy przy jakimś z rekordów jest pozycja ubezpieczenie i na podstawie danych ze strony dolicza 
     * do $price_insurance należność za takowe ubezpieczenie. Zwraca wartość która została zliczona. 
     * 
     * Ta metoda będzie musiała zostać updatowana
     * @return real
     */
    public static function setInsuranceAndCount() {
        $price_insurance = 0;

        $insurance = Ems::where('ubezpieczenie', '>', '0')->get();
        foreach ($insurance as $row) {

            if ($row->ubezpieczenie < 500) {
                $price_insurance += 3.5;
            } elseif ($row->ubezpieczenie <= 1000 && $row->ubezpieczenie >= 500) {
                $price_insurance += 4.5;
            } else {
                $price_insurance += 8.5;
            }
        }
        return $price_insurance;
    }

    /*
     * Funkcja sumuje wszystkie zwrócone wyniki przez metody wyliczające opłaty za poszczególne usługi Poczty-Polskiej.
     */

    public static function addAllPricesEms() {
        $insuare = 0;
        $count_all_prices = 0;
        $count_all_prices += Ems::setPriceWithWeightZoneA();
        $count_all_prices += Ems::setPriceWithWeightZoneB();
        $count_all_prices += Ems::setPriceWithWeightZoneC();
        $count_all_prices += Ems::setPriceWithWeightZoneD();
        $insuare += Ems::setInsuranceAndCount();
        $count_all_prices * 0.23;
        $prices = ["count_all_prices" => $count_all_prices, "insuare" => $insuare];
        return $prices;
    }

    /**
     * Funkcja odpowiedzialna za nadanie id-ika (potrzebnego do wyliczenia ceny) według tabeli wagowej.
     * Funkcja query buildera jest sprawdzane czy masa znajduje się pomiędzy wskazanymi wartościami. Jeżeli tak to idik jest aktualizowany.
     */
    public function setWeight() {
                        DB::table('ems')->whereBetween('masa', [0  ,0.49]) ->update(['idMasa' => '568']);
                        DB::table('ems')->whereBetween('masa', [0.5, 0.99])->update(['idMasa' => '84']);
                        DB::table('ems')->whereBetween('masa', [1,  1.99]) ->update(['idMasa' => '85']);
                        DB::table('ems')->whereBetween('masa', [2,  2.99]) ->update(['idMasa' => '86']);
                        DB::table('ems')->whereBetween('masa', [3,  3.99]) ->update(['idMasa' => '87']);
                        DB::table('ems')->whereBetween('masa', [4,  4.99]) ->update(['idMasa' => '88']);
                        DB::table('ems')->whereBetween('masa', [5,  5.99]) ->update(['idMasa' => '89']);
                        DB::table('ems')->whereBetween('masa', [6,  6.99]) ->update(['idMasa' => '90']);
                        DB::table('ems')->whereBetween('masa', [7,  7.99]) ->update(['idMasa' => '91']);
                        DB::table('ems')->whereBetween('masa', [8,  8.99]) ->update(['idMasa' => '92']);
                        DB::table('ems')->whereBetween('masa', [9,  9.99]) ->update(['idMasa' => '93']);
                        DB::table('ems')->whereBetween('masa', [10,10.99]) ->update(['idMasa' => '94']);
                        DB::table('ems')->whereBetween('masa', [11,11.99]) ->update(['idMasa' => '95']);
                        DB::table('ems')->whereBetween('masa', [12,12.99]) ->update(['idMasa' => '96']);
                        DB::table('ems')->whereBetween('masa', [13,13.99]) ->update(['idMasa' => '97']);
                        DB::table('ems')->whereBetween('masa', [14,14.99]) ->update(['idMasa' => '98']);
                        DB::table('ems')->whereBetween('masa', [15,15.99]) ->update(['idMasa' => '99']);
                        DB::table('ems')->whereBetween('masa', [17,17.99]) ->update(['idMasa' => '100']);
                        DB::table('ems')->whereBetween('masa', [18,18.99]) ->update(['idMasa' => '101']);
                        DB::table('ems')->whereBetween('masa', [18,18.99]) ->update(['idMasa' => '102']);
                        DB::table('ems')->whereBetween('masa', [19,20])    ->update(['idMasa' => '103']);
    }
    /**
     * Metoda odpowiedzialna za nastawienie odpowiedniego idika według strefy w jakiej jest poszczególny kraj.
     * Używając Query Buildera jeżeli w tablei znajdzie się kraj ze $strefy[xyz] to jest aktualizowana strefa o numer idika.
     */
    public function setIdFromStrefa() {
                $strefy = $this->strefySmall;
                 DB::table('ems')->whereIn('kraj', $strefy[563])->update(['strefa'=>'563']);
                 DB::table('ems')->whereIn('kraj', $strefy[564])->update(['strefa'=>'564']);
                 DB::table('ems')->whereIn('kraj', $strefy[565])->update(['strefa'=>'565']);
                 DB::table('ems')->whereIn('kraj', $strefy[566])->update(['strefa'=>'566']);
                 DB::table('ems')->whereIn('kraj', $strefy[567])->update(['strefa'=>'567']);
        }
        
        /**
         * Metoda wskazuje według idków scalonych w 324 linijce odpowiednią cenę za usługę Poczty Polskiej.
         * Najpierw pobiera ceny według oraz pozycje z tabeli ems. Następnie parametry są przekazywane do pętli foreach. W międzyczasie 
         * scalony zostaje id-ik z dwóch kolumn odpowiedzialnych za waga i strefe. W ostatniej linijce kodu jeżeli id się zgadza cena jest aktualizowana
         * po $keyu z tablicy z cenami.
         */
    public function setPriceFromId(){
        $arrayOfPrices = Ems::getPricesFromJson();
       $id = DB::table('ems')->select('strefa' ,'idMasa' ,'id','unique_id')->get();
       $id  = json_decode(json_encode($id), true);
       foreach ($id as $row){
           $string = $row['strefa'] ."," . $row['idMasa'];
           foreach ($arrayOfPrices as $price =>$key ){
               if($string == $price){
                echo "DB=".$string . "array=".$price . "=".$key ."<br>".$row['id']."<br>";
                Ems::where("id", "=", $row["id"])->update(["cena" => $key]);
               }
           }
       }
    }
}
