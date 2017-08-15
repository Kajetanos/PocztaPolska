<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Raport;

class PrzesylkiZagraniczne extends Model
{
    
    private $strefy = [
        'A' => [
            'id' => 563,
            'kraje' => [
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
                'Włochy']
        ],
        'B' => [
            'id' => 564,
            'kraje' => [
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
            ]
        ],
        'C' => [
            'id' => 565,
            'kraje' => [
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
            ]
        ],
        'D' => [
            'id' => 566,
            'kraje' => [
                'Australia',
                'Nowa Zelandia',
                'Salomona Wyspy',
                'Vanuatu'
            ]
        ],
        'E' => [
            'id' => 567,
            'kraje' => [
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
        ]
    ];
   
 
    /**
     * Funkcja jedt odpowiedzialna za pobranie Stref (na które są podzielone państwa) i zapisanie do tabeli wykaz_stref_ems
     */
    public static function getStrefEms(){
        
        $path = storage_path('/XLS/wykaz_stref_EMS_old.xlsx');
       $strefy_next = Raport::read_xls("$path");  
        foreach ($strefy_next as $row_next) {
         
            if(!empty($row_next[1])){
            DB::table('wykaz_stref_ems')->insert([
                'nazwa_kraju' =>$row_next[1],
                'strefa'      =>$row_next[2]
             ]);
            
        }
        }
    }
    /**
     * Funkcja jedt odpowiedzialna za pobranie Stref (na które są podzielone państwa) i zapisanie do tabeli wykaz_stref_ems
     */
    public static function getStrefPaczkaPocztowa(){
        
         $path = storage_path('/XLS/wykaz_stref_paczka_pocztowa.xlsx');
       $strefy = Raport::read_xls("$path"); 

       foreach ($strefy as $row) {
            
            if(!empty($row[1])){
            DB::table('strefy_przesylek_pocztowych_zagranicznych')->insert([
                'nazwa_kraju' =>$row[1],
                'strefaI'      =>$row[3],
                'strefaII'      =>$row[4]
            ]);
            
            }
        }
    }
    
    public static function getGlobalExpres(){
        $zagraniczna_global_expres       = Raport::where('rodzaj_przesylki' , '=' , 'Global Expres')->get();
        return $zagraniczna_global_expres;
    }

    /**
     * Funkcja jest odpowiedzialna za pobranie z Raport
     * @return type
     */
    public static function getEms(){
        
        $zagraniczna_ems  = Raport::where('rodzaj_przesylki' , '=' , 'EMS pozostałe kraje')->get();
        return $zagraniczna_ems;
    }
    
    /**
     * Funkcja jest odpowiedzialna za pobranie z Raport wszystkich przesyłek poleconych zagranicznych 
     * @return type
     */
    public static function getPrzesylkaPocztowaZagraniczna(){
        
        $zagraniczna_przesylka_pocztowa  = Raport::where('rodzaj_przesylki' , '=' , 'Zagraniczna przesyłka polecona')->get();
        return $zagraniczna_przesylka_pocztowa;
    }
    /**
     * Funkcja jest odpowiedzialna za pobranie z Raport wszystkich przesyłek poleconych zagranicznych 
     * @return type
     */
    public static function getPrzesylkaPocztowaPozstaleKraje(){
        
                $zagraniczna_przesylka_pocztowa  = Raport::where('rodzaj_przesylki' , '=' , 'Zagraniczna paczka pozostałe kraje')->get();
        return $zagraniczna_przesylka_pocztowa;
    }
    
    
    
    
    
    
    
    
}
