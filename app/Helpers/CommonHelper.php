<?php

namespace App\Helpers;


use App\Models\NotificationSetting;
use App\SystemNotification;
use Illuminate\Support\Facades\Mail;

class CommonHelper
{

    public static function sendNotification($userDetails, $message, $link)
    {
        $notificationSetting = NotificationSetting::where('user_id', $userDetails->id)->first();
        //dd($notificationSetting);

        if (! empty($notificationSetting) && ($notificationSetting->inapp == 1 || $notificationSetting->email == 1)) {
            $notification = new SystemNotification();
            $notification->user_id = $userDetails->id;
            $notification->message = $message;
            $notification->link = $link;
            if ($notificationSetting->inapp == 1) {
                $notification->in_app = 1;
            }
            if ($notificationSetting->email == 1) {
                $notification->email = 1;
                if (! empty($notificationSetting->days)) {
                    $notification->is_cron = 1;
                    $notification->cron_day = $notificationSetting->days;
                    $notification->is_executed = 0;
                } else {
                    $path = 'mail/notification';
                    //$send_mail = send_mail($smsdata);
                    $data = ['to' => 'bhalani.akashb@gmail.com',
                        'from' => env('MAIL_USERNAME'),
                        'reply_to' => env('MAIL_USERNAME'),
                        'from_name' => '',
                        'message' => $message,
                        'link' => $link,
                        'path' => $path];

                    $data123 = Mail::send('/mail/notification', ['data' => $data], function ($m) use ($data) {
                        $m->to($data['to'])->subject("Notification from Ayojn")->getSwiftMessage()
                            ->getHeaders()
                            ->addTextHeader('x-mailgun-native-send', 'true');
                    });
                }
            }
            $notification->save();
        }
    }
}
