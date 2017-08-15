<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Raport;

class przesylka_polecona extends Model
{
    
     protected $table = 'przesylka_polecona';
     public $masaLow;
     
     /**
      * Metoda pobiera z tabeli Raport->rodzaj przeyłki i zapisuje do tabeli przesylka polecona.
      * @return type
      */
    public static function add_polecona (){
        
        $polecone = Raport::where('rodzaj_przesylki', '=', 'Przesyłka polecona')
               ->orderBy('rodzaj_przesylki', 'asc')
               ->get();
        foreach ($polecone as $row){
            
        przesylka_polecona::insert(
                ['gabaryt' => $row->gabaryt,
                'masa' => $row->masa,
                'ilosc'=> $row->ilosc,
                'usluga'=>$row->usluga,
                'stawka_vat'=> $row->stawkaVat,
                ]);
        }
        return $polecone;
    }
    
    /**
     * Metoda pobiera i dzieli rekordy na poszczególne masy. 
     * @return type
     */
    public static function get_and_share (){
        
        $masaLow    = przesylka_polecona::where('masa' , '<' , '0.35')->get();
        $masaMedium = przesylka_polecona::where('masa', '<' , '1')->get();
        $masaHigh   = przesylka_polecona::where('masa','>' , '1')->get();
        
        return $masaLow;
    }
    
    /**
     * Metoda jest odpowiedzialna za wyliczenie przesylki poleconej ktora ma najmniejszą masę. Wpierw pobiera wszystkie rekordy którą mają mase "low" 
     * następnie dzieli je na gabaryty A i B poprzez instrukcje warunkową i nalicza ceny którę są do nich przypisane. Sprawdza jeszcze czy przesyłka 
     * jest za potwierdzeniem odbioru i również nalicza 2.6 jeżeli jest. Zwraca sume wszystkich policzonych wyników. 
     */
    public static function price_masa_low (){
        
        $masa_low = przesylka_polecona::get_and_share();
        $gabaryt_a  = ['cena' ,'gabaryt','masa', 'ilosc','usluga' , 'stawka_vat' ] ;
        $gabaryt_b  = ['cena' ,'gabaryt','masa', 'ilosc','usluga' , 'stawka_vat' ] ;
//        echo $gabaryt_a;
        $cena_a = [] ;
        $cena_b = [] ;
        $add_a = 0 ;
        $add_b = 0 ;
        $add_or= 0 ;
        foreach ($masa_low as $key=>$row){
            if($row->gabaryt == "A"){
                $gabaryt_a = $row;
                $gabaryt_a['cena'] += 5.2;
                 $cena_a[] = $gabaryt_a['cena'];
                $add_a = array_sum($cena_a);
                 if ($gabaryt_a['usluga'] == 'OR') {
                   $gabaryt_a['cena'] += 2.6 ;
                         $add_or = $gabaryt_a['cena'];
                 }else {
                    
                }
            }
            else {
                $gabaryt_b = $row; 
                $gabaryt_b['cena'] = 9.8 ;
              $cena_b[] = $gabaryt_b['cena'] . "<br>" ;
                $add_b = array_sum($cena_b);

            }

        }
          echo "Suma wszystkich przesylek poleconych to =".   $suma = $add_a + $add_b + $add_or . "<br>";
          return $suma; 

    }
}
