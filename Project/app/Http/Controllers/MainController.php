<?php

namespace App\Http\Controllers;


use App\City;
use Laravel\Lumen\Http\Request;

class MainController extends Controller
{

    public function all(){
        return json_encode(City::all());
    }

    public function getCity($id){
        return json_encode(City::find($id));
    }

    public function getCityByRecord($id){
        return json_encode(City::where(['recordid' => $id])->first);
    }

    public function deleteCity(Request $request, $id){
        if(City::find($id)){
            City::find($id)->delete();
            return "Deleted";
        }
        return 'Record not exists!';
    }
}
