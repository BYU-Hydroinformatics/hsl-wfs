<?php
//This is required to get the international text strings dictionary
require_once 'internationalize.php';

//check authority to be here
require_once 'authorization_check.php';

//redirect anyone that is not an administrator
if ($_COOKIE[power] !="admin"){
	header("Location: index.php?state=pass2");
	exit;	
	}

//check for required fields
if ((!$_POST['username']) || (!$_POST['authority'])) {
	header("Location: changeauthority.php");
	exit;
}

//All queries go through a translator. 
require_once 'DBTranslator.php';

//add the user's data
$sql ="UPDATE moss_users SET authority='$_POST[authority]' WHERE username='$_POST[username]'";

$result = transQuery($sql,0,-1);

//get a good message for display upon success
if ($result) {
$msg ="<p class=em2> $CongratulationsChanged. $_POST[username]. $AddAnother</p>";
}

//add the user's data
$sql2 ="Select username FROM moss_users WHERE (authority='teacher' OR authority='student') ORDER BY username";

$result2 = transQuery($sql2,0,0);
$num = count($result2);
	if ($num < 1) {
		$msg2 = "<P><em2> $SorryNoUsers </em></p>";
	} else {
	foreach ($result2 as $row) {
		$users = $row["username"];
		$option_block .= "<option value=$users>$users</option>";
		}
	}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<title>HydroServer Lite Web Client</title>-->
<title><?php echo $WebClient; ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="bookmark" href="favicon.ico" >
<link href="styles/main_css.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script> 
</head>

<body background="images/bkgrdimage.jpg">
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><?php include "topBanner.php" ; ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right" valign="middle" bgcolor="#3c3c3c"><?php require_once 'header.php'; ?></td>
  </tr>
  <tr>
    <td width="240" valign="top" bgcolor="#f2e6d6"><?php echo "$nav"; ?></td>
    <!--<td width="720" valign="top" bgcolor="#FFFFFF"><blockquote><br /><p class="em" align="right">Required fields are marked with an asterick (*).</p><?php echo "$msg $msg2"; ?>-->
	<td width="720" valign="top" bgcolor="#FFFFFF"><blockquote><br /><p class="em" align="right"><?php echo $RequiredFieldsAsterisk; ?></p><?php echo "$msg $msg2"; ?>
      <!--<h1>Change a User's Authority</h1>-->
	  <h1><?php echo $ChangeUserAuthority; ?></h1>
      <p>&nbsp;</p>
      <form method="post" action="do_changeauthority.php">
        <table width="300" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <!--<td width="95" valign="top"><strong>Username:</strong></td>-->
			<td width="95" valign="top"><strong><?php echo $UserName; ?></strong></td>
            <!--<td width="205" valign="top"><select name="username" id="username"><option value="">Select a username....</option><?php echo "$option_block"; ?></select>*</td>-->
			<td width="205" valign="top"><select name="username" id="username"><option value=""><?php echo $SelectUsernameEllipisis ?></option><?php echo "$option_block"; ?></select>*</td>
          </tr>
          <tr>
            <td width="95" valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <!--<td valign="top"><strong>New Authority:</strong></td>-->
			<td valign="top"><strong><?php echo $NewAuthority; ?></strong></td>
            <td valign="top"><select name="authority" id="authority">
              <option value=""><?php $SelectLevel; ?></option>			  
              <option value="admin"><?php echo $Administrator; ?></option>
              <option value="teacher"><?php echo $Teacher; ?></option>
              <option value="student"><?php echo $Student;?></option></select>*</td>
              <!--<option value="">Select a level....</option> 
               <option value="admin">Administrator</option>
               <option value="teacher">Teacher</option>
               <option value="student">Student</option></select>*</td>-->
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <!--<td valign="top"><input type="submit" name="submit2" value="Change Authority" class="button" style="width: 145px" /></td>-->
            <td valign="top"><input type="submit" name="submit2" value="<?php echo $ChangeAuthorityButton; ?>" class="button" style="width: auto" /></td>
          </tr>
        </table>
</form>
<p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </blockquote>
    <p></p></td>
  </tr>
  <tr>
    <script src="js/footer.js"></script>
  </tr>
</table>
</body>
</html>