<?php

use Illuminate\Support\Facades\Log;

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