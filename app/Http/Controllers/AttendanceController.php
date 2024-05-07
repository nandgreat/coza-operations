<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Models\Member;
use App\Models\MemberAttendance;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends BaseController
{
    public function signinAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|numeric',
            'member_code' => 'required|string',
            'worker_code' => 'sometimes|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all()[0], $validator->errors());
        }

        $worker = User::where('worker_code', $request->worker_code)->first();

        if (!$worker) {
            return $this->sendError("Invalid Worker Code");
        }

        if ($worker->id != auth()->user()->id) {
            return $this->sendError("Worker Code does not match user");
        }

        $member = Member::where('member_code', $request->member_code)->first();

        if (!$member) {
            return $this->sendError("Invalid Member. Please try again with a valid member");
        }

        $service = Service::find($request->service_id);

        if (!$service) {
            return $this->sendError("Invalid Service. Please try again with a valid Service");
        }

        if ($service->service_status_id != 2) {
            return $this->sendError("Attendance cannot be taken as service is not onggoing");
        }

        if ($member->is_onboarding_completed == 1) {
            return $this->sendError("Member has completed their onboarding process");
        }

        $totalServices = Service::where('created_at', '>=', $member->created_at)->count();

        try {

            DB::beginTransaction();

            $attendance = MemberAttendance::create([
                'member_id' => $member->id,
                'service_id' => $request->service_id,
                'time_in' => Carbon::now(),
                'created_by' => $worker->id
            ]);

            if ($totalServices + 1 == $member->expected_attendance) {
                $member->is_onboarding_completed = 1;
            }

            $member->total_services = $totalServices + 1;

            $newAttendance = $member->total_attendance + 1;
            $member->total_attendance = $newAttendance;
            $member->percentage_attendance = ($newAttendance / ($totalServices + 1)) * 100;

            $member->save();

            DB::commit();

            return $this->sendResponse($attendance, 'Member Attendance taken successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function signoutAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|numeric',
            'member_code' => 'required|string',
            'worker_code' => 'sometimes|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all()[0], $validator->errors());
        }

        $worker = User::where('worker_code', $request->worker_code)->first();

        if (!$worker) {
            return $this->sendError("Invalid Worker Code");
        }

        if ($worker->id != auth()->user()->id) {
            return $this->sendError("Worker Code does not match user");
        }

        $member = Member::where('member_code', $request->member_code)->first();

        if (!$member) {
            return $this->sendError("Invalid Member. Please try again with a valid member");
        }

        if ($member->is_onboarding_completed == 1) {
            return $this->sendError("Member has completed their onboarding process");
        }

        $service = Service::find($request->service_id);

        if (!$service) {
            return $this->sendError("Invalid Service. Please try again with a valid Service");
        }

        if ($service->service_status_id != 2) {
            return $this->sendError("Attendance cannot be taken as service has ended");
        }

        try {

            $attendance = MemberAttendance::where(['service_id' => $service->id, 'created_by' => $worker->id])->first();

            if (!$attendance) {
                return $this->sendError("The Member did not log in. Cannot signout member");
            }

            $attendance->time_out = Carbon::now();
            $attendance->save();

            return $this->sendResponse($attendance, 'Member Signout successful');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function getAllAttendance(Request $request)
    {
        try {
            $attendance = MemberAttendance::leftJoin('members', 'members.id', '=', 'member_attendances.member_id')
                ->leftJoin('services', 'services.id', '=', 'member_attendances.service_id')
                ->leftJoin('service_types', 'service_types.id', '=', 'services.service_type_id')->paginate(10);
            return $this->sendResponse($attendance, 'Member Attendance fetched successfully');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }
}
