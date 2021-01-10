<html>
 <head>
  <title>TweetPic</title>
  <script async custom-element="amp-auto-ads"
        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
  </script>
 </head>
 <body>
 	
	<form action="upload.php" method="post" enctype="multipart/form-data">
    		Select image to upload:
    		<input type="file" name="fileToUpload" id="fileToUpload">
		<br>
		<br>
		Please input the Screen  Name: 
			<input type="text" name="screenname">
		<br>
		<br>
			<input type="radio" name="radio" value="TimeLine" id="Time_Line" />
			<label for="Time_Line">Time Line</label>
		<p style="text-align: center;"><img style="float: left;" src="/images/Twitter_p.png" alt="" width="60" height="60" /></p>
		<p>&nbsp;</p>
		<p>从目标对象的时间线上获取相关的互动推特用户，并将图片推送给这部分用户</p>
		<hr>
		
			<input type="radio" name="radio" value="1000Followers"id="1000_Followers" />
			<label for="1000_Followers">1000 Followers</label>
		<p style="text-align: center;"><img style="float: left;" src="/images/Twitter_w.png" alt="" width="60" height="60" /></p>
		<p>&nbsp;</p>
		<p>从目标对象的跟随者中获取1000个用户，并将图片推送给这部分用户</p>
			
		<br>
		<br>
			<input type="submit" value="Submit" name="submit">
	</form>
 
 </body>
</html>
