<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends BaseController
{
    public function index()
    {
        $data = Package::orderBy('id', 'DESC')->get();
        if(!count($data)){
            return $this->sendError(204,'No Data Found');
        }
        return $this->sendResponse('success', PackageResource::collection($data));
    }

    public function detail($id)
    {
        $data = Package::where('id', $id)->first();
        if (!$data) {
            return $this->sendError(204, 'No Package Found');
        }
        return $this->sendResponse('success', new PackageResource($data));
    }
}
