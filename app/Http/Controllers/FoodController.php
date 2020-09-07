<?php

namespace App\Http\Controllers;

use App\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return view('pages.food.index', compact('foods'));
    }

    public function create()
    {
        return view('pages.food.create');
    }

    private function uploadImgToAws($img)
    {
        $filename = date('Y-m-d h:i:s') . '.' . $img->getClientOriginalExtension();
        $filepath = 'test/' . $filename;
        Storage::disk('s3')->put($filepath, file_get_contents($img));

        return Storage::disk('s3')->url($filepath, $filename);
    }

    public function store(Request $request)
    {

        $this->validate($request, $this->rules(), $this->messages(), $this->translates());

        $price = preg_replace('/[^\w\s]/', '', $request->price);
        Food::create([
            'name' => $request->name,
            'image' => $this->uploadImgToAws($request->file('image')),
            'price' => $price
        ]);

        return redirect()->route('food.index');
    }

    private function rules()
    {
        return [
            'name' => 'required|min:3',
            'image' => 'file|image|mimes:jpeg,jpg,png|max:2048|required',
            'price' => 'required|numeric'
        ];
    }

    private function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'max' => ':attribute maksimal :max karakter',
            'min' => ':attribute minimal :min karakter',
            'image' => ':attribute harus bertipe gambar',
            'mimes' => ':attribute harus berekstensi :values',
            'numeric' => ':attribute harus angka'
        ];
    }

    private function translates()
    {
        return [
            'name' => 'Nama Makanan',
            'image' => 'Foto Makanan',
            'price' => 'Harga Makanan'
        ];
    }
    
}
