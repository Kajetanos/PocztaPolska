<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\PrzesylkiZagraniczne;
use Storage;

class PrzesylkaPoleconaZagraniczna extends Model {

    protected $table = 'przesylka_polecona_zagranicznas';
    //podatek vat zwrot

    protected $fillable = [
        'unique_id',
        'masa',
        'strefa',
        'usluga',
        'kraj',
        'cena',
        'date'];
    public $timestamps = true;

    /**
     * Funkcja zapisuje wszystkie przesylki zagraniczne
     */
    public static function getAndSavePrzesylkaZagraniczne() {

        $przesylka_pocztowa_pozstale_kraje = PrzesylkiZagraniczne::getPrzesylkaPocztowaPozstaleKraje();
        foreach ($przesylka_pocztowa_pozstale_kraje as $rest_country) {
            PrzesylkaPoleconaZagraniczna::insert([
                'unique_id' => $rest_country->unique_id,
                'masa' => $rest_country->masa,
                'kraj' => $rest_country->kraj,
                'usluga' => $rest_country->usluga,
                'date'  =>$rest_country->date,
            ]);
        }
        $przesylka_pocztowa_zagraniczna = PrzesylkiZagraniczne::getPrzesylkaPocztowaZagraniczna();
        foreach ($przesylka_pocztowa_zagraniczna as $row) {
            PrzesylkaPoleconaZagraniczna::insert([
                'unique_id' => $row->unique_id,
                'masa' => $row->masa,
                'kraj' => $row->kraj,
                'usluga' => $row->usluga,
                'date'  =>$row->date,
            ]);
        }
    }

    public static function splitIntoZone() {
        $strefa20 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '=', '20')->get();
    }

    /**
     * Funkcja odpowiedzialna za pobranie pliku json i zwrócenie go w formie tablicy
     * @return type
     */
    public static function getPricesFromJson() {

        $path = storage_path('/cenniki_poczta/output.json');
        $array_json = json_decode(file_get_contents($path), true);
        return $array_json;
    }

    public static function splitIntoZonesInternationalWithoutService() {

        $strefa_20 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '20')->get();
        $strefa_30 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '30')->get();  //wyciągnięta wartośc 
        $strefa_40 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '40')->get();  //wyciągnięta wartośc 
        $strefa_10 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '10')->get();
        $strefa_11 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '11')->get();
        $strefa_12 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '12')->get();
        $strefa_13 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '13')->get();
        $date = date('Y-m-d H:i:s');
        foreach ($strefa_20 as $row) {
            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$row->nazwa_kraju")->whereNull('usluga')->update(array('strefa' => '20'));
        }
        foreach ($strefa_30 as $rowB) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowB->nazwa_kraju")->whereNull('usluga')->update(array('strefa' => '30'));
        }

        foreach ($strefa_40 as $rowC) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowC->nazwa_kraju")->whereNull('usluga')->update(array('strefa' => '40'));
        }


        foreach ($strefa_10 as $rowD) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowD->nazwa_kraju")->whereNull('usluga')->update(array('strefa' => '10'));
        }
        foreach ($strefa_11 as $rowE) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowE->nazwa_kraju")->whereNull('usluga')->update(array('strefa' => '11'));
        }
        foreach ($strefa_12 as $rowF) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowF->nazwa_kraju")->whereNull('usluga')->update(array('strefa' => '12'));
        }
        foreach ($strefa_13 as $rowG) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowG->nazwa_kraju")->whereNull('usluga')->update(array('strefa' => '13'));
        }
    }

    public static function splitIntoZonesInternationalWithService() {


        $strefa_A1 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'A1')->get();
        $strefa_A2 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'A2')->get();  //wyciągnięta wartośc 
        $strefa_A3 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'A3')->get();  //wyciągnięta wartośc 
        $strefa_A4 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'A4')->get();
        $strefa_A5 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'A5')->get();
        $strefa_B = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'B')->get();
        $strefa_C = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'C')->get();
        $strefa_D = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'D')->get();
        $date = date('Y-m-d H:i:s');
        foreach ($strefa_A1 as $row) {
            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$row->nazwa_kraju")->where('usluga', '=', 'R')->update(array('strefa' => 'A1'));
        }
        foreach ($strefa_A2 as $rowB) {
            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowB->nazwa_kraju")->where('usluga', '=', 'R')->update(array('strefa' => 'A2'));
        }

        foreach ($strefa_A3 as $rowC) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowC->nazwa_kraju")->where('usluga', '=', 'R')->update(array('strefa' => 'A3'));
        }
        foreach ($strefa_A4 as $rowD) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowD->nazwa_kraju")->where('usluga', '=', 'R')->update(array('strefa' => 'A4'));
        }
        foreach ($strefa_A5 as $rowE) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowE->nazwa_kraju")->where('usluga', '=', 'R')->update(array('strefa' => 'A5'));
        }
        foreach ($strefa_B as $rowF) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowF->nazwa_kraju")->where('usluga', '=', 'R')->update(array('strefa' => 'B'));
        }
        foreach ($strefa_C as $rowG) {

            PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowG->nazwa_kraju")->where('usluga', '=', 'R')->update(array('strefa' => 'C'));
            foreach ($strefa_D as $rowH) {

                PrzesylkaPoleconaZagraniczna::where('kraj', '=', "$rowH->nazwa_kraju")->where('usluga', '=', 'R')->update(array('strefa' => 'D'));
            }
        }
    }

    public static function setPriceWithWeightZoneA1() {


        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', 'A1')->select('masa', 'id', 'cena')->get();
        $ilosc = count($waga);
        $suma = 0;
        $x = "104,";
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? $masa->cena = $array_json[$x . '84'] : 0;  //wartość 60
                $cenaThree = ($masa->masa <= 2 && $masa->masa <= 1) ? $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa <= 2) ? $masa->cena = $array_json[$x . '86'] : 0; //wartość 80
                $cenaFive = ($masa->masa <= 4 && $masa->masa <= 3) ? $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa <= 4) ? $masa->cena = $array_json[$x . '88'] : 0;  //102
                
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? $masa->cena = $array_json[$x . '93'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? $masa->cena = $array_json[$x . '94'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? $masa->cena = $array_json[$x . '95'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? $masa->cena = $array_json[$x . '96'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? $masa->cena = $array_json[$x . '97'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;

                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? $masa->cena = $array_json[$x . '98'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? $masa->cena = $array_json[$x . '99'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneA2() {

        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', 'A2')->select('masa', 'id')->get();
        $ilosc = count($waga);
        $suma = 0;
        $x = '105,';
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;


                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneA3() {

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', 'A3')->select('masa', 'id')->get();

        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        $ilosc = count($waga);
        $suma = 0;
        $x = '108,';
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneA4() {

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', 'A4')->select('masa', 'id')->get();
        $ilosc = count($waga);

        $suma = 0;
        $x = '109,';
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneA5() {

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', 'A5')->select('masa', 'id')->get();
        $ilosc = count($waga);

        $suma = 0;
        $x = '110,';
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneB() {

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', 'B')->select('masa' , 'id')->get();
        $ilosc = count($waga);

        $suma = 0;
        $x = '65,';
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneC() {

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', 'C')->select('masa', 'id')->get();
        $ilosc = count($waga);

        $suma = 0;
        $x = '66,';
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZoneD() {

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', 'D')->select('masa' , 'id')->get();
        $ilosc = count($waga);

        $suma = 0;
        $x = '67,';
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZone10() {

        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', '10')->select('masa' , 'id')->get();
        $ilosc = count($waga);

        $suma = 0;
        $x = '111,';
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZone11() {


        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', '11')->select('masa' , 'id')->get();
        $ilosc = count($waga);
        $ilosc = count($waga);
        $suma = 0;
        $x = '112,';
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;
                
                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZone12() {


        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', '12')->select('masa' , 'id')->get();
        $ilosc = count($waga);
        $suma = 0;
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        $x = '113,';
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }

        return $suma;
    }

    public static function setPriceWithWeightZone13() {


        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', '13')->select('masa' , 'id')->get();
        $ilosc = count($waga);
        $suma = 0;
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        $x = '114,';
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZone20() {


        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', '20')->select('masa' , 'id')->get();
        $ilosc = count($waga);
        $suma = 0;
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        $x = '115,';
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZone30() {


        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', '30')->select('masa', 'id')->get();
        $ilosc = count($waga);
        $suma = 0;
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        $x = '116,';
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }
        return $suma;
    }

    public static function setPriceWithWeightZone40() {


        $waga = PrzesylkaPoleconaZagraniczna::where('strefa', '=', '40')->select('masa', 'id')->get();
        $ilosc = count($waga);
        $suma = 0;
        $array_json = PrzesylkaPoleconaZagraniczna::getPricesFromJson();
        $x = '117,';
        foreach ($waga as $masa) {

            if ($masa->masa <= 5) {

                $cenaTwo = ($masa->masa <= 1) ? (double) $masa->cena = $array_json[$x . '84'] : 0;
                $cenaThree = ($masa->masa <= 2 && $masa->masa > 1) ? (double) $masa->cena = $array_json[$x . '85'] : 0;
                $cenaaFour = ($masa->masa <= 3 && $masa->masa > 2) ? (double) $masa->cena = $array_json[$x . '86'] : 0;
                $cenaFive = ($masa->masa <= 4 && $masa->masa > 3) ? (double) $masa->cena = $array_json[$x . '87'] : 0;
                $cenaSix = ($masa->masa <= 5 && $masa->masa > 4) ? (double) $masa->cena = $array_json[$x . '88'] : 0;

                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                $suma += $cenaSix;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }

            if ($masa->masa > 5 && $masa->masa <= 10) {
                $cenaOne = ($masa->masa <= 6 && $masa->masa > 5) ? (double) $masa->cena = $array_json[$x . '89'] : 0;
                $cenaTwo = ($masa->masa <= 7 && $masa->masa > 6) ? (double) $masa->cena = $array_json[$x . '90'] : 0;
                $cenaThree = ($masa->masa <= 8 && $masa->masa > 7) ? (double) $masa->cena = $array_json[$x . '91'] : 0;
                $cenaaFour = ($masa->masa <= 9 && $masa->masa > 8) ? (double) $masa->cena = $array_json[$x . '92'] : 0;
                $cenaFive = ($masa->masa <= 10 && $masa->masa > 9) ? (double) $masa->cena = $array_json[$x . '93'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } elseif ($masa->masa > 10 && $masa->masa <= 15) {
                $cenaOne = ($masa->masa <= 11 && $masa->masa > 10) ? (double) $masa->cena = $array_json[$x . '94'] : 0;
                $cenaTwo = ($masa->masa <= 12 && $masa->masa > 11) ? (double) $masa->cena = $array_json[$x . '95'] : 0;
                $cenaThree = ($masa->masa <= 13 && $masa->masa > 12) ? (double) $masa->cena = $array_json[$x . '96'] : 0;
                $cenaaFour = ($masa->masa <= 14 && $masa->masa > 13) ? (double) $masa->cena = $array_json[$x . '97'] : 0;
                $cenaFive = ($masa->masa <= 15 && $masa->masa > 14) ? (double) $masa->cena = $array_json[$x . '98'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            } else {
                $cenaOne = ($masa->masa <= 16 && $masa->masa > 15) ? (double) $masa->cena = $array_json[$x . '99'] : 0;
                $cenaTwo = ($masa->masa <= 17 && $masa->masa > 16) ? (double) $masa->cena = $array_json[$x . '100'] : 0;
                $cenaThree = ($masa->masa <= 18 && $masa->masa > 17) ? (double) $masa->cena = $array_json[$x . '101'] : 0;
                $cenaaFour = ($masa->masa <= 19 && $masa->masa > 18) ? (double) $masa->cena = $array_json[$x . '102'] : 0;
                $cenaFive = ($masa->masa <= 20 && $masa->masa > 19) ? (double) $masa->cena = $array_json[$x . '103'] : 0;

                $suma += $cenaOne;
                $suma += $cenaTwo;
                $suma += $cenaThree;
                $suma += $cenaaFour;
                $suma += $cenaFive;
                PrzesylkaPoleconaZagraniczna::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
            }
        }

        return $suma;
    }

    public static function addAllPricesZagraniczne() {

        $count_all_prices = 0;
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZone10();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZone11();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZone12();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZone13();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZone20();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZone30();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZone40();

        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZoneA1();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZoneA2();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZoneA3();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZoneA4();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZoneA5();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZoneB();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZoneC();
        $count_all_prices += PrzesylkaPoleconaZagraniczna::setPriceWithWeightZoneD();

        return $count_all_prices;
    }
    
    
    public static function setPriceWithWeight() {
        
    }

}
