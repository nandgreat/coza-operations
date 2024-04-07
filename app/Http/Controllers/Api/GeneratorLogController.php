<?php

namespace App\Http\Controllers\Api;

use App\Models\ApprovalAdmins;
use App\Models\DieselLevel;
use App\Models\Generator;
use App\Models\GeneratorUsage;
use App\Models\GeneratorUsageSession;
use App\Models\User;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GeneratorLogController extends BaseController
{
    //

    public function turnOnGenerator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'generators' => 'required|array|min:1',
            'worker_code' => 'required',
            'generator_purpose_id' => 'required|numeric',
            'generator_load' => 'required|string',
            'approved_by' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all()[0], []);
        }

        $userResult = validateWorkerCode($request->worker_code);

        if ($userResult['status'] != '00') {
            return $this->sendJsonErrorResponse($userResult);
        }

        $worker = $userResult['data'];

        $genResult =  Generator::whereIn('id', $request->generators)->first();

        if (!$genResult) {
            return $this->sendError('Invalid generator(s) provided', []);
        }

        $genResult =  Generator::whereIn('id', $request->generators)->where('status_id', 2)->first();

        if ($genResult) {
            return $this->sendError('Cannot turn on generator(s) as it is already turned on.', []);
        }

        $approvalAdmin =  ApprovalAdmins::find($request->approved_by);

        if (!$approvalAdmin) {
            return $this->sendError('Invalid Approval Admin provided', []);
        }

        $session = GeneratorUsageSession::where('session_status', 1)->first();

        $dieselLevel = DieselLevel::find(1);

        try {

            DB::beginTransaction();
            if (!$session) {
                $session = GeneratorUsageSession::create([
                    'diesel_level_before' => $dieselLevel->diesel_level,
                    'time_start' => Carbon::now(),
                    'turn_on_worker_id' => $worker->id,
                ]);
            }

            $startedGenerators = [];

            foreach ($request->generators as $generator) {

                $keyInserted = GeneratorUsage::create([
                    "generator_id" => $generator,
                    "time_on" => Carbon::now(),
                    "usage_session_id" => $session->id,
                    "turn_on_worker_id" => $worker->id,
                    "generator_purpose_id" => $request->generator_purpose_id,
                    "generator_load" => $request->generator_load,
                    "approved_by" => $request->approved_by,
                ]);

                $startedGenerators[] = $keyInserted;

                $gen = Generator::find($generator);
                $gen->status_id = 2;
                $gen->save();
            }

            DB::commit();

            return $this->sendResponse($startedGenerators, 'Generator(s) Turned on successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function storeImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_type' => 'required|string|in:gen_before,gen_after,invoice,waybill'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all()[0], []);
        }

        $imageName = $request->image_type . "_" . time() . '.' . $request->image->extension();

        $request->image->move(public_path($request->image_type . '_images'), $imageName);

        return $this->sendResponse(['image_url' => asset($request->image_type . "_images/" . $imageName)], "You have successfully upload image.");
    }

    public function turnOffGenerator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'generator_id' => 'required|numeric|exists:generators,id',
            'worker_code' => 'required|numeric',
            'diesel_level' => 'sometimes|numeric'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all()[0], []);
        }

        $userResult = validateWorkerCode($request->worker_code);

        if ($userResult['status'] != '00') {
            return  $this->sendJsonErrorResponse($userResult);
        }

        $worker = $userResult['data'];

        $genResult =  Generator::find($request->generator_id);

        if (!$genResult) {
            return $this->sendError('Invalid generator provided', []);
        }

        if ($genResult->status_id == 1) {
            return $this->sendError('Cannot turn OFF generator(s) as it is already turned OFF.', []);
        }

        $runningGeneratorsResult = Generator::where('status_id', 2)->get();
        try {

            // DB::beginTransaction();

            if (count($runningGeneratorsResult) == 1) {
                if ($request->diesel_level != -1) {

                    logInfo("Ending the Generator sessioon");
                    $genSessionResult = GeneratorUsageSession::where('session_status', 1)->first();

                    if (!$genSessionResult) {
                        return $this->sendError('No Generator session running at the moment', []);
                    }

                    $dieselLevel = DieselLevel::find(1);
                    $dieselLevel->diesel_level = $request->diesel_level;
                    $dieselLevel->updated_by = $worker->id;
                    $dieselLevel->save();

                    $genSessionResult->diesel_level_after = $request->diesel_level;
                    $genSessionResult->session_status = 2;
                    $genSessionResult->time_stop = Carbon::now();
                    $genSessionResult->turn_off_worker_id = $worker->id;
                    $genSessionResult->save();
                } else {
                    return $this->sendError('Enter the diesel level use to turn off generator', []);
                }
            }

            $genUsageResult = GeneratorUsage::where('generator_id', $request->generator_id)->first();

            $genUsageResult->time_off = Carbon::now();
            $genUsageResult->turn_off_worker_id = $worker->id;
            $genUsageResult->save();

            logInfo($genUsageResult, "Gen usages Log things");

            $genResult->status_id = 1;
            $genResult->save();

            // DB::commit();

            return $this->sendResponse($genResult, 'Generator Turned off successfully.');
        } catch (Exception $e) {

            // DB::rollBack();
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function allGenerators(Request $request)
    {
        $keyInserted = Generator::all();

        return $this->sendResponse($keyInserted, 'Generators fetched successfully.');
    }
}
