<?php
    /*
        SETUP:

        You will need to give this script appropriate permissions (execute)
        And create files "lastup.txt" and "lastpost.txt" in the same folder
        Script should be able to write to them for this to work

        FUNCTIONS:

        This script posts & updates your server uptime, boot time and last online time.



    */






    function userData(){
        $data = Array(
            "chat" => "", // insert chat_id
            "bot"  => ""  // insert bot token
        );
        return $data;
    }

    function checkPostTime(){
        $lastupf = fopen("lastup.txt", "r");
        $lastup = fread($lastupf, filesize("lastup.txt"));
        fclose($lastupf);

        $curup = strtotime(exec('uptime -s'));

        if($lastup == $curup){
            updateUp();
            echo "Last uptime matches saved (".$lastup." vs ".$curup.")";
        }else{
            sendUp();
            echo "Last uptime doesn't match saved (".$lastup." vs ".$curup.")";
        }
    }

    function updateUp(){
        $lastpostf = fopen("lastpost.txt", "r");
        $lastpost = fread($lastpostf, filesize("lastpost.txt"));
        fclose($lastpostf);

        $since = date('H:i:s, dS \of M Y', strtotime(exec('uptime -s')));
        $uptime = substr(exec('uptime -p'), 3, strlen(exec('uptime -p')));
        $curtime = date('H:i:s, dS \of M Y');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".userData()["bot"]."/editMessageText?chat_id=".userData()["chat"]."&message_id=".$lastpost."&text=".urlencode("<code> • Booted at </code><code>".$since."</code>\n<code> • Was up at </code><code>".$curtime."</code>\n<code> • Uptime is </code><code>".$uptime."</code>")."&parse_mode=HTML");
        curl_exec($ch);
        curl_close($ch);
    }


        function sendUp(){
            $since = date('H:i:s, dS \of M Y', strtotime(exec('uptime -s')));
            $uptime = substr(exec('uptime -p'), 3, strlen(exec('uptime -p')));
            $curtime = date('H:i:s, dS \of M Y');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".userData()["bot"]."/sendMessage?chat_id=".userData()["chat"]."&text=".urlencode("<code> • Booted at </code><code>".$since."</code>\n<code> • Was up at </code><code>".$curtime."</code>\n<code> • Uptime is </code><code>".$uptime."</code>")."&parse_mode=HTML");
            $data = curl_exec($ch);
            curl_close($ch);
            $array=json_decode($data,true);
            $postid=$array['result']['message_id'];
            $myfile = fopen("lastpost.txt", "w");
            fwrite($myfile, $postid);
            fclose($myfile);
        $myfile = fopen("lastup.txt", "w");
            fwrite($myfile, strtotime(exec('uptime -s')));
            fclose($myfile);
        }
        checkPostTime();
?>
