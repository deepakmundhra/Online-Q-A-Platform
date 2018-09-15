<?php
include('dbconn.php');
$db = new mysqli('localhost','root','','project')
or die($db->connect_error);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Register Page</title>
<link rel="stylesheet" type="text/css" href="registerpage.css"/>
<script type="text/javascript">
function Submit(){
	var emailRegex = /^[A-Za-z0-9._]*\@[A-Za-z]*\.[A-Za-z]{2,5}$/;
	var fname = document.form.first_name.value,
		lname = document.form.last_name.value,
		femail = document.form.email.value,
		freemail = document.form.enteremail.value,
		fpassword = document.form.password.value,
		fbirthday = document.form.dob.value;	
	if( fname == "" )
   {document.form.first_name.focus() ;
	 document.getElementById("errorBox").innerHTML = "Enter Your First Name";
     return false;}
	if( lname == "" )
   {document.form.last_name.focus() ;
	  document.getElementById("errorBox").innerHTML = "Enter Your Last Name";
     return false;}
   if (femail == "" )
	{document.form.email.focus();
		document.getElementById("errorBox").innerHTML = "Enter Your Email";
		return false;}
		else if(!emailRegex.test(femail)){
		document.form.email.focus();
		document.getElementById("errorBox").innerHTML = "enter the valid email";
		return false;}
	  if (freemail == "" )
	{document.form.enteremail.focus();
		document.getElementById("errorBox").innerHTML = "Re-enter the email";
		return false;
	 }else if(!emailRegex.test(freemail)){
		document.form.enteremail.focus();
		document.getElementById("errorBox").innerHTML = "Re-enter the valid email";
		return false;}
	 if(freemail !=  femail){
		 document.form.enteremail.focus();
		 document.getElementById("errorBox").innerHTML = "emails are not matching, re-enter again";
		 return false; }
	if(fpassword == "")
	 { document.form.password.focus();
		 document.getElementById("errorBox").innerHTML = "enter the password";
		 return false;}
	 if (fbirthday == "") {
        document.form.dob.focus();
		document.getElementById("errorBox").innerHTML = "select the birthday year";
        return false; }
	if(document.form.gender[0].checked == false && document.form.gender[1].checked == false){
				document.getElementById("errorBox").innerHTML = "select your gender";
			 return false;
			}		  
}
</script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<div id="logo">
				<img src="logo.jpg" height="120" width="150">
			</div></div>
		<div id="hmid">
			<table width=96%>
				<tr>
					<td width=120 align=right><a href="first.php">Home</a></td>
					<td width=120 align=right><font color="white"><a href="aboutus.php">About Us</a></font></td>
					<td width=120 align=right><font color="white"><a href="contactus.php">Contact Us</a></font></td>
					<td width=130 align=right><b><a href="register.php" style="font-size:20">Sign Up</a></b></td>
				</tr>
			</table>
		</div>
		<div id="leftpanel"></div>
		<div id="contents">
			<div id="container">
				<div id="aboutme">
				<p align="centre"><h1><font color="#28285F">Sign Up</font></h1></p>
				</div>
  				<div id="container_body">
    				<div id="form_name">
      					<div class="firstnameorlastname">
       					<form name="form" method="post">
       						<div id="errorBox"></div>
        						<input type="text" name="first_name" value="" placeholder="First Name"  class="input_name" >
        						<input type="text" name="last_name" value="" placeholder="Last Name" class="input_name" >
      					</div>
      					<div id="email_form">
        					<input type="text" name="email" value=""  placeholder="Your Email" class="input_email">
      					</div>
      					<div id="Re_email_form">
        					<input type="text" name="enteremail" value=""  placeholder="Re-enter Email" class="input_Re_email">
      					</div>
      					<div id="password_form">
        					<input type="password" name="password" value=""  placeholder="New Password" class="input_password">
      					</div>
      					<div id="birthday"><p align="center">
      						<h3>Date of Birth:</h3>
        					<input type="date" name="dob" value=""  placeholder="Your Date of Birth" class="input_dob"></p>
      					</div>
      					<div id="radio_button">
        					<input type="radio" name="gender" value="Male">
        					<label >Male</label>
        					&nbsp;&nbsp;&nbsp;
        					<input type="radio" name="gender" value="Female">
        					<label >Female</label></p>
      					</div>
      					<br><br>
       					<div>
         				<input type="submit" id="sign_user" onClick="return Submit()" value="Register" name="sign_user"/>
      					</div>
     					</form>
    				</div></div></div>
		<?php
  			if(!empty($_REQUEST['sign_user']))
  			{
  				$fname=$_REQUEST['first_name'];
				$lname=$_REQUEST['last_name'];
				$mail=$_REQUEST['email'];
				$pass=md5($_REQUEST['password']);
				$gen=$_REQUEST['gender'];
				$birth=$_REQUEST['dob'];
				$sql = "INSERT INTO user_details VALUES('','{$fname}','{$lname}','{$gen}','{$birth}','{$mail}','{$pass}','','','','','')";
				$db->query($sql) or die($db->error);
				if($db->affected_rows==1)
				{	echo "<p align='center'>";
					echo "Successfully Registered"."<br>";
					echo "Please <a href='first.php' style='color:blue'>Login</a> with your Details";
					echo "</p>";}
				else
					echo "No record has been inserted";
			}
		?>
		</div></div>
	<div id="rightpanel"></div>
</div>
</body>
</html>