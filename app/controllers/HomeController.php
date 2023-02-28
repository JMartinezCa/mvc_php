<?php 

namespace app\controllers;

use src\View\View;

class HomeController{
    public function __construct(){
       
    }

    function index(){
        View::render('pages/index');
    }
}