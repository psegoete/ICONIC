<?php
/**
 * Created by PhpStorm.
 * User: CreatyDev
 * Date: 12/29/2017
 * Time: 1:30 AM
 */
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\FileService;
use CreatyDev\Domain\UserCompanyCredit;
use CreatyDev\Domain\UserTuningCredit;
use CreatyDev\Domain\Ticket\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use CreatyDev\Domain\TuningOption;
use CreatyDev\Domain\Subscription;
use CreatyDev\Domain\Users\Models\User;

if (!function_exists('on_page')) {
    /**
     * Check's whether request url/route matches passed link
     *
     * @param $link
     * @param string $type
     * @return null
     */
    function on_page($link, $type = "name")
    {
        switch ($type) {
            case "url":
                $result = ($link == request()->fullUrl());
                break;

            default:
                $result = ($link == request()->route()->getName());
        }

       
        if ($link == 'gearboxes.index' && 'gearboxes.edit' == request()->route()->getName()) {
            return true;
        }else if ($link == request()->route()->getName()) {
            return true;
        }

        // dd($link);


    }
}

if (!function_exists('exists_in_filter_key')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $key
     * @param $value
     * @return null
     */
    function exists_in_filter_key($key, $value = null)
    {
        return collect(explode("&", $key))->contains($value);
    }
}

if (!function_exists('comapnyLogo')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $key
     * @param $value
     * @return null
     */
    function comapnyLogo()
    {
        return Company::where('domain_name', '=', request()->getHost())->firstOrFail()->company_logo;
    }
}


if (!function_exists('join_in_filter_key')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $value
     * @return null
     */
    function join_in_filter_key(...$value)
    {
        //remove empty values
        $value = array_filter($value, function ($item) {
            return isset($item);
        });

        return collect($value)->implode('&');
    }
}

if (!function_exists('remove_from_filter_key')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $key
     * @param $oldValues
     * @param $value
     * @return null
     */
    function remove_from_filter_key($key, $oldValues, $value)
    {
        $newValues = array_diff(
            array_values(
                explode("&", $oldValues)
            ), [
            $value, 'page'
        ]);

        if (count($newValues) == 0) {
            array_except(request()->query(), [$key, 'page']);

            return null;
        }

        return collect($newValues)->implode('&');
    }
}

if (!function_exists('return_if')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function return_if($condition, $value)
    {

        if ($condition) {
            return $value;
        }
    }

    
    
}
        if (!function_exists('checkDomain')) {
            /**
             * Appends passed value if condition is true
             *
             * @param $condition
             * @param $value
             * @return null
             */
            function checkDomain()
            {
               return Company::where('domain_name', '=', request()->getHost())->firstOrFail()->id;
            }
        }
        if (!function_exists('checkEagleEyePortal')) {
            /**
             * Appends passed value if condition is true
             *
             * @param $condition
             * @param $value
             * @return null
             */
            function checkEagleEyePortal()
            {
               return request()->getHost() == 'portal.eagletunedinternational.com';
            }
        }


        if (!function_exists('companyName')) {
            /**
             * Appends passed value if condition is true
             *
             * @param $condition
             * @param $value
             * @return null
             */
            function companyName()
            {
               $company =  Company::where('domain_name', '=', request()->getHost())->first();
                if($company){
                    return $company->company_name;
                }else{
                    return '';
                }

            }
        }


        if (!function_exists('test')) {
            /**
             * Appends passed value if condition is true
             *
             * @param $condition
             * @param $value
             * @return null
             */
            function test()
            {
                return request()->route()->getName();
            }
        }

if (!function_exists('ticketsExist')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function ticketsExist($id)
    {
        $ticket = Ticket::where([['company_id','=', checkDomain()],['file_service_id','=', $id]])->get()->count();
       return $ticket;
    }
}

if (!function_exists('currentCredits')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function currentCredits()
    {

        if(auth()->user()->role == 'customer'){
            
            $credit = UserTuningCredit::where([['company_id','=', checkDomain()],['user_id','=', auth()->user()->id]])->first();
            if ($credit) {
                $credit = $credit->credits;
            }else{
                $credit = 0.00;
            }
            return $credit;
        }

        if(auth()->user()->role == 'admin'){
            
            $company = Company::where([['id','=', checkDomain()]])->first();
            $credit = UserCompanyCredit::where([['company_id','=', checkDomain()]])->first();
                
                if($company->plan == 'enterprice'){
                    return 'Ultimate plan';
                }else{
    
                    if ($credit) {
                        $credit = $credit->credits;
                    }else{
                        $credit = 0.00;
                    }
                    return $credit;
                }
        }
        
    }
}

if (!function_exists('companyCredits')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function companyCredits()
    {
            
            $credit = UserCompanyCredit::where([['company_id','=', checkDomain()]])->first();
            
            if ($credit) {
                $credit = $credit->credits;
            }else{
                $credit = 0.00;
            }
            return $credit;
        
    }
}
if (!function_exists('deleteGroup')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function deleteGroup($id)
    {
            
            $users = User::where([['company_id','=', checkDomain()],['credit_group_id','=', $id]])->get();
            
            if ($users->count()) {
                $users = $users->count();
            }else{
                $users = 0;
            }
            return $users;
        
    }
}

if (!function_exists('tuningTypesOptions')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function tuningTypesOptions($id)
    {
            
            $tuning_options = TuningOption::where([['tuning_type_id','=', $id]])->get();
            
            if ($tuning_options) {
                $tuning_options = $tuning_options->count();
            }else{
                $tuning_options = 0;
            }
            return $tuning_options;
        
    }
}
if (!function_exists('subscription')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function subscription()
    {
            
            $subscription = Subscription::where([['company_id','=', checkDomain()]])->get();
            
            if ($subscription[0]->status == '1') {
                $subscription = '1';
            }else{
                $subscription = 0;
            }
            return $subscription;
    }
}

if (!function_exists('companyPlan')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function companyPlan()
    {
       return Company::where('domain_name', '=', request()->getHost())->firstOrFail()->plan;
    }
}
if (!function_exists('userCredits')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function userCredits($id)
    {
        $credits = UserTuningCredit::where([['user_id','=', $id]])->get();
        dd($id);
        if($credits->count()){
            return $credits[0]->credits;
        }else{
            return 0.00;
        }

    }
}
if (!function_exists('openFileService')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function openFileService()
    {
        if(auth()->user()->role == 'customer'){
            
            $totalFileService = FileService::where([['company_id','=', checkDomain()],['user_id','=', auth()->user()->id],['downloaded_file_service','=', 0]])->get();
            if ($totalFileService->count()) {
                $count = $totalFileService->count();
            }else{
                $count = '';
            }
            return $count;
        }

        if(auth()->user()->role == 'admin'){
            $totalFileService = FileService::where([['company_id','=', checkDomain()],['status','=', 'Open']])->get();
            if ($totalFileService->count()) {
                $count = $totalFileService->count();
            }else{
                $count = '';
            }
            return $count;
        }

    }
}

if (!function_exists('openTickets')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function openTickets()
    {
        if(auth()->user()->role == 'customer'){
            
            $totalTickets = Ticket::where([['company_id','=', checkDomain()],['user_id','=', auth()->user()->id],['customer_viewed_status','=', 'Open']])->get();
            if ($totalTickets->count()) {
                $count = $totalTickets->count();
            }else{
                $count = '';
            }
            return $count;
        }

        if(auth()->user()->role == 'admin'){
            $totalTickets = Ticket::where([['company_id','=', checkDomain()],['admin_view_status','=', 'Open']])->get();
            if ($totalTickets->count()) {
                $count = $totalTickets->count();
            }else{
                $count = '';
            }
            return $count;  
        }

    }
}

if (!function_exists('countries')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function countries()
    {
        $countries = ['Afghanistan','Åland Islands',
                'Albania','Algeria','American Samoa','Andorra',
                'Angola','Anguilla','Antarctica','Antigua and Barbuda',
                'Argentina','Armenia','Aruba','Australia',
                'Austria','Azerbaijan','Bahamas',
                'Bahrain','Bangladesh','Barbados','Belarus',
                'Belgium','Belize','Benin','Bermuda','Bhutan',
                'Bolivia, Plurinational State of','Bonaire, Sint Eustatius and Saba',
                'Bosnia and Herzegovina','Botswana','Bouvet Island',
                'Brazil','British Indian Ocean Territory','Brunei Darussalam',
                'Bulgaria','Burkina Faso','Burundi','Cambodia','Cameroon','Canada',
                'Cape Verde','Cayman Islands','Central African Republic',
                'Chad','Chile','China','Christmas Island','Cocos (Keeling) Islands',
                'Colombia','Comoros','Congo','Congo, the Democratic Republic of the',
                'Cook Islands','Costa Rica',"Côte d'Ivoire",'Croatia','Cuba',
                'Curaçao','Cyprus','Czech Republic','Denmark','Djibouti','Dominica',
                'Dominican Republic','Ecuador','El Salvador','Equatorial Guinea',
                'Eritrea','Estonia','Ethiopia','Falkland Islands (Malvinas)',
                'Faroe Islands','Fiji','Finland','France','French Guiana',
                'French Polynesia','French Southern Territories','Gabon','Gambia',
                'Georgia','Germany','Ghana','Gibraltar','Greece','Greenland',
                'Grenada','Guadeloupe','Guam','Guatemala','Guernsey','Guinea',
                'Guinea-Bissau','Guyana','Haiti','Heard Island and McDonald Islands',
                'Holy See (Vatican City State)','Honduras','Hong Kong','Hungary',
                'Iceland','India','Indonesia','Iran, Islamic Republic of','Iraq',
                'Ireland','Isle of Man','Israel','Italy','Jamaica','Japan','Jersey',
                'Jordan','Kazakhstan','Kenya','Kiribati',"Korea, Democratic People's Republic of",
                'Korea, Republic of','Kuwait','Kyrgyzstan',"Lao People's Democratic Republic",
                'Latvia','Lebanon','Lesotho','Liberia','Libya','Liechtenstein','Lithuania',
                'Luxembourg','Macao','Macedonia, the former Yugoslav Republic of',
                'Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands',
                'Martinique','Mauritania','Mauritius','Mayotte','Mexico','Micronesia, Federated States of',
                'Moldova, Republic of','Monaco','Mongolia','Montenegro','Montserrat',
                'Morocco','Mozambique','Myanmar','Namibia','Nauru','Nepal','Netherlands',
                'New Caledonia','New Zealand','Nicaragua','Niger','Nigeria','Niue',
                'Norfolk Island','Northern Mariana Islands','Norway','Oman','Pakistan',
                'Palau','Palestinian Territory, Occupied','Panama','Papua New Guinea',
                'Paraguay','Peru','Philippines','Pitcairn','Poland','Portugal','Puerto Rico',
                'Qatar','Réunion','Romania','Russian Federation','Rwanda','Saint Barthélemy',
                'Saint Helena, Ascension and Tristan da Cunha','Saint Kitts and Nevis',
                'Saint Lucia','Saint Martin (French part)','Saint Pierre and Miquelon',
                'Saint Vincent and the Grenadines','Samoa','San Marino','Sao Tome and Principe',
                'Saudi Arabia','Senegal','Serbia','Seychelles','Sierra Leone','Singapore',
                'Sint Maarten (Dutch part)','Slovakia','Slovenia','Solomon Islands','Somalia',
                'South Africa','South Georgia and the South Sandwich Islands','South Sudan',
                'Spain','Sri Lanka','Sudan','Suriname','Svalbard and Jan Mayen','Swaziland',
                'Sweden','Switzerland','Syrian Arab Republic','Taiwan, Province of China',
                'Tajikistan','Tanzania, United Republic of','Thailand','Timor-Leste',
                'Togo','Tokelau','Tonga','Trinidad and Tobago','Tunisia','Turkey',
                'Turkmenistan','Turks and Caicos Islands','Tuvalu','Uganda','Ukraine',
                'United Arab Emirates','United Kingdom','United States',
                'United States Minor Outlying Islands','Uruguay','Uzbekistan','Vanuatu',
                'Venezuela, Bolivarian Republic of','Viet Nam','Virgin Islands, British',
                'Virgin Islands, U.S.','Wallis and Futuna','Western Sahara','Yemen',
                'Zambia','Zimbabwe'
            ];

            return $countries;
    }
}

if (!function_exists('pushNotification')) {
    /**
     * Appends passed value if condition is true
     *
     * @param $condition
     * @param $value
     * @return null
     */
    function pushNotification($devise_id, $body, $title)
    {
        $headers = array(
            'Authorization: key=' . 'AAAAYmXd74U:APA91bEqPL0LXy2ida9tbYPg_WsDbkaBUZQ5hBsk_U5pbemFld7QmwBhxkSJuN34Th-D6z8Oq9Rr_rv6IYXREf3hogWeRURnW2zriPnwgaa3NRp7OYCrjjQdf2YK9uu3WPnjzV50M_cb',
            'Content-Type: application/json'
        );

        $fields = array(
            'to' => $devise_id,
            'notification' => array(
                'body' => $body,
                'title' => $title,
                'icon'  => 'myicon',/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
            )
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}