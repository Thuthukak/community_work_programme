<?php

use Illuminate\Support\Facades\Storage;

/**
 * get number in Indonesian number format.
 *
 * @param  int  $number  money in integer format
 * @return string money in string format
 */
function format_no($number)
{
    return number_format($number, 0, ',', '.');
}

/**
 * Get number in money currency format.
 *
 * @param  int|string  $number
 * @return string
 */
function format_money($number)
{
    $moneySign = Option::get('money_sign', 'R');

    if ($number == 0) {
        return $moneySign.' 0';
    }

    if ($number < 0) {
        return '- '.$moneySign.' '.format_no(abs((int) $number));
    }

    return $moneySign.' '.format_no($number);
}

/**
 * Format number to decimal format.
 *
 * @param  int|string  $number
 * @return string
 */
function format_decimal($number)
{
    return number_format($number, 2, ',', '.');
}

/**
 * Get Indonesian date format.
 *
 * @param  string  $date
 * @return string
 */
function date_id($date)
{
    if (is_null($date) || $date == '0000-00-00') {
        return '-';
    }

    $explodedDate = explode('-', $date);

    if (count($explodedDate) == 3 && checkdate($explodedDate[1], $explodedDate[2], $explodedDate[0])) {
        $months = get_months();

        return $explodedDate[2].' '.$months[$explodedDate[1]].' '.$explodedDate[0];
    }

    throw new App\Exceptions\InvalidDateException('Invalid date format.');
}

/**
 * Get two digits of month.
 *
 * @param  int|string  $number
 * @return string
 */
function month_number($number)
{
    return str_pad($number, 2, '0', STR_PAD_LEFT);
}

/**
 * Get month name from given month number.
 *
 * @param  int|string  $monthNumber
 * @return string
 */
function month_id($monthNumber)
{
    if (is_null($monthNumber)) {
        return $monthNumber;
    }

    $months = get_months();
    $monthNumber = month_number($monthNumber);

    return $months[$monthNumber];
}

/**
 * Get array of month list.
 *
 * @return array
 */
function get_months()
{
    return [
        '01' => __('time.months.01'),
        '02' => __('time.months.02'),
        '03' => __('time.months.03'),
        '04' => __('time.months.04'),
        '05' => __('time.months.05'),
        '06' => __('time.months.06'),
        '07' => __('time.months.07'),
        '08' => __('time.months.08'),
        '09' => __('time.months.09'),
        '10' => __('time.months.10'),
        '11' => __('time.months.11'),
        '12' => __('time.months.12'),
    ];
}

function get_week_numbers(string $year): array
{
    $lastWeekOfTheYear = Carbon::parse($year.'-01-01')->weeksInYear();

    return range(0, $lastWeekOfTheYear);
}

/**
 * Get array of year list starting from 2014.
 *
 * @return array
 */
function get_years()
{
    $yearRange = range(2014, date('Y'));
    foreach ($yearRange as $year) {
        $years[$year] = $year;
    }

    return $years;
}

/**
 * Split and ucword string.
 *
 * @param  string  $string
 * @return string
 */
function str_split_ucwords($string)
{
    return ucwords(str_replace('_', ' ', $string));
}

/**
 * Convert file size to have unit string.
 *
 * @param  int  $bytes  File size.
 * @return string Converted file size with unit.
 */
function format_size_units($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2).' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2).' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2).' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes.' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes.' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

/**
 * Overide Laravel Collective  link_to_route helper function.
 *
 * @param  string  $name  Name of route
 * @param  string  $title  Text that displayed on view
 * @param  array  $parameters  URL Parameter
 * @param  array  $attributes  The anchor tag atributes
 * @return string
 */
function html_link_to_route($name, $title = null, $parameters = [], $attributes = [])
{
    if (array_key_exists('icon', $attributes)) {
        $title = '<i class="fa fa-'.$attributes['icon'].'"></i> '.$title;
    }

    return app('html')->decode(link_to_route($name, $title, $parameters, $attributes));
}


/**
 * Overide Laravel Collective  link_to_route helper function.
 *
 * @param  string  $name  Name of route
 * @param  string  $title  Text that displayed on view
 * @param  array  $parameters  URL Parameter
 * @param  array  $attributes  The anchor tag atributes
 * @return string
 */
function html_link_to_routes($name, $title = null, $parameters = [], $attributes = [])
{
    if (array_key_exists('icon', $attributes)) {
        $title = '<i class="fa fa-'.$attributes['icon'].'"></i> '.$title;
    }

    // Generate the URL with correct parameters
    $url = route($name, array_slice($parameters, 0, 1)); // Project parameter should be the first item
    $query = http_build_query(array_slice($parameters, 1)); // Remaining parameters as query string

    if ($query) {
        $url .= '?' . $query;
    }

    return app('html')->decode(link_to($url, $title, $attributes));
}


/**
 * Period between two dates.
 *
 * @param  string  $date1
 * @param  string  $date2
 * @param  string  $differenceFormat
 * @return int|string
 */
function date_difference($date1, $date2, $differenceFormat = '%a')
{
    $datetime1 = date_create($date1);
    $datetime2 = date_create($date2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

/**
 * Get logo image on html img tag format.
 *
 * @param  array  $attributes
 * @return \Illuminate\Support\HtmlString
 */
function app_logo_image($attributes = [])
{
    return Html::image(
        app_logo_path(),
        'Logo '.Option::get('agency_name', 'Laravel'),
        $attributes
    );
}

/**
 * Get logo image path.
 *
 * @return string
 */
function app_logo_path()
{
    $defaultLogoImagePath = 'default-logo.png';
    $optionLogoImagePath = Option::get('agency_logo_path');

    if (is_file(storage_path('app/public/assets/imgs/'.$optionLogoImagePath))) {
        return asset('storage/assets/imgs/'.$optionLogoImagePath);
    }

    return asset('assets/imgs/'.$defaultLogoImagePath);
}

/**
 * Get array of dates in a month.
 *
 * @param  string  $year
 * @param  string  $month
 * @return array
 */
function month_date_array($year, $month)
{
    $dateCount = Carbon::parse($year.'-'.$month)->format('t');
    $dates = [];
    foreach (range(1, $dateCount) as $dateNumber) {
        $dates[] = str_pad($dateNumber, 2, '0', STR_PAD_LEFT);
    }

    return $dates;
}

/**
 * Function helper to add flash notification.
 *
 * @param  null|string  $message  The flashed message.
 * @param  string  $level  Level/type of message
 * @return void
 */
function flash($message = null, $level = 'info')
{
    $session = app('session');


    if (!is_null($message)) {
        $session->flash('flash_notification.message', $message);
        $session->flash('flash_notification.level', $level);
    }
}

function storeOriginalImage($file, $folder = 'uploads')
{
    $path = $file->hashName($folder);
    $serverPath = $file->hashName($folder);

    $image = Image::make($file);

    Storage::put($path, (string)$image->encode());

    return $serverPath;
}

function storeImage($file, $folder = 'uploads', $width = 870, $height = 1200)
{
    $path = $file->hashName($folder);
    $serverPath = $file->hashName($folder);

    $image = Image::make($file);
    
    $image->fit($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    });


    Storage::put($path, (string)$image->encode());

    return $serverPath;
}

function symImagePath()
{
    return "storage/";
}

function symImageFullPath()
{
    return config('url') . "/storage/";
}


function storeThumb($file,$folder = 'profile',$width = 120, $height = 120)
{

    $path = $folder."/" . md5(time() * time()) . ".jpeg";

    $image = Image::make($file);
    $image->fit($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    });

    Storage::put($path, (string)$image->encode());
    return $path;
}

function storeNotify($message){
    $notification = array(
        'message' => $message.' saved successfully!',
        'alert-type' => 'success'
    );

    return $notification;
}

function updateNotify($message){
    $notification = array(
        'message' => $message.' updated successfully!',
        'alert-type' => 'success'
    );

    return $notification;
}

function deleteNotify($message){
    $notification = array(
        'message' => $message.' deleted successfully!',
        'alert-type' => 'success'
    );

    return $notification;
}

function errorNotify($message){
    $notification = array(
        'message' => 'Whoops! '.$message.' failed!',
        'alert-type' => 'error'
    );

    return $notification;
}

function emailNotify($message){
    $notification = array(
        'message' => $message.' successfully!',
        'alert-type' => 'success'
    );

    return $notification;
}

function demoNotify($message){
    $notification = array(
        'message' => $message,
        'alert-type' => 'warning'
    );

    return $notification;
}

function mailNotify($message){
    $notification = array(
        'message' => $message.' successfully sent!',
        'alert-type' => 'success'
    );

    return $notification;
}

function mailWarning($message){
    $notification = array(
        'message' => $message,
        'alert-type' => 'error'
    );

    return $notification;
}

function checkFileExtension($file) {
    return pathinfo(symImagePath().$file, PATHINFO_EXTENSION);
}
