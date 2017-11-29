<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Slack {
    
    // single instance of self shared among all instances
    private static $instance = null;
    
    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    
    public static function getInstance(){
        if(!self::$instance instanceof self){
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    public function postMessagesToSlack($message, $room) {
        
        //$message = "from web app";
        //$room = "general";
        $icon = ":robot_face:";
        $data = "payload=" . json_encode(array("channel" => "#{$room}","username" =>"Rolling Breakdown", "text" => $message));
        //$data1 = "payload=" . json_encode($data, $options, $depth)
        
        $url = "https://hooks.slack.com/services/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";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        echo var_dump($result);
        if ($result == false) {
            echo 'in breakdown';
            echo 'Curl error: '.curl_error($ch);
        }
        curl_close($ch);
        
    }
    
    public function postMessagesToSlack_scrapregister($message, $room) {
        
        //$message = "from web app";
        //$room = "general";
        $icon = ":robot_face:";
        $data = "payload=" . json_encode(array("channel" => "#{$room}","username" =>"LIVE STOCK", "text" => $message));
        //$data1 = "payload=" . json_encode($data, $options, $depth)
        
        $url = "https://hooks.slack.com/services/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";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        echo $ch;
        //echo var_dump($result);
        if ($result == false) {
            //echo 'in perheat';
            echo 'Curl error: '.curl_error($ch);
        }
        curl_close($ch);
        
    }   
    
    
   
    
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

