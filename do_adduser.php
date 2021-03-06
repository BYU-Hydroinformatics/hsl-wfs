<?php

//This is required to get the international text strings dictionary
require_once 'internationalize.php';

//check for required fields
if ((!$_POST['firstname']) || (!$_POST['lastname']) || (!$_POST['username']) || (!$_POST['password']) || (!$_POST['authority'])) {
	header("Location: adduser.php");
	exit;
}

//check authority to be here
require_once 'authorization_check.php';

//All queries go through a translator. 
require_once 'DBTranslator.php';

//add the user's data
$sql ="INSERT INTO moss_users(firstname, lastname, username, password, authority) VALUES ('$_POST[firstname]', '$_POST[lastname]', '$_POST[username]', PASSWORD('$_POST[password]'), '$_POST[authority]')";

$result = transQuery($sql,0,-1);

//get a good message for display upon success
if ($result){ 

$msg = "<p class=em2> $Congrats  $_POST[firstname].  $AddAnother  </p>";
	}


//Display the appropriate user authority to add depending on the user's authority
if ($_COOKIE[power] == "admin"){
	$selection = "<select name=authority id=authority><option value=>".$SelectEllipsis."</option><option value=admin>".$Administrator."</option><option value=teacher>".$Teacher."</option><option value=student>".$Student."</option></select>";	
	}
elseif ($_COOKIE[power] == "teacher"){
	$selection = "<select name=authority id=authority><option value=>".$SelectEllipsis."</option><option value=teacher>".$Teacher."</option><option value=student>".$Student."</option></select>";
	}
elseif ($_COOKIE[power] == "student"){
	header("Location: unauthorized.php");
	exit;	
	}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $WebClient; ?></title>

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="bookmark" href="favicon.ico" >
<link href="styles/main_css.css" rel="stylesheet" type="text/css" media="screen" />
<!-- JQuery JS -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script> 

<script type="text/javascript" src="js/create_username.js"></script>
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
    <td width="720" valign="top" bgcolor="#FFFFFF"><blockquote><br /><p class="em" align="right"><!--Required fields are marked with an asterick (*).--><?php echo $RequiredFieldsAsterisk;?></p><?php echo "$msg"; ?>
      <!--<h1>Add a New User</h1>-->
	  <h1><?php echo $AddNewUser; ?></h1>
      <p>&nbsp;</p>
      <FORM METHOD="POST" ACTION="do_adduser.php">
      <table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <!--td width="95" valign="top"><strong>First Name:</strong></td>-->
		  <td width="95" valign="top"><strong><?php echo $FirstName; ?></strong></td>
          <td width="153" valign="top"><input type="text" name="firstname" size=25 maxlength=50 onBlur="GetFirstLetter()" /></td>
          <td width="352" valign="top">*</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td width="153" valign="top">&nbsp;</td>
          <td width="352" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <!--<td width="95" valign="top"><strong>Last Name:</strong></td>-->
		  <td width="95" valign="top"><strong><?php echo $LastName; ?></strong></td>
          <td valign="top"><input type="text" name="lastname" size=25 maxlength=50 onBlur="GetLastName()" /></td>
          <td valign="top">*</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <!--<td width="95" valign="top"><strong>Username:</strong></td>-->
		  <td width="95" valign="top"><strong><?php echo $UserName; ?></strong></td>
          <td valign="top"><input type="text" name="username" size=25 maxlength=25 />
          <div class="em"></div></td>
          <!--<td valign="top"><span class="em">*&nbsp;(First initial and last name; ex: &quot;jdoe&quot; for John Doe)</span></td>-->
		  <td valign="top"><span class="em">*&nbsp;<?php echo $FirstLastNameExample; ?></span></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <!--<td width="95" valign="top"><strong>Password:</strong></td>-->
		  <td width="95" valign="top"><strong><?php echo $Password; ?></strong></td>
          <td valign="top"><input type="text" name="password" size=25 maxlength=25 /><div class="em"></div></td>
          <!--<td valign="top"><span class="em">*&nbsp;(Case sensitive; enter 6-8 characters)</span></td>-->
          <td valign="top"><span class="em">*&nbsp; <?php echo $CaseSensitive; ?></span></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <!--<td width="95" valign="top"><strong>Authority:</strong></td>-->
		  <td width="95" valign="top"><strong><?php echo $Authority; ?> </strong></td>
          <td valign="top"><?php echo "$selection"; ?>*</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="95" valign="top">&nbsp;</td>
          <td valign="top"><input type="SUBMIT" name="submit" value="<?php echo $AddUser;?>" class="button"/></td>
          <td valign="top">&nbsp;</td>
          
        </tr>
      </table></FORM>
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
