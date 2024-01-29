<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;

class CategoryController extends BaseController
{
    public function index()
    {
        $data = Category::orderBy('id', 'DESC')->get();
        if(!count($data)){
            return $this->sendError(204,'No Data Found');
        }
        return $this->sendResponse('success',$data);

    }
}
