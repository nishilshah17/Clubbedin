<?php
header("access-control-allow-origin: *");

include 'mysqlconnect.php';

$dbserver = mysql_connect($dbhost, $dbuser, $dbpass)
    or die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db)
    or die("Unable to select database: " . mysql_error());

$userID = $_POST['id'];
$clubID = $_POST['clubID'];
$type = $_POST['type'];
$delAtt = $_POST['delAtt'];

$result2 = mysql_query('SELECT * FROM clubs WHERE clubID = "'.$clubID.'"');
$result3 = mysql_query('SELECT * FROM user WHERE userID = "'.$userID.'"');
$row2 = mysql_fetch_assoc($result2);
$row3 = mysql_fetch_assoc($result3);

$clubName = $row2['clubName'];
$email = $row3['email'];
$name = $row3['name'];

mysql_query('DELETE FROM clubmember WHERE userID = "'.$userID.'" AND clubID = "'.$clubID.'"');

$message = "You have been removed from ".$clubName.".";

if($type == 2) {
	mysql_query('INSERT INTO banned (userID, clubID) VALUES ("'.$userID.'", "'.$clubID.'")');
	$message = "You have been banned from".$clubName.".";
}

$message2 = "";

if($delAtt == 1)
{
	echo $clubID;

	$result = mysql_query('SELECT * FROM events WHERE clubID = "'.$clubID.'"');

	echo $result;

	while ($row = mysql_fetch_assoc($result))
	{
		$eventID = $row['eventID'];

		mysql_query('DELETE FROM eventmember WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
		mysql_query('DELETE FROM eventmember2 WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
		mysql_query('DELETE FROM eventmember3 WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');

		mysql_query('DELETE FROM attendance WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
		mysql_query('DELETE FROM attendance2 WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');
		mysql_query('DELETE FROM attendance3 WHERE userID = "'.$userID.'" AND eventID = "'.$eventID.'"');

		$message2 = " All your attendance records for ".$clubName." have been deleted as well.";

	}
}

require_once('class.phpmailer.php');

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 1;
$mail->CharSet="UTF-8";
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->Username = 'clubbedinapp@gmail.com';
$mail->Password = 'ClubbedIn2013';
$mail->SMTPAuth = true;

$mail->From = 'clubbedinapp@gmail.com';
$mail->FromName = 'Clubbed In';
$mail->AddAddress($email);
$mail->AddReplyTo('clubbedinapp@gmail.com', 'Clubbed In');

$mail->IsHTML(true);
$mail->Subject    = "Removed From: ".$clubName;
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
$mail->Body    = " <!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html><head><title></title><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><meta name='viewport' content='width=320, target-densitydpi=device-dpi'>
<style type='text/css'>
/* Mobile-specific Styles */
@media only screen and (max-width: 660px) {
table[class=w0], td[class=w0] { width: 0 !important; }
table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }
table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }
table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }
table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }
table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }
table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }
table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }
table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }
table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }
table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }
table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }
table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }
table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }
table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }
table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }
table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }
table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }
table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }
table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }
table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }
table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
table[class=w640], td[class=w640], img[class=w640] { width:101px !important; }
table[class=w690], td[class=w690], img[class=w690] { width:300px !important; }
table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }
table[class=h0], td[class=h0] { height: 0 !important; }
p[class=footer-content-left] { text-align: center !important; }
#headline p { font-size: 30px !important; }
.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }
.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}
img { height: auto; line-height: 100%;}
 }
/* Client-specific Styles */
#outlook a { padding: 0; }	/* Force Outlook to provide a 'view in browser' button. */
body { width: 100% !important; }
.ReadMsgBody { width: 100%; }
.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width */
/* Reset Styles */
/* Add 100px so mobile switch bar doesn't cover street address. */
body { background-color: #4d4d4d; margin: 0; padding: 0; }
img { outline: none; text-decoration: none; display: block;}
br, strong br, b br, em br, i br { line-height:100%; }
h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {	color: red !important; }
/* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }
/* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */
table td, table tr { border-collapse: collapse; }
.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;
}	/* Body text color for the New Yahoo.  This example sets the font of Yahoo's Shortcuts to black. */
/* This most probably won't work in all email clients. Don't include code blocks in email. */
code {
  white-space: normal;
  word-break: break-all;
}
#background-table { background-color: #4d4d4d; }
/* Webkit Elements */
#top-bar { border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #1682e0; color: #ffffff; }
#top-bar a { font-weight: bold; color: #ffffff; text-decoration: none;}
#footer { border-radius:0px 0px 6px 6px; -moz-border-radius: 0px 0px 6px 6px; -webkit-border-radius:0px 0px 6px 6px; -webkit-font-smoothing: antialiased; }
/* Fonts and Content */
body, td { font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; }
.header-content, .footer-content-left, .footer-content-right { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
/* Prevent Webkit and Windows Mobile platforms from changing default font sizes on header and footer. */
.header-content { font-size: 12px; color: #ffffff; }
.header-content a { font-weight: bold; color: #ffffff; text-decoration: none; }
#headline p { color: #de0000; font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif; font-size: 36px; text-align: center; margin-top:0px; margin-bottom:30px; }
#headline p a { color: #de0000; text-decoration: none; }
.article-title { font-size: 18px; line-height:24px; color: #de0303; font-weight:bold; margin-top:0px; margin-bottom:18px; font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; }
.article-title a { color: #de0303; text-decoration: none; }
.article-title.with-meta {margin-bottom: 0;}
.article-meta { font-size: 13px; line-height: 20px; color: #ccc; font-weight: bold; margin-top: 0;}
.article-content { font-size: 13px; line-height: 18px; color: #000000; margin-top: 0px; margin-bottom: 18px; font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif; }
.article-content a { color: #0091ff; font-weight:bold; text-decoration:none; }
.article-content img { max-width: 100% }
.article-content ol, .article-content ul { margin-top:0px; margin-bottom:18px; margin-left:19px; padding:0; }
.article-content li { font-size: 13px; line-height: 18px; color: #000000; }
.article-content li a { color: #0091ff; text-decoration:underline; }
.article-content p {margin-bottom: 15px;}
.footer-content-left { font-size: 12px; line-height: 15px; color: #ffffff; margin-top: 0px; margin-bottom: 15px; }
.footer-content-left a { color: #ffffff; font-weight: bold; text-decoration: none; }
.footer-content-right { font-size: 11px; line-height: 16px; color: #ffffff; margin-top: 0px; margin-bottom: 15px; }
.footer-content-right a { color: #ffffff; font-weight: bold; text-decoration: none; }
#footer { background-color: #1682E0; color: #ffffff; }
#footer a { color: #ffffff; text-decoration: none; font-weight: bold; }
#permission-reminder { white-space: normal; }
#street-address { color: #ffffff; white-space: normal; }
.clean{
        color:white;
        }
h2 { width:100%; text-align:center; border-bottom: 1px solid #000; line-height:0.1em; margin:10px 0 20px; }
h2 span { background:#fff; padding:0 10px; }</style>

</head><body><table width='100%' cellpadding='0' cellspacing='0' border='0' id='background-table'>
	<tbody><tr>
		<td align='center' bgcolor='#4d4d4d'>
        	<table class='w640' style='margin:0 10px;' width='640' cellpadding='0' cellspacing='0' border='0'>
            	<tbody><tr><td class='w690' width='640' height='20'></td></tr>

            	<tr>
                	<td class='w690' width='640'>
                        <table id='top-bar' class='w690' width='640' cellpadding='0' cellspacing='0' border='0' bgcolor='#000000'>
    <tbody><tr>
        <td class='w15' width='15'></td>
        <td class='w325' width='350' valign='middle' align='left'>
            <table class='w325' width='350' cellpadding='0' cellspacing='0' border='0'>
                <tbody><tr><td class='w325' width='350' height='8'></td></tr>
            </tbody></table>
            <div class='header-content'>Clubbed In &copy;</div>
            <table class='w325' width='350' cellpadding='0' cellspacing='0' border='0'>
                <tbody><tr><td class='w325' width='350' height='8'></td></tr>
            </tbody></table>
        </td>
        <td class='w30' width='30'></td>
        <td class='w255' width='255' valign='middle' align='right'>
            <table class='w255' width='255' cellpadding='0' cellspacing='0' border='0'>
                <tbody><tr><td class='w255' width='255' height='8'></td></tr>
            </tbody></table>
            <table cellpadding='0' cellspacing='0' border='0'>
    <tbody><tr>
        <td class='w10' width='10'></td>
        <td valign='middle'></td>
        <td width='3'></td>
        <td valign='middle'></td>
    </tr></tbody>
    </table>
            <table class='w255' width='255' cellpadding='0' cellspacing='0' border='0'>
                <tbody><tr><td class='w255' width='255' height='8'></td></tr>
            </tbody></table>
        </td>
        <td class='w15' width='15'></td>
    </tr>
</tbody></table>

                    </td>
                </tr>
                <tr>
                <td id='header' class='w640' width='640' align='center' bgcolor='#FFFFFF'>

    <div align='center' style='text-align: center'>
        <img id='customHeaderImage' label='Header Image' width='32' height='32' src='http://clubbedin.x10host.com/images/logo.png' class='w640' border='0' align='top' style='display: inline'>
    </div>


</td>
                </tr>

                <tr><td class='w640' width='640' height='30' bgcolor='#ffffff'></td></tr>
                <tr id='simple-content-row'><td class='w640' width='640' bgcolor='#ffffff'>
    <table class='w690' width='640' cellpadding='0' cellspacing='0' border='0'>
        <tbody><tr>
            <td class='w30' width='30'></td>
            <td class='w580' width='580'>
                <repeater>
                    <layout label='Text only'>
                        <table class='w580' width='580' cellpadding='0' cellspacing='0' border='0'>
                            <tbody><tr>
                                <td class='w580' width='580'>
                                    <p align='center' class='article-title'><singleline label='Title'>Hello $name</singleline></p>
                                    <div align='center' class='article-content'>
                                        <multiline label='Description'>

												<br>
												From <b>Clubbed In</b>
                                        </multiline>

                                    </div>
                                </td>
                            </tr>
                            <tr><td class='w580' width='580' height='10'></td></tr>
                        </tbody></table>
                    </layout>
                </repeater>
            </td>
            <td class='w30' width='30'></td>
        </tr>
    </tbody></table>
</td></tr>
                <tr><td class='w640' width='640' height='15' bgcolor='#FFFFFFF'></td></tr>

                <tr>
                <td class='w640' width='640'>
    <table id='footer' class='w690' width='640' cellpadding='0' cellspacing='0' border='0' bgcolor='#1682E0'>
        <tbody><tr><td class='w30' width='30'></td><td class='w580 h0' width='360' height='30'></td><td class='w0' width='60'></td><td class='w0' width='160'></td><td class='w30' width='30'></td></tr>
        <tr>
            <td class='w30' width='30'></td>
            <td class='w580' width='360' valign='top'>
            <span class='hide'><p id='permission-reminder' align='left' class='footer-content-left'><span></span></p></span>
            </td>
            <td class='hide w0' width='60'></td>
            <td class='hide w0' width='160' valign='top'>
            <p id='street-address' align='right' class='footer-content-right'></p>
            </td>
            <td class='w30' width='30'></td>
        </tr>
        <tr><td class='w30' width='30'></td><td class='w580 h0' width='360' height='15'></td><td class='w0' width='60'></td><td class='w0' width='160'></td><td class='w30' width='30'></td></tr>
    </tbody></table>
</td>
                </tr>
                <tr><td class='w690' width='640' height='60'></td></tr>
            </tbody></table>
        </td>
	</tr>
</tbody></table></body></html>
 ";


if(!$mail->Send())
{
  echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
  echo "Message sent!";
}



?>