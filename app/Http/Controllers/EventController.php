<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $nome = "LuizMarcello";
        $idade = 61;

        $arr = [10, 20, 30, 40, 50];

        $nomes = ["LuizMarcello", "Maria", "João", "Saulo"];

        return view(
            'welcome',
            [
                'nomee' => $nome,
                'idadee' => $idade,
                'profissaoo' => "Programador",
                'arrrr' => $arr,
                'nomess' => $nomes
            ]
        );
    }

    public function create()
    {
        return view('events.create');
    }
}
