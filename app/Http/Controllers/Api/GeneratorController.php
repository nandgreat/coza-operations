<?php

namespace App\Http\Controllers\Api;

use App\Models\Generator;
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
}
