<?php

Class keyApi
{

    private $key = null;
    private $error = null;
    private $ip = "";

    function __construct($key = null)
    {  
       if(!empty($key)) $this->key = $key;
    }

    function pegarip($ip)
    {
        $this->ip = $ip;
    }

    function request ($endpoint = '', $parametros =  array())
    {

        if(strlen($this->ip) != 0)
        {
            $url = "https://geo.ipify.org/".$endpoint."?apiKey=".$this->key."&ipAddress=".$this->ip."&format=json";
        }
        else{
            $url = "https://geo.ipify.org/".$endpoint."?apiKey=".$this->key."&format=json";
        }

        if(is_array($parametros))
        {
            
            foreach($parametros as $key => $value)
            {
                if(empty($value)) continue;
                $url .= $key."=".urlencode($value)."&";
            }   
            $response = @file_get_contents($url);
            $this->error = false;
            return json_decode($response,true);
        }
        else{
            $this->error = true;
            return false;
        }
    }

    function is_error()
    {
        return $this->error;
    }

    function country()
    {
        $data = $this->request("/api/v1");
        if(!empty($data) && is_array($data['location']))
        {

            $this->error = false;
            return $data;
        }
        else{
            $this->error = true;
            return false;
        }
    }
}

?>