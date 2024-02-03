<?php

namespace App\Services\Agen;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PropertyServiceImpl implements PropertyService
{
    public function save(Request $request, string $agentId)
    {
        $property = new Property();
        $property->id = Str::uuid()->toString();
        $property->name = $request->name;
        $property->kecamatan_id = $request->kecamatan;
        $property->agent_id = $agentId;
        $property->address = $request->address;
        $property->description = $request->description;
        $property->lt = $request->lt;
        $property->lb = $request->lb;
        $property->kategori_id = $request->kategori;
        $property->beds = $request->kamar_tidur;
        $property->baths = $request->kamar_mandi;
        $property->price = $request->price;
        $property->isStatus = 0;
        $property->save();
    }

}
