<?php 
use Twilio\Rest\Client;
defined('BASEPATH') OR exit('No direct script access allowed.');
/**
* Function for fare calculation
*
* @package         CodeIgniter
* @category        Helper
* @author          Rohit Dhiman
* @license         
* @link            
*/

if (!function_exists('twilioMessage')) {
	function twilioMessage($msg=null)
    {
        if ($msg=="") {
            $from='+12028688886';
            $to='+917832027983';
            $body="Hello dummy test here to +917832027983";
        }else{
            $from='+12028688886';
            $to=$msg['to'];
            $body=$msg['body'];
        }
        // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC7be182b7f9efc4101851497683116496';
        $token = 'f371d9252dc7b9dff9a9f8a69308028c';
        $client = new Client($sid, $token);

        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $to,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $from,
                // the body of the text message you'd like to send
                'body' => $body
            )
        );
    }
}