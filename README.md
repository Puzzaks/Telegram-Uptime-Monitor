# UptimeMonitor
This script posts &amp; updates your server uptime, boot time and last online time in Telegram

Implemented [here](https://t.me/PuzzaksServer).

## Setup
#### Prerequisites
 - Telegram bot
 - Channel or chat for updates
 - Correct admin rights for bot in channel (publish & edit messages)
 - Linux host for script to run from

#### Steps
1. Copy script to the server
2. Edit script 
You will need to give this script appropriate permissions (execute)
And create files "lastup.txt" and "lastpost.txt" in the same folder
Both files *must* contain `1` (just the number one) on the first launch
Script should be able to write to them for this to work

To automate script you can use these two rules for crontab:
```
@reboot php /path/to/script/uptime_public.php
 * * * * * php /path/to/script/uptime_public.php
```
Be sure to supply 

## License
>This is free and unencumbered software released into the public domain.

>Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

>In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

>For more information, please refer to <https://unlicense.org>
