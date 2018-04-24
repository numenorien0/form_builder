<?php

if(isset($_POST['valider']) AND isset($_POST['sendTo']))
{

	$email = "[[EMAIL]]";
	$mail = new PHPMailer(true);
	
	unset($_POST['valider']);
	unset($_POST['sendTo']);
	$html = "";
	$paire = 0;
	foreach($_POST['required'] as $champs)
	{
		$paire++;
		if($paire == 2)
		{
			$paire = 0;
			$html .= $champs."<br/><br/>";
		}
		else
		{
			$html .= "<strong>".$champs."</strong> : ";
		}
		
	}
	
	$paire = 0;
	foreach($_POST['content'] as $champs)
	{
		$paire++;
		if($paire == 2)
		{
			$paire = 0;
			$html .= $champs."<br/><br/>";
		}
		else
		{
			$html .= "<strong>".$champs."</strong> : ";
		}
		
	}	
	
	
	//Typical mail data
	$mail->AddAddress($email);
	$mail->CharSet = 'UTF-8';
	$mail->SetFrom("info@".$_SERVER['HTTP_HOST'], "Site internet");

	
	$mail->Subject = "Message du site internet";
	$mail->IsHTML(true);
	$mail->Body = $html;
	
	try{
	    $mail->Send();
	    echo "<div class='col-sm-12'><div class='col-sm-12' id='successForm'>Message envoyé !</div></div>";
	} catch(Exception $e){
	    //Something went bad
	    echo "<div class='col-sm-12'><div class='col-sm-12' id='errorForm'></div></div>";
	}
	
}
	
?>
<form method='POST' enctype="multipart/form-data" action >
				
[[CONTENT]]				

</form>

