<?php

namespace App\Services\Agen;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyServiceImpl implements PropertyService
{
    public function save(Request $request)
    {
        $property = new Property();
        $property->name = $request->name;
        $property->kecamatan_id = 1;
        $property->address = $request->address;
        $property->description = $request->description;
        $property->lt = $request->lt;
        $property->lb = $request->lb;
        $property->kategori_id = 1;
        $property->beds = $request->kamar_tidur;
        $property->baths = $request->kamar_mandi;
        $property->price = $request->price;
        $property->save();
    }

}
