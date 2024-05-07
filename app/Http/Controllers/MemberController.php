<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends BaseController
{
    //
    public function memberList(Request $request)
    {
        $itemSize = 10;

        $itemSize = $request->size ?? $itemSize;

        if ($request->has('search')) {
            $keyInserted = Member::where('first_name', 'LIKE', "%$request->search%")->orwhere('last_name', 'LIKE', "%$request->search%")->paginate($itemSize);
        } else {
            $keyInserted = Member::paginate($itemSize);
        }

        return $this->sendResponse($keyInserted, 'Members fetched successfully '. $itemSize);
    }

    public function addMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string',
            'email' => 'sometimes|email',
            'phone' => 'sometimes|string',
            'image_url' => 'sometimes',
            'church_id' => 'required|numeric',
            'created_by' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $namepart = strtoupper(substr($request->first_name, 0, 3)) . "" . rand(1000, 9999);

        try {
            $user = Member::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'member_code' => $namepart,
                'expected_attendance' => 12,
                'church_id' => $request->church_id,
                'image_url' => $request->image_url,
            ]);

            return $this->sendResponse($user, 'Member Added successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }
}
