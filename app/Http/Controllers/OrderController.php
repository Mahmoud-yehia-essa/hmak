<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MetaPixelService;

class OrderController extends Controller
{
    public function complete(Request $request, MetaPixelService $meta)
    {
        $user = $request->user(); // or however you access the buyer

        // Generate a stable event ID for dedup (share it with frontend)
        $eventId = 'order_' . uniqid();

        // // Send server-side event
        // $meta->sendEvent(
        //     eventName: 'Purchase',
        //     eventId: $eventId,
        //     userDataRaw: [
        //         'email'       => $user?->email,
        //         'phone'       => $user?->phone,
        //         'external_id' => $user?->id,     // optional but good
        //         // 'ip' => $request->ip(),       // optional; auto-filled
        //         // 'ua' => $request->userAgent() // optional; auto-filled
        //     ],
        //     customData: [
        //         'currency'      => 'USD',
        //         'value'         => 59.99,
        //         'content_type'  => 'product',
        //         'content_ids'   => ['SKU123'],
        //     ],
        //     request: $request
        //     , testEventCode: 'TEST58123'      // use when testing from Events Manager → Test Events
        // );



            // Send server-side event
        $meta->sendEvent(
            eventName: 'Purchase',
            eventId: $eventId,
            userDataRaw: [
                'email'       => "mahmoudessa@gmail.com",
                'phone'       => '9999999',
                'external_id' => '11111',     // optional but good
                // 'ip' => $request->ip(),       // optional; auto-filled
                // 'ua' => $request->userAgent() // optional; auto-filled
            ],
            customData: [
                'currency'      => 'USD',
                'value'         => 59.99,
                'content_type'  => 'product',
                'content_ids'   => ['SKU123'],
            ],
            request: $request
            , testEventCode: 'TEST58123'      // use when testing from Events Manager → Test Events
        );


        // Render a thank-you page that also fires the browser pixel w/ same eventID
        return view('frontend.meta.thankyou', [
            'eventId' => "nnnnnnn",
            'order_value' => 59.99,
        ]);
    }


    public function ordersTest()
    {
        return view('frontend.meta.test');
    }
}
