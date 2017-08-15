<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Raport;

class PrzesylkaPolecona extends Model
{
    
     protected $table = 'przesylka_polecona';
     public $masaLow;
       protected $fillable = [ 'gabaryt','masa','ilosc','usluga','stawka_vat','cena'] ;
     
     /**
      * Metoda pobiera z tabeli Raport->rodzaj przeyłki i zapisuje do tabeli przesylka polecona.
      * @return type
      */
    public static function addPolecona (){
        
        $polecone = Raport::where('rodzaj_przesylki', '=', 'Przesyłka polecona')
               ->orderBy('rodzaj_przesylki', 'asc')
               ->get();
        foreach ($polecone as $row){
            
        PrzesylkaPolecona::insert(
                ['gabaryt' => $row->gabaryt,
                'masa' => $row->masa,
                'ilosc'=> $row->ilosc,
                'usluga'=>$row->usluga,
                'stawka_vat'=> $row->stawkaVat,
                'date'      => $row->date,
                ]);
        }
        return $polecone;
    }
    
    /**
     * Metoda pobiera i dzieli rekordy na poszczególne masy. 
     * @return type
     */
    public static function get_and_share (){
        
        $masaLow    = PrzesylkaPolecona::where('masa' , '<' , '0.35')->get();
        $masaMedium = PrzesylkaPolecona::where('masa', '<' , '1')->get();
        $masaHigh   = PrzesylkaPolecona::where('masa','>' , '1')->get();
        
        return $masaLow;
    }
        public static function getPricesFromJson(){
         $path = storage_path('/cenniki_poczta/przesylka_listow_niezarejestrowana_output.json');
        $array_json = json_decode(file_get_contents($path), true);
        
        return $array_json;
    }
    

    /**
     * 
     * @return real
     */
    public static function setLocalPrice(){
        $suma = 0 ;
        $waga  = PrzesylkaPolecona::select('masa' , 'usluga' ,'gabaryt' , 'id' , 'cena' )->get();

        $array_json = PrzesylkaPolecona::getPricesFromJson();
        $x = ',235';
       foreach ($waga as $masa){
        if( $masa->usluga == '' && $masa->gabaryt == 'A'  ){
           $cenaOne   += ($masa->masa<=0.35)              ? $masa->cena =  $array_json['68,10,22']  : 0 ;
           $cenaTwo  = ($masa->masa<=1&&$masa->masa>0.35)? $masa->cena =  $array_json['68,10,23']  : 0 ;
           $cenaThree= ($masa->masa<=2&&$masa->masa>1)   ? $masa->cena =  $array_json['17,10,22']  : 0 ;
          $suma +=$cenaOne ;
          $suma +=$cenaTwo;
          $suma +=$cenaThree ;
          PrzesylkaPolecona::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";
          
        }elseif(($masa->usluga == 'R'|| $masa->usluga == 'OR')&& $masa->gabaryt == 'A' ){
           $cenaOne = ($masa->masa<=0.35)                   ? $masa->cena =  $array_json['68,9,22']  : 0 ;
           $cenaTwo  = ($masa->masa<=1&&$masa->masa>0.35)   ? $masa->cena =  $array_json['69,9,22']  : 0 ;
           $cenaThree= ($masa->masa<=2&&$masa->masa>1)      ? $masa->cena =  $array_json['17,9,23']  : 0 ;
          $suma +=$cenaOne ;
          $suma +=$cenaTwo;
          $suma +=$cenaThree ;
          PrzesylkaPolecona::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";  

        }elseif($masa->usluga == ''&& $masa->gabaryt == 'B' ){
           $cenaOne   = ($masa->masa<=0.35)                 ? $masa->cena =  $array_json['68,10,23']  : 0 ;
           $cenaTwo   = ($masa->masa<=1&&$masa->masa>0.35)  ? $masa->cena =  $array_json['69,10,23']  : 0 ;
           $cenaThree   = ($masa->masa<=1&&$masa->masa>0.35)? $masa->cena =  $array_json['17,10,23']  : 0 ;
           $suma +=$cenaOne ;
           $suma +=$cenaTwo;
           $suma +=$cenaThree ;
          PrzesylkaPolecona::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";  
        }elseif(($masa->usluga == 'R'||$masa->usluga == 'OR')&& $masa->gabaryt == 'B'){
           $cenaOne  = ($masa->masa<=0.35)                 ? $masa->cena =  $array_json['68,9,23']  : 0 ;
           $cenaTwo  = ($masa->masa<=1&&$masa->masa>0.35)  ? $masa->cena =  $array_json['17,10,23']  : 0 ;
           $cenaThree  = ($masa->masa<=1.5&&$masa->masa>1) ? $masa->cena =  $array_json['17,9,23']  : 0 ;
           $suma +=$cenaOne ;
           $suma +=$cenaTwo;
           $suma +=$cenaThree ;
          PrzesylkaPolecona::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";      
        }
            if($masa->usluga == 'OR'){
              $suma += 2.6 ;
            }
        }

       return $suma ;
      }
  }

