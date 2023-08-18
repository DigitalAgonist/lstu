<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RawRequest;
use App\Models\Raw;

class RawController extends Controller
{
    public function raws() {
        return view('raws', ['raws'=> Raw::orderBy('id', 'asc')->paginate(config('variable.paginate.table'))]);
    }

    public function createRaw() {
        return view('new_raw');
    }

    public function updateRaw($id, RawRequest $request) {
        $raw = Raw::find($id);
        $raw->name = $request->input('name');
        $raw->description = $request->input('description');
        $raw->save();
        return redirect()->route('raws');
    }

    public function uploadRaw(RawRequest $request) {
        $raw = new Raw();

        $raw->name = $request->input('name');
        $raw->description = $request->input('description');

        $raw->save();

        return redirect()->route('raw.create');
    }

    public function setRawToProduct() {
        return view('components', ['raws'=> Raw::all()]);
    }
}
