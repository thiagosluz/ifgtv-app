<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use League\ColorExtractor\Palette;

class IndexController extends Controller
{
    public function index()
    {
        $publications = Publication::publicado()->exibir()->get();
        return view('index4', compact('publications'));
    }

    public function carousel()
    {
        $publications = Publication::publicado()->exibir()->get();
        return view('carousel', compact('publications'));
    }

}
