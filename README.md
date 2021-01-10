"twflood_php" is used to post tweets automaticly.

![](https://raw.githubusercontent.com/anonymousadm/twflood_php/main/screenshot/2021-01-10_00-08-02.jpg)

Select image file that you want to post
Input the screenname that you want to flood
Then there's 2 options, one is from the target's timeline, it will pickup the users from the target's timeline and push the image to the user. Another opertion the tool will pickup 1000 followers from the targer and push the image to these followers.

This tools is based on php+twurl+bashscript.
Get twurl from here "https://github.com/twitter/twurl"
before run the tool you need register a twitter developer account and create a project first. If you have multi twitter accounts you can register them on you twitter project by using the twurl.
After that, you need to edit the twconsumerkey.list file by using format "twitter account;consumerkey"

Demo is here: "http://54.189.14.27:8888/" but I removed "twconsumerkey.list" so you can't run it directly anymore.
