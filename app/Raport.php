<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;



class Raport extends Model
{
    
    protected $fillable = 
       [
        'unique_id',
        'rodzaj_przesylki',
        'masa[g]',
        'ilosc',
        'gabaryt',
        'usluga',
        'stawkaVat',
        'kraj',
        'ubezpieczenia',
        'date'];
    protected $table = 'raports';
    
    
    /**
     * Metoda odpowiedzialna za odczytanie xlsa i zwrócenia go w formie obiektu. Ma w sobie instrukcje warunkowe ktore dostosowuja 
     * omijanie wierszy do pliku jaki ma odczytać
     * @param type $nameXls
     * @return type
     */
    public static function readXls($path) {
        
        $object_to_save = Excel::selectSheetsByIndex(0)->load($path, function($reader) {
                    $reader->noHeading()->skipRows(2);    
                })->get();   //->store('csv', storage_path('excel/exports'));  //->convert('csv')->get();
              return $object_to_save;
    }
                         
    /**
     * Metoda odpowiedzialna za zapisanie do tabeli raports calego pliku Raport -> wszystkich danych z poczty na temat paczek.
     * @param type $object_to_save
     */
    public static function saveXls(){
     $path = storage_path('XLS/Raport_test.ods') ;
       $object_to_save= Raport::readXls($path);
        foreach($object_to_save as $rap){
//            echo $rap;
//            
//            dd($rap);
             if($rap[25]!=null){
        $date = substr($rap[19], 0,7);
        $pattern = '/^([0-9]{4})\-([0-9]{2})$/' ; 
         preg_match($pattern, $date, $matches);
        $date = $matches[0];  
        
        round($rap[21]);
            echo $date. "<br>";
   Raport::insert([ 'unique_id'         =>$rap[25] ,
                    'rodzaj_przesylki'  =>$rap[1],
                    'masa'              =>$rap[21],
                    'ilosc'             =>$rap[28],
                    'gabaryt'           =>$rap[29],
                    'usluga'            =>$rap[55],
                    'stawkaVat'         =>$rap[61],
                    'kraj'              =>$rap[9],
                    'ubezpieczenia'     =>$rap[54],
                    'date'              =>$date,                    ]);
            }
        }
        
    }
}
                 
    
