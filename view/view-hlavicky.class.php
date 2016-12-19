<?php
class ViewHlavicky{
	
	/**
	 * Vytvoří hlavičku, menu, nepřihlášenému uživateli nabídne se přihlásit a přihlášenému odhlásit
	 * @return string hlavička
	 */
	
	public static function getHTMLHeader(){
		if(isset($_SESSION["user"])){ // je někdo přihlášen?
			if($_SESSION["user"]["kupilik_prava_idkupilik_prava"] == 1){ // přihlášen administrátor
				return "<!doctype html><html>
		<head>
		<title>Konferenční systém</title>
		<meta charset='utf-8'>
		<link rel='stylesheet' href='./css/rozlozeni.css'>
		</head>
		<body>
			<div class='header'>
 			 <h1>Konferenční systém</h1>
		    </div>
			<div class='row'>
			<div class='col-3 menu'>
			<ul>
			<li><a href='index.php?web=prihlaseni'>Odhlásit ".$_SESSION['user']['login']."</a></li>
			<li><a href='index.php?web=uvod'>Úvod</a></li>
			<li><a href='index.php?web=registrace'>Registrace</a></li>
			<li><a href='index.php?web=novyPrispevek'>Vložit příspěvek</a></li>
			<li><a href='index.php?web=prispevky'>Příspěvky</a></li>
			<li><a href='index.php?web=uzivatele'>Uživatelé</a></li>
			</ul>
			</div>";
			}else{ 
			return "<!doctype html><html>
		<head>
		<title>Konferenční systém</title>
		<meta charset='utf-8'>
		<link rel='stylesheet' href='./css/rozlozeni.css'>
		</head>
		<body>
			<div class='header'>
 			 <h1>Konferenční systém</h1>
		    </div>
			<div class='row'>
			<div class='col-3 menu'>
			<ul>
			<li><a href='index.php?web=prihlaseni'>Odhlásit ".$_SESSION['user']['login']."</a></li>
			<li><a href='index.php?web=uvod'>Úvod</a></li>
			<li><a href='index.php?web=registrace'>Registrace</a></li>
			<li><a href='index.php?web=novyPrispevek'>Vložit příspěvek</a></li>
			<li><a href='index.php?web=prispevky'>Příspěvky</a></li>
					
			</ul>
			</div>";
			}
		}else{
			
		return "<!doctype html><html>
		<head>
		<title>Konferenční systém</title>
		<meta charset='utf-8'>
		<link rel='stylesheet' href='./css/rozlozeni.css'>
		</head>
		<body>
			<div class='header'>
 			 <h1>Konferenční systém</h1>
		    </div>
			<div class='row'>
			<div class='col-3 menu'>
			<ul>
			<li><a href='index.php?web=uvod'>Úvod</a></li>
			<li><a href='index.php?web=prihlaseni'>Přihlášení</a></li>
			<li><a href='index.php?web=registrace'>Registrace</a></li>
			<li><a href='index.php?web=novyPrispevek'>Vložit příspěvek</a></li>
			<li><a href='index.php?web=prispevky'>Příspěvky</a></li>
			</ul>
			</div>";
		}
	}
	
	public static function getHTMLFooter() {
		return "</div>
				</body>
               </html>";
	}
}