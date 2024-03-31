<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Worker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends BaseController
{

    public function updateWorker(Request $request, $workerId)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'department_id' => 'required',
            'image_url' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        try {

            $worker = Worker::find($workerId);

            if ($worker) {

                $worker->first_name = $request->first_name;
                $worker->last_name = $request->last_name;
                $worker->email = $request->email;
                $worker->department_id = $request->department_id;
                $worker->image_url = $request->image_url;
                $worker->save();
            }

            return $this->sendResponse($worker, 'Worker Added successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function allUsers(Request $request)
    {
        try {
            $workers = DB::table('users')->join('departments', 'departments.id', '=', 'users.department_id')->select('users.*', 'departments.department_name')->get();
            return $this->sendResponse($workers, 'Workers Fetched successfully.');
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }

    public function upload(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                // Process or store the uploaded file as needed
                // Generate a unique filename for the image
                $filename = time() . '.' . $file->getClientOriginalExtension();

                // Move the uploaded image to the public storage folder
                $file->move(public_path('images'), $filename);

                // Get the URL of the uploaded image
                $imageUrl = asset('images/' . $filename);

                return response()->json(['status' => true, 'message' => 'File uploaded successfully', 'data' => ['image_url' => "images/$filename"]]);
            }

            return response()->json(['status' => false, 'message' => 'No file uploaded'], 400);
        } catch (Exception $e) {
            return $this->sendError('Internal Server Error..', ['error' => $e->getMessage()]);
        }
    }
}
