<?php

namespace App\Http\Controllers;

use ConfigHelper;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $http_referer;
    public $pre_url;

    public function __construct ()
    {

        $request_uri = explode('/' , substr($_SERVER['REQUEST_URI'],1,strlen($_SERVER['REQUEST_URI'])));

        if (!empty($request_uri['0']) 
            && !empty($request_uri['1']) 
            && in_array($request_uri['0'], ['report','leaves_manager','leaves_my','agent_approve','leaves_hr','annual_report','annual_leave_calculate','leaved_user_annual_leave_calculate','agent']) 
            && $request_uri['1'] == 'leave_detail'
        ) {

            if (!empty($_SERVER['HTTP_REFERER'])) {

                $domain = ConfigHelper::getConfigValueByKey('company_domain');
                $referer_array = explode('/' , substr(explode($domain, $_SERVER['HTTP_REFERER'])['1'],1,strlen(explode($domain, $_SERVER['HTTP_REFERER'])['1'])));

                $this->pre_url = $_SERVER['HTTP_REFERER'];

                if (!empty($referer_array['0'])) {

                    $this->http_referer =  $referer_array['0'];

                }

            } else {

                $this->pre_url = '';
                $this->http_referer = '';

            }
            
        }
        
    }

}
