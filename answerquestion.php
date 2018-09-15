<?php
include('dbconn.php');

if(!empty($_COOKIE['username']))
	$_SESSION['value'][0]=$_COOKIE['username'];
if(!empty($_COOKIE['password']))
	$_SESSION['value'][1]=$_COOKIE['password'];
?>
<html>
	<head>
		<title>Ask A Question</title>
		<link rel="stylesheet" type="text/css" href="registerpage.css"/>
		<script type="text/javascript">
		function error(){
			alert('Please Login');
		}
		</script>
	</head>
	<body>
		<div id="wrapper">
		<div id="header">
			<div id="logo">
				<img src="logo.jpg" height="120" width="150">
			</div>
			<div id="title"></div>
			<div id="user">
				  <?php $k=$_SESSION['value'][0];
						$name="SELECT first_name FROM user_details WHERE email='{$k}'";
						$r=$db->query($name) or die($db->error);
						$rws=$r->fetch_array()or die($db->error);
						echo "<br><h3><ul>
									<li>
										Welcome
									</li>
        							<li>".$rws[0]."&#9662;
            								<ul class='dropdown'>
                								<li><a href='profile.php'>Profile</a></li>
                								<li><a href='update.php'>Update</a></li>
            								</ul>
        							</li>
    							</ul></h3>";
					?>
			</div></div>
		<div id="hmid">
			<table width="96%">
				<tr>
					<form action="search.php" method="GET">
					<td width="80"><input type="text" name="query2" placeholder="Search"/><input type="submit" value="Search" /></td>
					</form>
					<td width="120" align="center"><a href="first.php">Home</a></td>
					<td width="120" align="center"><a href="aboutus.php">About Us</a></td>
					<td width="120" align="center"><a href="contactus.php">Contact Us</a></td>
					<?php 
						if(empty($_SESSION['value']))
						echo"<td  width=130 align=right><b><a href='register.php' style='font-size:20'>Sign Up</a></b></td>";
						else
						echo"<td  width=130 align=center><b><a href=logout.php>"."Logout"."</a></b></td>";
					?>
				</tr>
			</table>
		</div>
		<div id="leftpanel">
			<div id="leftm">
				<form>
				<table align="center" width="90%">
					<tr><td align="center"><h2>Categories</h2><hr></td></tr>							
							<?php 
						$sqlll="SELECT category FROM categories";
						$res=$db->query($sqlll) or die($db->error);
						while($rwws=$res->fetch_array())
							echo "<tr><td align='center'><input type='submit' id='catbut' style='height:25px; width:100px;' value='".strtoupper($rwws[0])."' name='".$rwws[0]."'/></td></tr>";
					?>
					<tr><td align="center"><input type="submit" id="catbut" style="height:25px; width:100px;" value=<?php echo strtoupper("others");?> name="others"/></td></tr>
					<?php?>
				</table>
			</form>
			<?php
					$sqlll="SELECT category FROM categories";
						$res=$db->query($sqlll) or die($db->error);
						while($rwws=$res->fetch_array())
				 		{
				 			if(!empty($_REQUEST[$rwws[0]]))
				 			{
				 				$k="".$rwws[0];
				 				header('Location:first.php?id='.$rwws[0].'');
				 			}
				 		}
				 		if(!empty($_REQUEST['others']))
				 			{
				 				$k=""."others";
				 				header('Location:first.php?id='."others".'');
				 			}
			?>
			</div></div>
		<div id="contents">
		<div id="contentsm">
		<p align="center">
			<p align="center">
			<br><br>
			<table cellspacing="40" cellpadding="40">
			<caption><h1><font color="#28285F">Answer A Question</font></h1></caption>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td><b><h2><font color="#28285F">Recent Questions</font></h2></b><hr></td>
				<td></td>
			</tr>
		</table>
			<?php 
				$s="SELECT question_id,question,users_id,category,datetimes FROM questions ORDER BY datetimes DESC";
  				$result=$db->query($s) or die($db->error);
  				while($rws=$result->fetch_array()){
  					$su="SELECT email FROM user_details WHERE users_id='{$rws[2]}'";
  					$res=$db->query($su) or die($db->error);
  					$rw=$res->fetch_array()or die($db->error);
  					echo"<table frame='box' width='80%''>
  							<tr>
  								<td><b>ID:</b>".$rws[0]." <b>| Asked by:</b>".$rw[0]." | "."<b>Category:</b>".$rws[3]." <b> <br>Posted:</b>".$rws[4]."<br><hr><br>";
  					echo "</td></tr>";
  					echo"<tr><td><h3>Q)".$rws[1]."</h3><br></td></tr>";
  					echo "<tr>
						<td><form method='POST' >
							";
							echo "<br></td>
  							</tr></table>";
  							echo "<br><input type='hidden' value='".$rws[0]."' name='uid'/>
							<input type='submit' name='".$rws[0]."' value='Answer' class='button'/></form><br><br><br>";
							if(!empty($_REQUEST[''.$rws[0].''])){
								header('Location:success.php?id='.$rws[0].'');
							}
				}
			?>
		</table></p></p>
		</div></div>
		<div id="rightpanel"><div id="rightm">
			<table align="center" width="90%">
						<tr><td align="center"><h2>Improve your feed</h2><hr></td></tr>
						<tr><td align="center">
						<form method="POST" action="askquestion.php">
						<input type="submit" value="Ask a question" id="catbut" style="height:25px; width:150px;" name="askquestion" <?php if(empty($_SESSION['value'])) echo "onclick='error()'";?>/><form></td></tr>
						<tr><td align="center"><input type="submit" id="catbut" style="height:25px; width:150px;"  value="Answer a question" name="answerquestion"<?php if(empty($_SESSION['value'])) echo "onclick='error()'";?>/></td></tr>
						</form>
						<?php if(!empty($_REQUEST['askquestion'])&&!empty($_SESSION['value']))
									header("Location:askquestion.php");
						?>
						<?php if(!empty($_REQUEST['answerquestion'])&&!empty($_SESSION['value']))
									header("Location:answerquestion.php");
						?>
			</table>
		</div></div></div>
	</body>
</html>