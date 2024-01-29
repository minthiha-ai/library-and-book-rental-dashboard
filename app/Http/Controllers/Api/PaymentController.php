<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;

class PaymentController extends BaseController
{
    public function index()
    {
        $data = Payment::orderBy('id', 'DESC')->get();
        if (!count($data)) {
            return $this->sendError(204, 'No Data Found');
        }
        return $this->sendResponse('success', PaymentResource::collection($data));
    }
}
