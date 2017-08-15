<?php

namespace App\Http\Controllers;

use App\Ems;
use App\Raport;
use App\PrzesylkaPolecona;
use Illuminate\Http\Request;
use App\PrzesylkiZagraniczne;
use App\PrzesylkaPoleconaZagraniczna;
use App\Strfa_A;
use App\GlobalExpress;
use Illuminate\Support\Facades\DB;
//use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Form;
//use Input;

class PaczkaKrajowaController extends Controller {

    public function collections(Request $request) {
//        $months = ;
        for((int)$i =1 ; $i<13 ; $i++ ){
        $arrayPoleconeZagraniczne[]= \App\PrzesylkaPoleconaZagraniczna::where('date','=','2017-0'.$i)->get();
        $arrayKrajowe[]= PrzesylkaPolecona::where('date','=','2017-0'.$i)->get();
        $arrayGlobal []= GlobalExpress::where('date','=','2017-0'.$i)->get();
        $arrayEms    []= Ems::where('date','=','2017-0'.$i)->get();
        $months        = [  'international'=>$arrayPoleconeZagraniczne,'krajowe'=>$arrayKrajowe,'global'=>$arrayGlobal, "ems" =>$arrayEms  ];
        $months        = json_decode(json_encode((array) $months), true);
        }
        $j = $request->input('taskOption');
        var_dump($j);
          $priceCzerwiec =[ $months['international'][$j] ,$months['krajowe'][$j] , $months['global'][$j] , $months['ems'][$j]];
          $miesiace = ['Styczeń' , 'Luty' , 'Marzec' , 'Kwiecień' , 'Maj' , 'Czerwiec' ,'Lipiec', "Sierpien"];
         $allPrices = 0 ;
        foreach ($priceCzerwiec as $row ){       //foreach wyliczjacy ceny dla wszystkich prices z czerwca 
            foreach ($row as $r) {
                $allPrices += $r['cena'];
            }
        }
        
        $internationalPrice = 0 ;
        
        foreach ($months['international'][$j] as $price) {   // foreach wyliczajacy ceny dla international z czerwca 
           $internationalPrice += $price['cena'] ;
        }
        
         echo "<br>czerwiec International " .$internationalPrice;   
        $emsPrice = 0 ;
        foreach ($months['ems'][$j] as $price) {
           $emsPrice += $price['cena'] ;
        }
         echo "<br>czerwiec Ems " . $emsPrice;  
        $globalPrice = 0 ;
        foreach ($months['global'][$j] as $price) {
           $globalPrice += $price['cena'] ;
        }
         echo "<br>czerwiec global express " . $globalPrice;  
        $krajowePrice = 0 ;
//        dd($months['krajowe'][6]);
        foreach ($months['krajowe'][$j] as $price) {
           $krajowePrice += $price['cena'] ;
        }
         echo "<br>czerwiec krajowe " . $krajowePrice;  
//                dd($allPrices);
         $title = 'kalkulator';
    return view('calculate', compact('internationalPrice' , 'emsPrice' , 'globalPrice' , 'krajowePrice' , 'allPrices' ,'internationalPrice', 'title')) ;            
    }
    

    /**
     * Metoda wywołuje wszystkie metody które odczytują i zapisują xls'y.
     */
    public function save_all() {
//        PrzesylkiZagraniczne::get_stref_ems();
//        PrzesylkiZagraniczne::get_stref_paczka_pocztowa();

        
        PrzesylkaPoleconaZagraniczna::getAndSavePrzesylkiZagraniczne();
        Ems::saveToEms();
        PrzesylkaPolecona::addPolecona(); 
        GlobalExpress::saveToGlobalExpreses();
        Ems::setPriceWithWeightZoneA();
        PrzesylkaPoleconaZagraniczna::splitIntoZone();
        PrzesylkaPoleconaZagraniczna::splitIntoZonesInternationalWithoutService();
        PrzesylkaPoleconaZagraniczna::splitIntoZonesInternationalWithService();
        GlobalExpress::getEuropeZone();
        GlobalExpress::getOtherZone();
        GlobalExpress::getEuropeZone();
//        PrzesylkaPoleconaZagraniczna::get_prices_from_json();
//        GlobalExpress::get_prices_from_json();
//        GlobalExpress::set_global_price_from_other_country();
//        GlobalExpress::set_global_price_from_europe();
//        PrzesylkaPolecona::get_prices_from_json();
    }

    public static function get_parrams() {

        $all_shit = 0;
        $all_shit += PrzesylkaPolecona::setLocalPrice();                //podział na mase (ogólnie wszystkie mieściły sie w tej najniższej (jest jednak jedna paczka krajowa z większą masą ale ma inna nazwę) 
        $all_shit += PrzesylkaPoleconaZagraniczna::addAllPricesZagraniczne();
//        $all_shit += Ems::add_all_prices_ems();  // funkcja odpowiedzialna za wyliczenie wszystkich cen z EMS.
        $all_shit += GlobalExpress::setGlobalPriceFromEurope();
        $all_shit += GlobalExpress::setGlobalPriceFromOtherCountry();
//        

//        PrzesylkaPoleconaZagraniczna::set_price_from_scrapper();
//        Strfa_A::collections();
        return $all_shit;
    }

    public function main_page_controller() {

        $raports = Raport::paginate(10);
        $company = "poczta_polska";
        $title = "Poczta Polska";
        $krajowe = PrzesylkaPolecona::all();


        return view('main', compact('raports', 'title', 'company', 'krajowe'));
    }

    public function ems_controller() {

        $title = 'Ems';
        $ems = Ems::paginate(10);
        $suma = 0;
        foreach ($ems as $row) {
            $suma += $row->cena;
        }
        var_dump($suma);
        $number = Ems::all()->last();
        $count = $number->id;
        $add_all_ems = Ems::addAllPricesEms();
        $add_all = $add_all_ems ['count_all_prices'];

        return view('ems', compact('ems', 'title', 'add_all', 'count', 'suma'));
    }

    public function nationalParcelController() {
        $title = "Przesyłki krajowe";
        
        $national_parcel = PrzesylkaPolecona::paginate(10);
        $number =          PrzesylkaPolecona::all()->last();
        $count = $number->id;
        $suma = 0;
        foreach ($national_parcel as $row) {
            $suma += $row->cena;
        }

        $add_all = PrzesylkaPolecona::set_local_price();
        return view('krajowe', compact("national_parcel", "title", "suma", "count", "add_all"));
    }

    public function globalExpressController(Request $request) {
        $title = "Global Express";
        GlobalExpress::all();
        $global = GlobalExpress::paginate(10);
        $europe = GlobalExpress::setGlobalPriceFromEurope();
        $other = GlobalExpress::setGlobalPriceFromOtherCountry();
        $add_all = $europe + $other;
        $suma = 0;
        foreach ($global as $row) {
            $suma += $row->cena;
        }
        $rabat = Input::get('rabat');
        $number = GlobalExpress::all()->last();
        $count = $number->id;

        if (!empty($rabat)) {
            $add_with_rabat = $rabat * $add_all;
            $bon = $add_all - $add_with_rabat;
        }
        return view('global', compact('global', 'title', 'add_all', 'count', 'suma', 'bon'));
    }

    public function internationalRecommendedParcelController() {

        $title = "Przesyłki zagraniczne polecone";
        $international = PrzesylkaPoleconaZagraniczna::paginate(10);
        $add_all = PrzesylkaPoleconaZagraniczna::addAllPricesZagraniczne();

        $suma = 0;
        foreach ($international as $row) {
            $suma += $row->cena;
        }
        $number = PrzesylkaPoleconaZagraniczna::all()->last();
        $count = $number->id;
        return view('international', compact('title', 'international', 'add_all', 'count', 'suma'));
    }

    public function calculateController(Request $request) {

//       $request()->file(fileToUpload);//->store('/XLS');
//        $path = Storage::putFile('fileToUpload', $request->file('fileToUpload'));
        if($request->file('fileToUpload') !== null ){
//         Input::file('fileToUpload')->move(storage_path('/XLS'), 'Raport_upload_' . $date . '.ods');
//            echo $path;
        }
//            $date =  date('y_m');
//            $path = storage_path('XLS\Raport_upload_'.$date . '.ods');
//        Raport::readXls($path);
//        Raport::saveXls();
        $title = 'Wykaz cen za usługi';
        $ems = Ems::addAllPricesEms();
        $ems_price = $ems ['count_all_prices'];
        $polisch_price = PrzesylkaPolecona::setLocalPrice();
        $international = PrzesylkaPoleconaZagraniczna::addAllPricesZagraniczne();
        $global_europe = GlobalExpress::setGlobalPriceFromEurope();
        $global_other = GlobalExpress::setGlobalPriceFromOtherCountry();
//        $suma = $ems+ $polisch_price + $international + $global_europe + $global_other;
        $global = $global_europe + $global_other;
        $suma = $ems_price + $polisch_price + $international + $global;
        
        return view('calculate', compact('title', 'polisch_price', 'international', 'global', 'ems_price', 'suma'));
    
    }
  
    public function emsTesty(){
//        $objToTest = new Ems();
//        $objToTest->setIdFromStrefa();
        Ems::setIdFromStrefa();
        
    }
       
}
        
        

