<?php

if (!function_exists('setLogActivity'))
{
    function setLogActivity($request)
    {
        $type = $request->id ? "Edit Request" : "Create request";
        $request['date'] = date('Y-m-d H:i:s');
        $request['ip'] = $request->ip();
        $request['user'] = \Auth::user()->id;
        $request['type'] = $type;
        \Log::info($request);
    }
}

