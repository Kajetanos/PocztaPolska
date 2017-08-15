<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GlobalExpress extends Model
{
    
    protected $table = 'global_expresses' ;
    
    protected $fillable = ['kraj', 'unique_id' , 'masa' , 'cena' , 'strefa'];
    
    public static function saveToGlobalExpreses () {
        
        
        $express_to_db = PrzesylkiZagraniczne::getGlobalExpres();
        
        foreach ($express_to_db as $row){
           
          GlobalExpress::insert([
               'kraj'           => $row->kraj ,
               'unique_id'      => $row->unique_id, 
               'masa'           => round($row->masa),
               'date'            => $row->date,
            ]);
        }
    }
    /**
     * Nie wczytuje kilku rzeczy Wielkiej Brytani mniédzy innymi
     */
    public static function getEuropeZone () {
        
        $europe_zone = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII', 'A1')
                ->orWhere('strefaII' , 'A2')
                ->orWhere('strefaII' , 'A3')
                ->orWhere('strefaII' , 'A4')
                ->orWhere('strefaII' , 'A5')->get();

        foreach ( $europe_zone as $rowC) {
            if($rowC->strefaII == "A2"){
         $kraje_strefoweC = GlobalExpress::where('kraj' , '=' , "$rowC->nazwa_kraju")->update(array('strefa' => 'europa'));
            }elseif($rowC->strefaII == "A1"){
             $kraje_strefoweC = GlobalExpress::where('kraj' , '=' , "$rowC->nazwa_kraju")->update(array('strefa' => 'europa'));
            }elseif($rowC->strefaII == "A3"){
                    $kraje_strefoweC = GlobalExpress::where('kraj' , '=' , "$rowC->nazwa_kraju")->update(array('strefa' => 'europa'));
                    }elseif($rowC->strefaII == "A4"){
                        $kraje_strefoweC = GlobalExpress::where('kraj' , '=' , "$rowC->nazwa_kraju")->update(array('strefa' => 'europa'));
                        }
       }
           
    }
    public static function getOtherZone() {
        
       $other_zone_country  = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'B')->orWhere('strefaII' , 'C')->orWhere('strefaII' , 'D')->get();
       foreach ($other_zone_country as $row ){

           if($row->strefaII == "B"){
           $kraje_strefoweC = GlobalExpress::where('kraj' , '=' , "$row->nazwa_kraju")->update(array('strefa' => 'other_country'));
              }elseif($row->strefaII == "C"){
              $kraje_strefoweC = GlobalExpress::where('kraj' , '=' , "$row->nazwa_kraju")->update(array('strefa' => 'other_country'));}
                elseif ($row->strefaII == "D") {
                $kraje_strefoweC = GlobalExpress::where('kraj' , '=' , "$row->nazwa_kraju")->update(array('strefa' => 'other_country'));
               
                }else {
           
           }
               
       }
    }
    public static function getPricesFromJson(){
        $path = storage_path('/cenniki_poczta/global_output.json');
        $array_json = json_decode(file_get_contents($path), true);
        return $array_json;
    }
    
    public static function setGlobalPriceFromEurope(){
        $suma = 0 ;
        $waga  = GlobalExpress::where('strefa' , '=' , 'europa')->select('masa' , 'id')->get();

               
        $array_json = GlobalExpress::getPricesFromJson();
        $x = ',630';
       foreach ($waga as $masa){
        if($masa->masa <= 5 ){
           
           $cenaOne   = ($masa->masa<=0.5)                  ?$masa->cena = $array_json['626'.$x] : 0 ;
           $cenaTwo   = ($masa->masa<=1&&$masa->masa>0.5)   ?$masa->cena = $array_json['627'.$x]  : 0 ;
           $cenaThree = ($masa->masa<=1.5&&$masa->masa>1)   ?$masa->cena = $array_json['628'.$x]  : 0 ;
           $cenaaFour = ($masa->masa<=2&&$masa->masa>1.5)   ?$masa->cena = $array_json['629'.$x]  : 0 ;

            
         $suma +=$cenaOne ;
          $suma +=$cenaTwo;
         $suma +=$cenaThree ;
         $suma +=$cenaaFour ;
                GlobalExpress::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";        
         
        }
      }
       return $suma ;
    }
    public static function setGlobalPriceFromOtherCountry(){
        $suma = 0 ;
        $waga  = GlobalExpress::where('strefa' , '=' , 'other_country')->select('masa' , 'kraj' , 'id' )->get();

               
        $array_json = GlobalExpress::getPricesFromJson();
        $x = ',235';
       foreach ($waga as $masa){
        if($masa->masa <= 5 ){
           
           $cenaOne   = ($masa->masa<=0.5)                  ?$masa->cena = $array_json['626'.$x] : 0 ;
           $cenaTwo   = ($masa->masa<=1&&$masa->masa>0.5)   ?$masa->cena = $array_json['627'.$x]  : 0 ;
           $cenaThree = ($masa->masa<=1.5&&$masa->masa>1)   ?$masa->cena = $array_json['628'.$x]  : 0 ;
           $cenaaFour = ($masa->masa<=2&&$masa->masa>1.5)   ?$masa->cena = $array_json['629'.$x]  : 0 ;

            
          $suma +=$cenaOne ;
          $suma +=$cenaTwo;
          $suma +=$cenaThree ;
          $suma +=$cenaaFour ; 
          
          GlobalExpress::where("id", "=", "$masa->id")->update(["cena" => $masa->cena]) . "<br>";      
        }
      }
       return $suma ;
    }
    
    
    
    
    
}
