<?php

namespace App\Http\Controllers;



require_once app_path().'/curl/get.php';
class HomeController extends Controller
{
    //
    public function getHome() {
        $vars = [
            'data' => ''
        ];
       return view('home', $vars);
    }

    public function getList($query='Udemy') {
        $query = strtolower($query);
        $url = 'https://dk1ecw0kik.execute-api.us-east-1.amazonaws.com/prod/query?query='.
            $query.'&language=en&country=us&google=http://www.google.com&service=0';
        $data = ngegrab($url, false);
        header('Content-Type: application/json; charset=utf-8');
        if(!isset($data{1})) echo '{error:1}';
        else echo $data;
        exit;


    }


}
