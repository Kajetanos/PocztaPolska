<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PrzesylkiZagraniczne;

class Post_International_Controller extends Controller
{
    
public function international_actions() {

    PrzesylkiZagraniczne::save_all_international();
    

}
}
