<?php
class QvoService
{
    public $url;
   
    
    public function httpRequest($string, $headers, $url)
    {
    
        $this->url = $url;
        $headers[] = 'Content-type: application/json';
        
        if (function_exists('curl_init')) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $base_response = curl_exec($ch);
            curl_close($ch);

            return $base_response;
        } else {
            return 'Curl offline';
        }
    }

   

     public function httpGetIt( $headers, $url)
    {
    
        $this->url = $url;
        $headers[] = 'Content-type: application/json';
        
        if (function_exists('curl_init')) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $base_response = curl_exec($ch);
            curl_close($ch);

            return $base_response;
        } else {
            return 'Curl offline';
        }
    }



}
