<?php

namespace App\Http\Controllers\Api;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegionController extends BaseController
{
    public function list()
    {
        $data = Region::orderBy('id', 'desc')->get();
        if(!count($data)){
            return $this->sendError(204,'No Data Found');
        }
        return $this->sendResponse('success', $data);
    }

    public function detail($id)
    {
        $region = Region::where('id', $id)->get();
        if (count($region)) {
            return $this->sendResponse('success', $region);
        }
        return $this->sendError(204, 'No Data Found');
    }
}
