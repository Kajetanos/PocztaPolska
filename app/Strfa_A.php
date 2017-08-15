<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Przesylka_polecona_zagraniczna;

class Strfa_A extends Model {

  

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
        
      public function __construct () {
          
          
      }
        /**
         * Sprzawdza w jakim przedziale wagowym jest paczka
         * @return int Id przedziału wagowego, patrz: $this->$progiCenowePrzedzialowWagowych
         */
        public   function sprawdzPrzedzialWagowy($masa) {
            $this->progiCenowePrzedzialowWagowych[0] = reset($this->progiCenowePrzedzialowWagowych);
            ksort($this->progiCenowePrzedzialowWagowych, SORT_NUMERIC);


            $obj = new \ArrayObject($this->progiCenowePrzedzialowWagowych);
            $it = $obj->getIterator();

            $i = 0;
            while ($it->valid()) {
                $prev = $it->key();
                $it->rewind();
                if ($it->key() === $prev) {
                    $prev = 0;
                } else {
                    $it->seek($i);
                }

                $it->next();
                if ($it->valid()) {
                    if (($masa > $prev) && ($masa <= $it->key())) {
                        return $it->current();
                    }
                }
                $i++;
            }
        }

    

    public function strefaKraju($kraj) {
        foreach ($this->strefy as $strefa) {
            foreach ($strefa['kraje'] as $k) {
                if ($k === $kraj) {
                    return $strefa['id'];
                }
            }
        }
    }

}
