<?php

namespace App\Http\Controllers;

use App\Food;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class TransactionController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return view('pages.transaction.index', compact('foods'));
    }

    public function print(Request $request)
    {
        $id = rand();
        $transactions = $request->all();
        $now = now()->format('d-m-Y H:i');

        //return view('pages.transaction.pdf', compact(['transactions', 'id', 'now']));
        $pdf = PDF::loadview('pages.transaction.pdf', compact(['transactions', 'id', 'now']))
                ->setPaper('A4', 'landscape');
        return $pdf->stream();
    }
}
