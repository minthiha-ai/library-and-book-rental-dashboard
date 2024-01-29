<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\BannerResource;

class BannerController extends BaseController
{
    public function index()
    {
        $data = Banner::orderBy('id', 'DESC')->get();
        if(!count($data)){
            return $this->sendError(204,'No Data Found');
        }
        return $this->sendResponse('success', BannerResource::collection($data));
    }
}
