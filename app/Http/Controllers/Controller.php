<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function welcome()
    {
        return view("welcome");
    }
}
