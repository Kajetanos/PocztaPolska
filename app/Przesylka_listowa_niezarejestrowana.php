<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use App\Raport;

class Przesylka_listowa_niezarejestrowana extends Model
{
    
  public function take_raport(){ 
    
      
      $all_raport = Raport::all();
      
  }
  public function validator(){
      
  }
   
    
}
