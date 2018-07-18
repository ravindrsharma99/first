<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    /**
    * Name:  Twilio
    *
    * Author: Ben Edmunds
    *         ben.edmunds@gmail.com
    *         @benedmunds
    *
    * Location:
    *
    * Created:  03.29.2011
    *
    * Description:  Twilio configuration settings.
    *
    *
    */

    /**
     * Mode ("sandbox" or "prod")
     **/
    $config['mode']   = 'prod';

    /**
     * Account SID
     **/
    // $config['account_sid']   = 'AC98533cb36f8ee1317386250a102e748a';
    $config['account_sid']   = 'AC31f405f2d35806cb73d327803db5fad3';
    

    /**
     * Auth Token
     **/
    // $config['auth_token']    = '7f9c5646db9ebf48074b844043fb1163';
    $config['auth_token']    = '098fb122e7922623b43f7b4598dcf152';
    
    /**
     * API Version
     **/
    $config['api_version']   = '2010-04-01';

    /**
     * Twilio Phone Number
     **/
    // $config['number']        = '+14065347696';
    $config['number']        = '+13022465586';



/* End of file twilio.php */