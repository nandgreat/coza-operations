<?php

use Illuminate\Support\Facades\Log;
use App\Models\User;

function logInfo($content, $title = "No Title")
{
    Log::info("<<<<<<<<<<<<<");
    Log::info($title);
    Log::info(">>>>>>>>>>>>>>>>>>>>>>");
    Log::info($content);
}


function validateWorkerCode($workerCode)
{
    $worker = auth()->user();

    if ($workerCode != $worker->worker_code) {
        return ['status' => '02', 'message' => 'Invalid worker code. Please enter a valid Worker code'];
    }
    return ['status' => '00', 'message' => 'Worker Code verified successfully', 'data' => $worker];
}

function validateConfirmationWorkerCode($workerCode)
{
    $anyWorker = User::where('worker_code', $workerCode)->first();

    if (!$anyWorker) {
        return ['status' => '01', 'message' => 'Invalid Confirmation worker code. Please enter a valid Worker code'];
    }

    $worker = auth()->user();

    if ($workerCode == $worker->worker_code) {
        return ['status' => '02', 'message' => 'Confirmation Worker cannot be same as the Current Worker'];
    }

    return ['status' => '00', 'message' => 'Worker Code verified successfully', 'data' => $worker];
}
