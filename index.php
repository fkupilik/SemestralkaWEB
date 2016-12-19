<?php

// dostupne stranky
$possible = array (
		"uvod",
		"registrace",
		"prihlaseni",
		"novyPrispevek",
		"prispevky",
		"uzivatele"
);
// kontrolery danych stranek
$controllers = array (
		"View/view-uvod.class.php",
		"Controllers/con-registrace.class.php",
		"Controllers/con-prihlaseni.class.php",
		"Controllers/con-vlozPrispevek.class.php",
		"Controllers/con-prispevky.class.php",
		"Controllers/con-uzivatele.class.php"
);
// objekty danych kontroleru
$objects = array (
		"ViewUvod",
		"ConRegistrace",
		"ConPrihlaseni",
		"ConVlozPrispevek",
		"ConPrispevky",
		"ConUzivatele"
);

session_start ();

// klasicke URL
if (isset ( $_GET ["web"] ) && in_array ( $_GET ["web"], $possible )) {
	$input = $_GET ["web"];
} else {
	$input = "uvod";
}

// hezke URL - jen mozny nastin - nutno dopracovat
// $url=strip_tags($_SERVER['REQUEST_URI']);
// $urlAr=explode("/",$url);
// echo $url;

// mam vstup?
if (isset ( $input )) {
	// vstup je spravny
	// ziskam index stranky
	$i = array_search ( $input, $possible );
	// ziskam spravnou stranku
	$web = $controllers [$i];
	// includuji
	include ($web);
	// vytvorim odpovidajici kontroler
	$con = new $objects [$i] ();
	// ziskam vysledek kontroleru
	$result = $con->getResult ();
	// vypisu vysledek, tj. zobrazim web
	echo $result;
} else {
	// vstup neni spravny - pouze vypisu mini HTML
	echo "<html><head><meta charset='utf-8'></head><body>str�nka nen� dostupn�</body></html>";
}

?>