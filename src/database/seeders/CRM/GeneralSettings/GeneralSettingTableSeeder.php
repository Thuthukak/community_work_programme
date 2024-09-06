<?php

namespace Database\Seeders\CRM\GeneralSettings;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
            'app_name' => 'CWP Portal',
            'app_description' => 'Community Work Programme Portal',
            'app_keywords' => 'Employement, community work, community, work, CWP, CWP Portal',
            //'app_language' => 'en',
            'logo' => null,
            'favicon_icon' => null,
            'header_title' => 'Welcome to the CWP Portal',
            'header_subtitle' => 'Its a support application for our product. We normally response within 24 hours',
            'testimonial_title' => 'WHAT CLIENTS SAY?',
            'testimonial_details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been',
            'how_work_title' => 'How it works',
            'how_work_details' => 'Morbi varius, nulla sit amet rutrum elementum, est elit finibus tellus, ut tristique elit risus at metus.',
            'aboutus_keyword' => 'helpy about, helpy ticket support, helpy knowledge base, helpy faq',
            'aboutus_title' => 'About US',
            'aboutus_details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.',
            'social_title' => 'FIND US ON SOCIAL MEDIA',
            'service_title' => 'WHAT WE DO ?',
            'service_details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s.',
            'footer_text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
            'contact_title' => 'CONTACT US',
            'contact_address' => '87 Hamilton Street, Arcadia,',
            'contact_phone' => '+27 12 334- 0831 / 0641',
            'contact_email' => ' info@cogta.gov.za',
            'email_notification' => '0',
            'sms_notification' => '0',
            'registration_verification' => '0',
            'email_verification' => '0',
            'sms_verification' => '0',
            'ticket_counter' => 2755,
            'ticket_solved' => 1055,
            'kb_counter' => 5755,
            'client_counter' => 755,
        ]);
    }
}
