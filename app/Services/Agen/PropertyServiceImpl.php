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
        $property->kecamatan_id = base64_decode($request->kecamatan);
        $property->address = $request->address;
        $property->description = $request->description;
        $property->lt = $request->lt;
        $property->lb = $request->lb;
        $property->price = $request->price;
        $property->save();
    }

}
