<?php
    /*
        SETUP:

        You will need to give this script appropriate permissions (execute)
        And create files "lastup.txt" and "lastpost.txt" in the same folder
        Script should be able to write to them for this to work

        FUNCTIONS:

        This script posts & updates your server uptime, boot time and last online time.

        Implemented at https://t.me/PuzzaksServer

        AUTHOR:

        Puzzak, https://github.com/Puzzak/Telegram-Uptime-Monitor

        LICENSE:

        This is free and unencumbered software released into the public domain.

        Anyone is free to copy, modify, publish, use, compile, sell, or
        distribute this software, either in source code form or as a compiled
        binary, for any purpose, commercial or non-commercial, and by any
        means.

        In jurisdictions that recognize copyright laws, the author or authors
        of this software dedicate any and all copyright interest in the
        software to the public domain. We make this dedication for the benefit
        of the public at large and to the detriment of our heirs and
        successors. We intend this dedication to be an overt act of
        relinquishment in perpetuity of all present and future rights to this
        software under copyright law.

        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
        EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
        MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
        IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
        OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
        ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
        OTHER DEALINGS IN THE SOFTWARE.

        For more information, please refer to <http://unlicense.org/>


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
