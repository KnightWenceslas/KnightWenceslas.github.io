<?php
/*
	MON PREMIER FORMULAIRE DE CONTACT EN PHP.
	
	auteur: alexandre AT pixeline.be (le script fonctionne. Aucun support n'est fourni, cherche sur internet)
	pour: étudiants DWM
	version: 03.02.2013
	
*/


// POUR VERIFIER CE QU'ENVOIE TON FORMULAIRE, DECOMMENTE LES LIGNES SUIVANTES: (décommenter = enlever les double-slash // et/ou les /* et */ )

/*
echo '<pre>';
print_r($_SERVER);
echo '</pre>';
exit;
*/

// touche pas à ceci
$config = array();

/*
:::::::::::   INSTRUCTIONS    :::::::::::

1.// Dans ton formulaire html, utiliser les champs aux attributs name= "message", "nom", "courriel"
Ces 3 champs seront vérifiés pour validation.

Tout autre champs sera ajouté, sans vérification.


2.// changer les valeurs des variables ci-dessous.
*/

//$config['email']= '';
//$config['sujet']= "Sujet de l'email";
//$config['page_merci']= 'merci.html';
// Messages d'erreur
//$config['no_name']="Veuillez indiquer votre nom";
//$config['no_email']="Veuillez indiquer votre adresse email";
//$config['wrong_email']="Votre adresse email semble être incorrecte. Veuillez corriger svp.";
//$config['no_message']= "Veuillez indiquer votre message";
$config['email']= 'contact@etiennebednarz.fr';
$config['sujet']= "Offre de stage";
$config['page_merci']= 'thanks.html';
 //Messages d'erreur
// NE RIEN TOUCHER CI-DESSOUS
$errors= array();

if(isset($_POST) && count($_POST)>0){

	if(!strpos($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST'])){
		// si la requête ne vient pas de ce serveur, l'interrompre, quelqu'un tente de l'utiliser pour envoyer du spam.
		die("you should'nt be here.");
	}
	
	
	$nom = trim($_POST['nom']);
	$email = trim($_POST['courriel']);
	$message = trim($_POST['message']);


	if(empty($nom)){
		// Le nom a-t-il bien été introduit?
		$errors[]=  $config['no_name'];
	}

	if(empty($message)){
		// Le message a-t-il bien été introduit?
		$errors[]= $config['no_message'];
	}

	if(empty($email)){
		// L'adresse email a-t-elle bien été encodée?
		$errors[]= $config['no_email'];
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		// l'adresse email est-elle valide?
		$errors[]= $config['wrong_email'];
	}


	if(count($errors)<1){

		$message= "$nom ($email) a écrit: \n\r$message";
		
		foreach ($_POST as $k=>$v){
			if (!in_array($k, array('nom','courriel','message'))){
			if(is_array($v)){
				$message.="\n\r$k = ".implode(',', $v);
			}else{
				$message.="\n\r$k = $v";
			}
			}
		}

		$message = wordwrap($message, 70, "\r\n");
		// send the email
		if(empty($config['email'])){
			die("tu as oublié d'encoder l'adresse email, banane. (regarde pour config['email']) dans le code php");
		}
		mail($config['email'], $config['sujet'], $message);
		// redirect to thank you page
		header("Location: ".$config['page_merci']);
		exit;
	}
}
// OK, A PARTIR D'ICI TU PEUX TOUCHER...

// TOUT TON CODE HTML VA CI-DESSOUS
?>
<!DOCTYPE html>
	<html lang="ja">
	<head>
		<title>Contact | E.BEDNARZ | Environement Artist</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1">
		<meta name="description" content="Etienne Bednarz | 3D Environment Artist for video games. " />
		<meta name="keywords" content="Etienne Bednarz, 3D, Environment artist, video game" />
		<meta property="og:title" content="Etienne Bednarz | 3D Environment Artist for video games. ">
		<meta property="og:description" content="M3D Environment Artist for video games.">
		<meta property="og:type" content="Website">
		<meta property="og:url" content="http://etiennebednarz.fr">
		<meta property="og:image" content="http://aetiennebednarz.fr/img/social-network.png">
		<meta property="og:site_name" content="Etienne Bednarz">
		<link rel="stylesheet" type="text/css" href="css/reset.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
		<link rel="shortcut icon" href="img/favicon.png">
	</head>
	<body>
		<header>
			<button class="button-block"><div class="button-nav"></div></button>
			<ul class="language">
				<li><a href="contact.php"class="lang-en">en</a>|</li>
				<li><a href="jp-contact.php" class="lang-jap lang-active">jp</a></li>
			</ul>
			<a href="jp.html" class="titre-site">
				<h1>Bednarz <span class="spacing">Etienne</span><span class="jap">&#12456;&#12481;&#12456;&#12531;&#12492;</span><span class="jap">&#12505;&#12489;&#12490;&#12523;&#12474;</span></h1>
				<h2>Environment Artist </h2>
			</a>
			<nav class="nav">
				<ul class="navigation jap">
					<li><a class="content-actif" href="jp.html">&#12509;&#12540;&#12488;&#12501;&#12457;&#12522;&#12457;</a></li>
					<li><a href="jp-resume.html">&#12524;&#12472;&#12517;&#12540;&#12512;</a></li>
					<li><a href="jp-contact.php"> &#12467;&#12531;&#12479;&#12463;&#12488;</a></li>
				</ul>
			</nav>
		</header>
		<div class="wrapper">
			<form action="contact.php" method="post">
				<?php
					// if form has been submitted, show the errors
					if($_POST && count($errors)>0){
					?>
						<div id="error">
	                        <p>There is an error ! </br> Check all your informations</p>
	                        <ul>
	                            <?php
	                            foreach($errors as $e){
	                                echo "<li>$e</li>";
	                            }
	                            ?>
	                        </ul>
	                    </div>
					<?php
	                    }
	        ?>
				<h3 class="contact">Say 'Hello'</h3>
             	<input type="text" class="nom first" placeholder="Firstname" name="firstname" data-label="Name">
			    <input type="text" class="nom" placeholder="Lastname" name="nom" data-label="nom">
			    <input type="text" class="email first" placeholder="Email" name="courriel" data-label="e-mail">
			    <textarea class="message" placeholder="Hello Etienne," name="message"></textarea>
            	<input type="submit" class="button" name="send" value="Send">
       		</form>
       		<p class="mailto">Or send me an <a class="mailto-link" href="mailto:contact@etiennebednarz.fr">email</a></p>
		</div>
		<footer>
			<p>© All rights reserved | 2015 | By <a href="http://www.audreyrobic.be" target='_blank'>Audrey  Robic</a></p>
		</footer>
		<script>
		buttonBlock = document.getElementsByClassName("button-block"),
	      	buttonNav = document.getElementsByClassName("button-nav"),
	      	langen = document.getElementsByClassName("lang-en"),
	      	language = document.getElementsByClassName("language"),
	      	nav = document.getElementsByClassName("nav");
	      
	      	buttonBlock[0].addEventListener("click", function(){
	        nav[0].classList.toggle("nav-mobile");
	        language[0].classList.toggle("color-lang");
	        langen[0].classList.toggle("color-lang");
	      	});
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-64553737-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
	</html>