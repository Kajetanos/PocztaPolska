<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\PrzesylkiZagraniczne;

class Przesylka_polecona_zagraniczna extends Model
{
    protected $table = 'przesylka_polecona_zagranicznas';
    //podatek vat zwrot
    
     protected $fillable = 
       [
        'unique_id',
        'masa',
        'strefa',
        'usluga',
        'kraj',
        'cena'];
    public $timestamps = true;
    /**
     * Funkcja zapisuje wszystkie przesylki zagraniczne
     */
    public static function get_and_save_przesylki_zagraniczne () {
        
       $przesylka_pocztowa_pozstale_kraje = PrzesylkiZagraniczne::get_przesylka_pocztowa_pozstale_kraje();
        foreach ($przesylka_pocztowa_pozstale_kraje as $rest_country){
            Przesylka_polecona_zagraniczna::insert([
            'unique_id'=>$rest_country->unique_id,
            'masa' => $rest_country->masa,    
            'kraj' => $rest_country->kraj,    
            'usluga' => $rest_country->usluga,    
                ]);
        }
       $przesylka_pocztowa_zagraniczna= PrzesylkiZagraniczne::get_przesylka_pocztowa_zagraniczna();
       foreach ($przesylka_pocztowa_zagraniczna as $row) {
           Przesylka_polecona_zagraniczna::insert([
            'unique_id'=>$row->unique_id,
            'masa' => $row->masa,    
            'kraj' => $row->kraj,    
            'usluga' => $row->usluga,    
                ]);
       }
    }
    public static function split_into_zone(){
        $strefa20 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI','=',  '20')->get();
        echo $strefa20;
        
    } 
    
    
      public static function split_into_zones_international_without_service(){
        
        $strefa_20 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI','=',  '20')->get();
       $strefa_30 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI', '30')->get();  //wyciągnięta wartośc 
       $strefa_40 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI' , '40')->get();  //wyciągnięta wartośc 
       $strefa_10 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI' , '10')->get();
       $strefa_11 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI' , '11')->get();
       $strefa_12 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI' , '12')->get();
       $strefa_13 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaI' , '13')->get();
       $date = date('Y-m-d H:i:s');
       foreach ( $strefa_20 as $row) {
        Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$row->nazwa_kraju")->whereNull('usluga' )->update(array('strefa' => '20'));
        echo $row->nazwa_kraju;
      }
       foreach ( $strefa_30 as $rowB) {

        Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowB->nazwa_kraju")->whereNull('usluga' )->update(array('strefa' => '30'));
       }
       
       foreach ( $strefa_40 as $rowC) {

     Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowC->nazwa_kraju")->whereNull('usluga' )->update(array('strefa' => '40'));
       }
       
       
       foreach ( $strefa_10 as $rowD) {
         
     Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowD->nazwa_kraju")->whereNull('usluga' )->update(array('strefa' => '10'));
       }
       foreach ( $strefa_11 as $rowE) {
         
       Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowE->nazwa_kraju")->whereNull('usluga' )->update(array('strefa' => '11'));
       }
       foreach ( $strefa_12 as $rowF) {
         
       Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowF->nazwa_kraju")->whereNull('usluga' )->update(array('strefa' => '12'));
       }
       foreach ( $strefa_13 as $rowG) {
         
       Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowG->nazwa_kraju")->whereNull('usluga' )->update(array('strefa' => '13'));
       }
       }
      public static function split_into_zones_international_with_service(){
        
 
       $strefa_A1 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'A1')->get();
       $strefa_A2 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'A2')->get();  //wyciągnięta wartośc 
       $strefa_A3 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'A3')->get();  //wyciągnięta wartośc 
       $strefa_A4 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'A4')->get();
       $strefa_A5 = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'A5')->get();
       $strefa_B  = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'B')->get();
       $strefa_C  = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'C')->get();
       $strefa_D  = DB::table('strefy_przesylek_pocztowych_zagranicznych')->where('strefaII' , 'D')->get();
       $date = date('Y-m-d H:i:s');
       foreach ( $strefa_A1 as $row) {
        Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$row->nazwa_kraju")->where('usluga' , '=' , 'R')->update(array('strefa' => 'A1'));
        echo $row->nazwa_kraju."<br>";
       }
       foreach ( $strefa_A2 as $rowB) {
        Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowB->nazwa_kraju")->where('usluga' , '=' , 'R')->update(array('strefa' => 'A2'));
        echo $rowB->nazwa_kraju ."<br>";
       }
       
       foreach ( $strefa_A3 as $rowC) {

        Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowC->nazwa_kraju")->where('usluga' , '=' , 'R')->update(array('strefa' => 'A3'));
       }
       foreach ( $strefa_A4 as $rowD) {
         
        Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowD->nazwa_kraju")->where('usluga' , '=' , 'R')->update(array('strefa' => 'A4'));
       }
       foreach ( $strefa_A5 as $rowE) {
         
       Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowE->nazwa_kraju")->where('usluga' , '=' , 'R')->update(array('strefa' => 'A5'));
       }
       foreach ( $strefa_B as $rowF) {
           
       Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowF->nazwa_kraju")->where('usluga' , '=' , 'R')->update(array('strefa' => 'B'));
       }
       foreach ( $strefa_C as $rowG) {
         
       Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowG->nazwa_kraju")->where('usluga' , '=' , 'R')->update(array('strefa' => 'C'));
       foreach ( $strefa_D as $rowH) {
         
       Przesylka_polecona_zagraniczna::where('kraj' , '=' , "$rowH->nazwa_kraju")->where('usluga' , '=' , 'R')->update(array('strefa' => 'D'));
       }
       }
          
      }
      
      
      public static function set_price_with_weight_zone_A1(){
          
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , 'A1')->select('masa' , 'id')->get();
        $ilosc =  count($waga);
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo =   ($masa->masa<=1)                    ?(int)60   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa<=1)  ?(int)72   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa<=2)  ?(int)80   : 0 ;
           $cenaFive =  ($masa->masa<=4&&$masa->masa<=3)   ?(int)92   : 0 ;
           $cenaSix =   ($masa->masa<=5&&$masa->masa<=4)    ?(int)102    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)105 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)110   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)    ?(int)117   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)    ?(int)125   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)    ?(int)133   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)139   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)145   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)155   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)162   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)171   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)179 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)187   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)196  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)202   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)211   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo "($ilosc)". $suma . " = To jest suma Strefy A1 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_A2(){
          
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , 'A2')->select('masa' , 'id')->get();
        $ilosc =  count($waga);
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)70   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)82   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)98   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)102   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)114    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        
                 
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)117 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)124   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)131   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)139   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)145   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)151   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)160   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)166   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)172   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)179   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)187 : 0 ;
           $cenaTwo = ($masa->masa  <=17&& $masa->masa>16) ?(int)196   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)204  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)211   : 0 ;
           $cenaFive = ($masa->masa <=20&& $masa->masa>19) ?(int)221   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            
            }
       }
       echo "($ilosc)". $suma . " = To jest suma Strefy  A2 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_A3(){
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , 'A3')->select('masa' , 'id')->get();
          $ilosc =  count($waga);
        
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<1)                    ?(int)70   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)82   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)98   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)102   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)114    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)117 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)124   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)131   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)139   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)145   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)158   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)167   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)176   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)185   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)194   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)212 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)221   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)230  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)239   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)249   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo"($ilosc)". $suma . " = To jest suma Strefy  A3 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_A4(){
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , 'A4')->select('masa', 'id')->get();
          $ilosc =  count($waga);
        
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)34   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)37   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)39   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)41   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)45    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)48 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)51   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)53   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)56   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)59   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)62   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)64   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)67   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)70   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)72   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)75 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)78   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)81  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)83   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)86   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo "($ilosc)". $suma . " = To jest suma Strefy A4 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_A5(){
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , 'A5')->select('masa', 'id')->get();
          $ilosc =  count($waga);
        
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<1)                    ?(int)66   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)78   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)94   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)98   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)110  : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)113 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)120   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)127   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)135   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)141   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)147   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)156   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)162   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)168   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)175   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)183 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)192   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)200  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)207   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)217   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo"($ilosc)". $suma . " = To jest suma Strefy A5 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_B(){
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , 'B')->select('masa')->get();
          $ilosc =  count($waga);
        
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)81   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)102   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)126   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)146   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)172    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)184 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)203   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)222   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)240   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)258   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)276   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)297   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)318   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)339   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)360   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)390 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)411   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)433  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)454   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)475   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo"($ilosc)". $suma . " = To jest suma Strefy  B <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_C(){
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , 'C')->select('masa' , 'id')->get();
          $ilosc =  count($waga);
        
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)89   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)116   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)140   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)170   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)205    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)225 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)254   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)283   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)311   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)336   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)363   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)386   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)416   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)448   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)466   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
           $cenaOne   = ($masa->masa<=16&& $masa->masa>15)  ?(int)500  : 0 ;
           $cenaTwo   = ($masa->masa<=17&& $masa->masa>16)  ?(int)514  : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)538  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)561  : 0 ;
           $cenaFive  = ($masa->masa<=20&& $masa->masa>19)  ?(int)586  : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
           
            }
       }
       echo"($ilosc)". $suma . " = To jest suma Strefy C <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_D(){
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , 'D')->select('masa')->get();
          $ilosc =  count($waga);
        
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)103   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)145   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)188   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)231   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)272    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)312 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)354   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)398   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)439   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)481   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)524   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)566   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)608   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)650   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)692   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)723 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)755   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)772  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)807   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)840   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo"($ilosc)". $suma . " = To jest suma Strefy D <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_10(){
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , '10')->select('masa')->get();
          $ilosc =  count($waga);
        
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)56   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)62   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)67   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)75   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)84    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)86 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)88   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)90   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)92   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)95   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)100   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)105   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)110   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)116   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)124   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)127 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)131   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)136  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)141   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)146   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo "($ilosc)".$suma . " = To jest suma Strefy 10 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_11(){
          
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , '11')->select('masa')->get();
        $ilosc =  count($waga);
          $ilosc =  count($waga);
        $suma = 0 ;
       foreach ($waga as $masa){
//          echo count($masa);
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)56   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)62   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)67   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)75   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)84    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)96 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)98   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)105   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)112   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)120   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)127   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)135   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)143   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)151   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)159   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }if($masa->masa>15 && $masa->masa <20) {
           $cenaOne  =($masa->masa<=16)                   ?(int)167   : 0 ;
           $cenaTwo  =($masa->masa<=17&& $masa->masa>16)  ?(int)175   : 0 ;
           $cenaThree=($masa->masa<=18&& $masa->masa>17)  ?(int)183   : 0 ;
           $cenaaFour=($masa->masa<=19&& $masa->masa>18)  ?(int)191   : 0 ;
           $cenaFive =($masa->masa<=20&& $masa->masa>19)  ?(int)199   : 0 ;
            echo "$masa->masa  <br>";
            echo $cenaOne;
            $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo"($ilosc)". $suma . " = To jest suma Strefy 11 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_12(){
          
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , '12')->select('masa')->get();
        $ilosc =  count($waga);
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)32   : 0 ;
           $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)35   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)37   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)40   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)41    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)43 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)45   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)48   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)50   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)52   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne =   ($masa->masa<=11&& $masa->masa>10)  ?(int)55   : 0 ;
           $cenaTwo =   ($masa->masa<=12&& $masa->masa>11)  ?(int)56   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)  ?(int)58   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)  ?(int)60   : 0 ;
           $cenaFive = ($masa->masa <=15&& $masa->masa>14)  ?(int)63   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)65 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)67   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)69  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)72   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)74   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo"($ilosc)". $suma . " = To jest suma Strefy 12 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_13(){
          
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , '13')->select('masa')->get();
        $ilosc =  count($waga);
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
             $cenaTwo = ($masa->masa<=1)                 ?(int)52   : 0 ;
            $cenaThree = ($masa->masa<=2&&$masa->masa>1) ?(int)58   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)63   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)71   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)80   : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)82 : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)84   : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)86   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)88   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)91   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)96   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)101   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)106   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)112   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)120   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)123 : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)127   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)132  : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)137   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)142   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo "($ilosc)".$suma . " = To jest suma Strefy 13 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_20(){
          
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , '20')->select('masa')->get();
        $ilosc =  count($waga);
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<1)                    ?(int)57   : 0 ;
            $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)63   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)68   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)76   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)85    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)89  : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)92  : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)100   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)108   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)114   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)122   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)129   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)138   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)150   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)162   : 0 ;
         
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
        $cenaOne =   ($masa->masa  <=  16&& $masa->masa>11)   ?(int)165   : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16)   ?(int)170   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)    ?(int)177   : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)    ?(int)182   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19)  ?(int)187   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
            }
       }
       echo "($ilosc)".$suma . " = To jest suma Strefy 20 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_30(){
          
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , '30')->select('masa' , 'id')->get();
        $ilosc =  count($waga);
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<=1)                    ?(int)59   : 0 ;
            $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)65   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)70  : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)77   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)86    : 0 ;
            
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
//           echo "id=" . $masa->id ."masa = $masa->masa". " suma=$suma" . "<br>";
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)90  : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)98  : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)106   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)114   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)122   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
//            echo "id=" . $masa->id ."masa = $masa->masa". " suma=$suma" . "<br>";
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)130   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)139   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)149   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)159   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)169   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
//                  echo "id=" . $masa->id ."masa = $masa->masa". " suma=$suma" . "<br>";
        }else{
        $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)173   : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)178   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)185   : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)194   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)200   : 0 ;
            
           
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
            }
       }
       echo "($ilosc)".$suma . " = To jest suma Strefy 30 <br>";
       return $suma ;
      }
      public static function set_price_with_weight_zone_40(){
          
          
          $waga  = Przesylka_polecona_zagraniczna::where('strefa' ,'=' , '40')->select('masa' , 'id')->get();
        $ilosc =  count($waga);
        $suma = 0 ;
       foreach ($waga as $masa){
               
        if($masa->masa <= 5 ){
            
           $cenaTwo = ($masa->masa<1)                    ?(int)61   : 0 ;
            $cenaThree = ($masa->masa<=2&&$masa->masa>1)  ?(int)67   : 0 ;
           $cenaaFour = ($masa->masa<=3&&$masa->masa>2)  ?(int)73   : 0 ;
           $cenaFive = ($masa->masa<=4&&$masa->masa>3)   ?(int)79   : 0 ;
           $cenaSix = ($masa->masa<=5&&$masa->masa>4)    ?(int)87    : 0 ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           $suma +=$cenaSix ;
            
        }
        
        if($masa->masa > 5 && $masa->masa <10){
          $cenaOne =    ($masa->masa<=6&& $masa->masa>5)    ?(int)95  : 0 ;
           $cenaTwo =   ($masa->masa<=7&& $masa->masa>6)    ?(int)101  : 0 ;
           $cenaThree = ($masa->masa<=8&& $masa->masa>7)  ?(int)109   : 0 ;
           $cenaaFour = ($masa->masa<=9&& $masa->masa>8)  ?(int)116   : 0 ;
           $cenaFive = ($masa->masa<=10&& $masa->masa>9)  ?(int)124   : 0 ;

           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
        }
        elseif ($masa->masa > 10 && $masa->masa <15) {
           $cenaOne = ($masa->masa  <=  11&& $masa->masa>10)  ?(int)133   : 0 ;
           $cenaTwo = ($masa->masa  <= 12&& $masa->masa>11)   ?(int)142   : 0 ;
           $cenaThree = ($masa->masa<=13&& $masa->masa>12)    ?(int)153   : 0 ;
           $cenaaFour = ($masa->masa<=14&& $masa->masa>13)    ?(int)163   : 0 ;
           $cenaFive = ($masa->masa <= 15&& $masa->masa>14)   ?(int)173   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
           
        }else{
           $cenaOne = ($masa->masa  <=  16&& $masa->masa>15)   ?(int)178   : 0 ;
           $cenaTwo = ($masa->masa  <= 17&& $masa->masa>16) ?(int)186   : 0 ;
           $cenaThree = ($masa->masa<=18&& $masa->masa>17)  ?(int)197   : 0 ;
           $cenaaFour = ($masa->masa<=19&& $masa->masa>18)  ?(int)206   : 0 ;
           $cenaFive = ($masa->masa <= 20&& $masa->masa>19) ?(int)217   : 0 ;
            
           $suma +=$cenaOne ;
           $suma +=$cenaTwo ;
           $suma +=$cenaThree ;
           $suma +=$cenaaFour ;
           $suma +=$cenaFive ;
            
        echo "id=" . $masa->id ."masa = $masa->masa". " suma=$suma" . "<br>";
            }
       }
       echo "($ilosc)".$suma . " = To jest suma Strefy 40 <br>";
       return $suma ;
      }
      
       public static function add_all_prices_zagraniczne(){
        
        $count_all_prices = 0 ;
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_10();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_11();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_12();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_13();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_20();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_30();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_40();
     
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_A1();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_A2();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_A3();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_A4();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_A5();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_B();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_C();
       $count_all_prices += Przesylka_polecona_zagraniczna::set_price_with_weight_zone_D();
    
       echo "<br>". $count_all_prices ;
        // PLUS PODATEK VAT 23% czyli - >      $count_all_prices += $count_all_prices * 0.23 
       return $count_all_prices ;
    }
       
}
