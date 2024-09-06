<?php

namespace App\Http\Controllers\CRM\Ticket;

use App\Http\Controllers\Controller;
use App\Models\CRM\Ticket\LaraLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SwitchLanguageController extends Controller
{
    public function switchLang($lang)
    {
        Session::put('locale', $lang);
        $response = ['status' => 'success', 'code' => '200', 'message' => 'Language was switched.', 'method' => 'GET'];
        return $response;
    }

    public function getLanguage()
    {
        $dir    = lang_path(); //this for server
        $langs = array_diff(scandir($dir), array('..', '.','.DS_Store'));

        $languages = LaraLanguage::whereIn('code', $langs)->get();

        return $languages;
    }

    function getLanguageName($languageCode) {
        $languageNames = Languages::getNames('en'); // 'en' is the locale for English

        return isset($languageNames[$languageCode]) ? $languageNames[$languageCode] : 'Unknown';
    }
//
//// Example usage
//$languageCode = 'en';
//$languageName = getLanguageName($languageCode);
//
//echo "Language Code: $languageCode\n";
//echo "Language Name: $languageName\n";

}
