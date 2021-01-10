#! /bin/bash

_USER_NAME=$1
_FILE=$3
_RADIO=$2
_MULTIPROCESS=`cat twconsumerkey.list | wc -l`
_COUNT=120
if [ $_RADIO == "TimeLine" ]; then
	twurl /1.1/favorites/list.json?screen_name=$_USER_NAME | jq . | grep "screen_name" | awk -F":" '{print $2}' | sed 's/"//g' | sed 's/,//g' | sed 's/ //g'  | grep -v $_USER_NAME | grep -v null | sort -u > ./tmp/$_USER_NAME.list;
else
	twurl "/1.1/followers/ids.json?screen_name=$_USER_NAME&count=1000" | json-query ids > ./tmp/$_USER_NAME.ids.list
	cat ./tmp/$_USER_NAME.ids.list | while read _ID;
	do
		twurl /1.1/users/show.json?id=$_ID | jq .screen_name | sed 's/;/,/g' | sed 's/"//g' >> ./tmp/$_USER_NAME.list;
	done;
fi

cat ./tmp/$_USER_NAME.list | while read _SCREEN_NAME;
do
	_ERROR=`twurl /1.1/users/show.json?screen_name=$_SCREEN_NAME | jq .errors[].code`
	if [ "$_ERROR" != 50 ]; then
				
		_RANDOM=`shuf -i 1-$_MULTIPROCESS -n 1`
		_RANDOMROBOT=`sed -n "$_RANDOM"p twconsumerkey.list | awk -F";" '{print $1}'`
		_RANDOMKEY=`sed -n "$_RANDOM"p twconsumerkey.list | awk -F";" '{print $2}'`
		twurl set default $_RANDOMROBOT $_RANDOMKEY
		
		_TWEET_ID=`twurl /1.1/statuses/user_timeline.json?screen_name=$_SCREEN_NAME | jq .[1].id_str | sed 's/"//g'`
			
		_SIZE=`ls -l $_FILE | awk '{print $5}'`
		_MEDIA_ID_STRING=`twurl -H upload.twitter.com "/1.1/media/upload.json" -d "command=INIT&media_type=image/jpg&total_bytes=$_SIZE" | jq .media_id_string | sed 's/"//g'`
		twurl -H upload.twitter.com "/1.1/media/upload.json" -d "command=APPEND&media_id=$_MEDIA_ID_STRING&segment_index=0" --file $_FILE --file-field "media"
		twurl -H upload.twitter.com "/1.1/media/upload.json" -d "command=FINALIZE&media_id=$_MEDIA_ID_STRING"
		
		if [[ -n "$_TWEET_ID" && "$_TWEET_ID" != "null" ]]; then
			twurl -X POST -H api.twitter.com "/1.1/statuses/update.json?status=@$_SCREEN_NAME&in_reply_to_status_id=$_TWEET_ID&media_ids=$_MEDIA_ID_STRING"
			_RANDOM=`shuf -i 180-300 -n 1`
			sleep $_RANDOM;
		else
			if [ $_COUNT -gt 0 ]; then 
				let _COUNT=$_COUNT-`expr length $_SCREEN_NAME` 
				echo -n "@"$_SCREEN_NAME" " >> twsend.list;
			else
				_SEND_LIST=`cat twsend.list`
				twurl -X POST -H api.twitter.com "/1.1/statuses/update.json?status=$_SEND_LIST&media_ids=$_MEDIA_ID_STRING"
				_COUNT=120
				> twsend.list
				_RANDOM=`shuf -i 180-300 -n 1`
				sleep $_RANDOM;
			fi;
		fi;
	fi
	_SEND_LIST=`cat twsend.list`
	twurl -X POST -H api.twitter.com "/1.1/statuses/update.json?status=$_SEND_LIST&media_ids=$_MEDIA_ID_STRING"
	> twsend.list;
done
rm -f /var/www/app/tmp/*
rm -f /var/www/app/uploads/*

