<?php

namespace App\Http\Controllers\Api;

use App\Models\ApprovalAdmins;
use App\Models\Generator;
use App\Models\GeneratorPurpose;
use Illuminate\Http\Request;

class GeneratorController extends BaseController
{
    //

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'generator_name' => 'required|unique:generators'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {
            $keyInserted = Generator::create(['generator_name' => $request->generator_name]);

            return $this->sendResponse($keyInserted, 'Generator Added successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function generatorList(Request $request)
    {
        $keyInserted = Generator::all();

        return $this->sendResponse($keyInserted, 'Generators fetched successfully.');
    }

    public function approvalAdmins(Request $request)
    {
        $keyInserted = ApprovalAdmins::all();

        return $this->sendResponse($keyInserted, 'Approval Admins fetched successfully.');
    }

    public function generatorPurpose(Request $request)
    {
        $keyInserted = GeneratorPurpose::all();
        return $this->sendResponse($keyInserted, 'Generators Purpose fetched successfully.');
    }
}
