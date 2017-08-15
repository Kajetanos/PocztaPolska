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

    public function setId($kraj) {

        foreach ($this->strefy as $strefa) {
            foreach ($strefa['kraje'] as $k) {
                if ($k === $kraj) {
                    return $strefa['id'];
                }
            }
        }
    }

    /**
     * Metoda dodajé do wszystkich 
     */
    public static function setStref() {
        $strefy = DB::table('wykaz_stref_ems')->get();
        $emsStrefy = Ems::where("kraj", ">", "0")->select('kraj', 'id')->get();

        foreach ($strefy as $strefa) {
            foreach ($emsStrefy as $dbStrefa) {
                if ($strefa->nazwa_kraju == $dbStrefa->kraj) {
                    Ems::where("id", "=", "$dbStrefa->id")->update(["strefa" => $strefa->strefa]);
                }
            }
        }
    }

    public static function setPriceWithWeightZoneA() {
        Ems::setStref();
        $waga = Ems::where('strefa', '=', 'A')->select('masa')->get();
        $suma = 0;
        $array_json = Ems::getPricesFromJson();
        $x = '563,';

        foreach ($waga as $masa) {


            if ($masa->masa <= 5) {

                $cenaOne = ($masa->masa <= 0.5) ? $masa->cena = $array_json[$x . '568'] : 0;
                $cenaTwo = ($masa->masa <= 1 && $masa->masa > 0.5) ? $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? $masa->cena = $array_json[$x . '88'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
            }

            if ($masa->masa > 5 && $masa->masa < 10) {
                $cenaOne = ($masa->masa >= 6 && $masa->masa > 5) ? $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa >= 7 && $masa->masa > 6) ? $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa >= 8 && $masa->masa > 7) ? $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa >= 9 && $masa->masa > 8) ? $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa >= 10 && $masa->masa > 9) ? $masa->cena = $array_json[$x . '93'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            } elseif ($masa->masa > 10 && $masa->masa < 15) {
                $cenaOne = ($masa->masa >= 11 && $masa->masa > 10) ? $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa >= 12 && $masa->masa > 11) ? $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa >= 13 && $masa->masa > 12) ? $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa >= 14 && $masa->masa > 13) ? $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa >= 15 && $masa->masa > 14) ? $masa->cena = $array_json[$x . '98'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            } else {
                $cenaOne = ($masa->masa >= 16 && $masa->masa > 15) ? $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa >= 17 && $masa->masa > 16) ? $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa >= 18 && $masa->masa > 17) ? $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa >= 19 && $masa->masa > 18) ? $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa >= 20 && $masa->masa > 19) ? $masa->cena = $array_json[$x . '103'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneB() {
        $suma = 0;
//        $waga = Ems::where('strefa', '=', 'B')->select('masa')->get();
        $array_of_value_ems = ['id', 'unique_id', 'strefa', 'masa', 'ubezpieczenie', 'cena', 'kraj'];
        $waga = Ems::where('strefa', '=', 'B')->select($array_of_value_ems)->get();

        $array_json = Ems::getPricesFromJson();
        $x = '564,';
        foreach ($waga as $key => $masa) {
            if ($masa->masa <= 5) {
                $cenaOne = ($masa->masa <= 0.5) ? $masa->cena = $masa->cena = $array_json[$x . '568'] : 0;
                $cenaTwo = ($masa->masa <= 1 && $masa->masa > 0.5) ? $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? $masa->cena = $masa->cena = $array_json[$x . '87'] : 0;

                Ems::where("masa", "=", "$masa->id")->update(["cena" => $masa->cena]);

                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
            }

            if ($masa->masa > 5 && $masa->masa < 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? $masa->cena = $array_json[$x . '93'] : 0;

                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? $masa->cena = $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? $masa->cena = $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? $masa->cena = $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? $masa->cena = $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? $masa->cena = $masa->cena = $array_json[$x . '98'] : 0;

                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? $masa->cena = $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? $masa->cena = $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? $masa->cena = $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? $masa->cena = $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? $masa->cena = $masa->cena = $array_json[$x . '103'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneC() {

        $suma = 0;
        $waga = Ems::where('strefa', '=', 'C')->select('masa', 'id')->get();
        $array_json = Ems::getPricesFromJson();
        $x = '566,';

        foreach ($waga as $masa) {
            if ($masa->masa <= 5) {

                $cenaOne = ($masa->masa <= 0.5) ? $masa->cena = $array_json[$x . '568'] : 0;
                $cenaTwo = ($masa->masa <= 1 && $masa->masa >= 0.5) ? $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa >= 1) ? $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa >= 2) ? $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa >= 3) ? $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa >= 4) ? $masa->cena = $array_json[$x . '88'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
            }

            if ($masa->masa > 5 && $masa->masa < 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? $masa->cena = $array_json[$x . '93'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            } elseif ($masa->masa > 10 && $masa->masa < 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? $masa->cena = $array_json[$x . '98'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? $masa->cena = $array_json[$x . '103'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneD() {

        $waga = Ems::where('strefa', '=', 'D')->get();
        $suma = 0;
        $array_json = Ems::getPricesFromJson();
        $x = '566,';
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaOne = ($masa->masa <= 0.5) ? $masa->cena = $array_json[$x . '568'] : 0;
                $cenaTwo = ($masa->masa <= 1 && $masa->masa >= 0.5) ? $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? $masa->cena = $array_json[$x . '88'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
            }

            if ($masa->masa > 5 && $masa->masa < 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? $masa->cena = $array_json[$x . '93'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            } elseif ($masa->masa > 10 && $masa->masa < 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? $masa->cena = $array_json[$x . '93'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? $masa->cena = $array_json[$x . '94'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? $masa->cena = $array_json[$x . '95'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? $masa->cena = $array_json[$x . '96'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? $masa->cena = $array_json[$x . '97'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            }if ($masa->masa >= 15) {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? $masa->cena = $array_json[$x . '98'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? $masa->cena = $array_json[$x . '99'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? $masa->cena = $array_json[$x . '100'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? $masa->cena = $array_json[$x . '101'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? $masa->cena = $array_json[$x . '102'] : 0;
                Ems::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]);

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            }
        }
        return $suma;
    }

    /**
     * Metoda sprawdza czy przy jakimś z rekordów jest pozycja ubezpieczenie i na podstawie danych ze strony dolicza 
     * do $price_insurance należność za takowe ubezpieczenie. Zwraca wartość która została zliczona. 
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

//        $toSearch = Ems::all();
//            $rating = $toSearch->groupBy(function ($date, $key) {
//             return $date['date'];
//        });    
//            $rating = json_decode(json_encode((array) $rating), true);
//             foreach ($rating as $row){
//                 dd($row);
//                 foreach ($row as $row_next){
//                     echo dd($row_next[2]);
//                 }
//             }

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

    public static function addPricesWithWeight($objectToSetId) {

        foreach ($objectToSetId as $row) {
            foreach ($row->masa as $masa) {
                if ($masa === $tabelMasa) {
                    Ems::update(['masaId' => $masa['id']]);
                }
            }
        }
    }

    public static function addIdWithStrefa($objectToSetId) {
        foreach ($objectToSetId as $row) {
            foreach ($row->kraj as $kraj) {
                if ($kraj == $wykazStref) {
                    Ems::update(['strefaId' => $wykazStref["$kraj"]]);
                }
            }
        }
    }

    public static function setPrice($objectToSetId) {
        $prices = [];
        foreach ($objectToSetId as $ids) {
            $id = $ids->masaId . $ids->strefaId;
        }
    }

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

    public function setIdFromStrefa() {
                $strefy = $this->strefySmall;
                 DB::table('ems')->whereIn('kraj', $strefy[563])->update(['strefa'=>'563']);
                 DB::table('ems')->whereIn('kraj', $strefy[564])->update(['strefa'=>'564']);
                 DB::table('ems')->whereIn('kraj', $strefy[565])->update(['strefa'=>'565']);
                 DB::table('ems')->whereIn('kraj', $strefy[566])->update(['strefa'=>'566']);
                 DB::table('ems')->whereIn('kraj', $strefy[567])->update(['strefa'=>'567']);
        }
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
