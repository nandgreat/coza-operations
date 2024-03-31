<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Key;
use App\Models\KeyLog;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function login(Request $request)
    {
        Log::info($request->all());
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['auth']['access_token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['user'] =  $user;

            $workersCount = Worker::all()->count();
            $keysCount = Key::all()->count();
            $keyLogsCount = KeyLog::all()->count();

            $success['dashboard_count']['workers_count'] = $workersCount;
            $success['dashboard_count']['keys_count'] = $keysCount;
            $success['dashboard_count']['key_logs_count'] = $keyLogsCount;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Invalid login credentials', ['error' => 'Unauthorised']);
        }
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'department_id' => 'required|exists:departments,id',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all()[0], []);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'worker_code' => "" . rand(1111, 9999),
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'department_id' => $request->department_id,
            'image_url' => $request->image_url,
        ]);

        $success['auth']['access_token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['user'] =  $user;

        return $this->sendResponse($success, 'User register successfully.');
    }
}
