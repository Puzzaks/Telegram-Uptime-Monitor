# ![](header.png)
#### PHP Script for posting uptime and boot time in Telegram for convenient monitoring

You can see this script in action [here](https://t.me/PuzzakServer), where it monitors my homebrew server.

## Setup
#### Prerequisites
 - Telegram bot
 - Channel or chat for updates
 - Correct admin rights for bot in channel (publish & edit messages)
 - Linux host for script to run from

#### Steps
1. Copy `uptime_public.php` and both `lastup.txt` and `lastpost.txt` to the server
2. Edit script to include chat id (line 56) and bot token (line 57)
3. Add crontab rules for automation:
```
@reboot php /path/to/script/uptime_public.php
 * * * * * php /path/to/script/uptime_public.php
```
4. Initiate script either by rebooting the server or by executing `php uptime_public.php`

#### Why?
I've made this script so I can see if I have electricity at home wherever I am and easier than from browser.
I live in Ukraine, and my country suffers from blackouts caused by russian terroristic attacks on our social infrastructure.
You can save lives and help civilans. Please, visit https://war.ukraine.ua/support-ukraine/ for more info.
