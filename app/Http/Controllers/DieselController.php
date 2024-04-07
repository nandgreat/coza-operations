<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Models\DieselLevel;
use App\Models\DieselRefuelLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DieselController extends BaseController
{
    //
    public function checkLevel(Request $request)
    {
        $dieselLevel = DieselLevel::find(1);

        return $this->sendResponse($dieselLevel, 'Diesel level fetched successfully.');
    }

    public function refuel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'worker_code' => 'required|numeric',
            'confirmation_worker_code' => 'required|numeric',
            'quantity' => 'required|numeric',
            'invoice_image_url' => 'required|string',
            'waybill_image_url' => 'required|string',
            'diesel_before_image_url' => 'required|string',
            'diesel_after_image_url' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), []);
        }

        $userResult = validateWorkerCode($request->worker_code);

        if ($userResult['status'] != '00') {
            return  $this->sendJsonErrorResponse($userResult);
        }

        $confirmUserResult = validateConfirmationWorkerCode($request->confirmation_worker_code);

        if ($confirmUserResult['status'] != '00') {
            return  $this->sendJsonErrorResponse($confirmUserResult);
        }

        $worker = $userResult['data'];
        $confirmationWorker = $confirmUserResult['data'];

        $dieselLevel = DieselLevel::find(1);

        $dieselRefuel = DieselRefuelLog::create([
            'diesel_level_before' => $dieselLevel->diesel_level,
            'diesel_quantity' => $request->quantity,
            'diesel_level_after' => $dieselLevel->diesel_level + $request->quantity,
            'invoice_image_url' => $request->invoice_image_url,
            'waybill_image_url' => $request->waybill_image_url,
            'diesel_before_image_url' => $request->diesel_before_image_url,
            'diesel_after_image_url' => $request->diesel_after_image_url,
            'topup_worker_id' => $worker->id,
            'confirmation_worker_id' => $confirmationWorker->id
        ]);

        $dieselLevel->diesel_level = $dieselRefuel->diesel_level_after;
        $dieselLevel->save();

        return $this->sendResponse(['diesel_details' => $dieselLevel], 'Diesel Refueled successfully.');
    }
}
