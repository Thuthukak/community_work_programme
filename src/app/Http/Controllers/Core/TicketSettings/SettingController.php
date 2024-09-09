<?php

namespace App\Http\Controllers\Core\TicketSettings;

use App\Models\CRM\Ticket\traits\EmailSettingTrait;
use Illuminate\Http\Request;
use App\Models\CRM\GeneralSetting;
use App\Mail\AppMailer;
use App\Http\Controllers\Controller;


class SettingController extends Controller
{
    use EmailSettingTrait;

    public function settingIndex()
    {
        $setting = GeneralSetting::first();

        return view('settings.app-setting', compact('setting'));
    }

    public function appSettingUpdate(Request $request, GeneralSetting $setting)
    {
        $data = $request->all();
        $update = $setting->update($data);

        if ($update) {
            $notify = updateNotify('App setting');
        } else {
            $notify = errorNotify('App setting');
        }

        return redirect()->back()->with($notify);
    }

    public function emailSetting()
    {
        $setting = GeneralSetting::first();

        return view('settings.emailconfig', compact('setting'));
    }

    public function emailSettingUpdate(Request $request, GeneralSetting $setting)
    {
        $this->validate($request, [
            'from_name' => 'required',
            'from_email' => 'required',
            'mail_driver' => 'required',
        ]);

        $update = $this->emailSettingUpdateData($setting, $request);

        if ($update) {
            //send test email
            if ($request->test_mail) {

                if ($this->testMail($request->test_mail)) {
                    $notify = mailNotify('Email setting updated & Test Email Sent');
                    return redirect()->back()->with($notify);
                } else {
                    $notify = mailWarning('Email setting updated & Test Email send fail!');
                    return redirect()->back()->with($notify);
                }
            } else {
                $notify = updateNotify('Email setting');
                return redirect()->back()->with($notify);
            }
        } else {
            $notify = errorNotify('Email setting');
            return redirect()->back()->with($notify);
        }
    }

    public function testMail($email)
    {
        $app = GeneralSetting::first();
        $subject = 'Test email';
        $emailHeader = '<html>
                           <div style="width: 35%; color: #333333; font-family: Helvetica; margin:auto; font-size: 125%; padding-bottom: 10px;">
                               <div style="text-align:center; padding-top: 10px; padding-bottom: 10px;">
                                   <h1>' . $app->app_name . '</h1>
                               </div>
                               <div style="padding: 35px;padding-left:20px; border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc;">';
        $emailFooter = '        </div>
                           </div>
                       </html>';

        $mailText = $emailHeader . 'This is a test email. Your email config working' . $emailFooter;
        $mailer = new AppMailer;

        try {
            $mailer->sendEmail($mailText, $email, $subject);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
