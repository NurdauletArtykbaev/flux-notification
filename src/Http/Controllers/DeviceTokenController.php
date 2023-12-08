<?php

namespace Raim\FluxNotify\Http\Controllers;

use Raim\FluxNotify\Helpers\DeviceTokenHelper;
use Illuminate\Http\Request;

class DeviceTokenController
{
    public function store(Request $request)
    {
        $user = $request->user();
//        $request->validate([
//            'device_token' => 'required'
//        ]);
        $platform = DeviceTokenHelper::getPlatform($request->platform);
        config('flux-notification.models.device_token')::updateOrCreate(
            [
                'user_id' => $user->id,
                'platform' => $platform
            ],
            [
                'device_token' => $request->get('device_token'),
            ]
        );

        return response()->noContent();
    }

    public function delete(Request $request)
    {
        $platform = DeviceTokenHelper::getPlatform($request->platform);
        if (config('flux-notification.models.device_token')::where('user_id', $request->user()->id)->where('platform', $platform)->exists()) {
            config('flux-notification.models.device_token')::where('user_id', $request->user()->id)->where('platform', $platform)->delete();
        }
        return response()->noContent();
    }
}
