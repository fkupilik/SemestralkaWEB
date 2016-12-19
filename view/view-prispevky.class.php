<?php
class ViewPrispevky{
	public function __construct(){
		
	}
	
	/***
	 * Zobrazí příspěvky, které vytvořil přihlášený uživatel s právy autora
	 * @param unknown $zprava Příspěvky k zobrazení
	 * @return string html k zobrazení
	 */
	public static function getTemplateAutor($zprava){
		include ("View/view-hlavicky.class.php");
		if($zprava == null){
			$text = '<div class="col-9">
					<h1>Nejsou vloženy žádné příspěvky!</h1>
					</div>';
		}else{
			$text = '
				<div class="col-9">
				<div class="tabulkaPrispevky">
					
				<table>
					<tr>
						<th>Název</th>
						<th>Upravit</th>
						<th>Smazat</th>
						<th>Ve stavu</th>
						<th>Hodnocení</th>
					</tr>';
			foreach ($zprava as $prispevek){
				$nazev = $prispevek["nazev"];
				$prispevekID = $prispevek["idkupilik_prispevky"];
				$text .= '
						<tr>
							<td>'.$nazev.'</td>
				<td>
				<form action="index.php?web=prispevky" method="POST">
						<input type="hidden" name="userId" value="'.$prispevekID.'">
						<input type="submit" name="uprav" value="Upravit">
				</form>
				</td>
				<td>
						<form action="index.php?web=prispevky" method="POST">
						<input type="hidden" name="userId" value="'.$prispevekID.'">
						<input type="submit" name="smaz" value="Odstranit">
				</form>
				</td>
						';
				
				if($prispevek["publikovano"] == 2){
					$text .= '
							<td>Odmítnuto</td>
							
							';
					
					$text .= '
						<td><form action="index.php?web=prispevky" method="POST">
						<input type="hidden" name="prispevekId" value="'.$prispevekID.'">
						<input type="submit" name="hodnoceni" value="Zobraz hodnocení">
						</form>
						</td>
						</tr>
						';
				}else if($prispevek["publikovano"] == 1){
					$text .= '
							<td>Přijato</td>
							
							';
					
					$text .= '
						<td><form action="index.php?web=prispevky" method="POST">
						<input type="hidden" name="prispevekId" value="'.$prispevekID.'">
						<input type="submit" name="hodnoceni" value="Zobraz hodnocení">
						</form>
						</td>
						</tr>
						';
				}else{
					$text .= '
							<td>V recenzním řízení</td>
							</tr>
							';
				}
		}
		$text .= '
				</table>
				</div>
				</div>';
			
		}
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}

	
	/***
	 * Zobrazí přihlášenému recenzentovi formulář k hodnocení příspěvku
	 * @param array $zprava Hodnocení, které recenzent upravuje
	 * @param array $prispevek Příspěvek, který recenzent hodnotí
	 * @return string html k zobrazení
	 */
	public static function getTemplateHodnoceni($zprava, $prispevek){

		include ("View/view-hlavicky.class.php");
		$text = '
		
				<div class="col-9">
				<h1>Hodnocení příspěvku</h1>
				<h3>Název příspěvku: '.$prispevek["nazev"].'</h3>
				<h3><a href=uploads/'.$prispevek["nazevSouboru"].' target="_blank">Soubor ke stažení</a></h3>
		
				<form action="index.php?web=prispevky" method="POST">
		
					<table>
						<tr>
						<td>Originalita:</td>
						<td><select name="originalita">
							<option value="1">1 - Žádná originální myšlenka</option>
							<option value="2">2 - Pouze pár originálních myšlenek</option>
							<option value="3">3 - Větší množství originálních myšlenek</option>
							<option value="4">4 - Naprosto originální práce</option>
						</select>
						</td>
						</tr>
		
						<tr>
						<td>Přínos:</td>
						<td><select name="prinos">
							<option value="1">1 - Žádný přínos do oboru</option>
							<option value="2">2 - Malý přínos do oboru</option>
							<option value="3">3 - Velký přínos do oboru</option>
							<option value="4">4 - Velký přínos napříč více obory</option>
						</select>
						</td>
						</tr>
		
						<tr>
						<td>Jazyková úroveň:</td>
						<td><select name="jazyk">
							<option value="1">1 - Tragická</option>
							<option value="2">2 - Slabá</option>
							<option value="3">3 - Dobrá</option>
							<option value="4">4 - Výborná</option>
						</select>
						</td>
						</tr>
					</table>
						<input type="hidden" name="hodnoceniID" value="'.$zprava["idkupilik_hodnoceni"].'">
					<div style="text-align:center"> <input type="submit" name="uloz" value="Uložit" >
				</form>
				</div>
		
				';
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
		
	}
	
	/***
	 * Zobrazí přihlášenému autorovi formulář na upravení příspěvku
	 * @param array $zprava Příspěvek, který chce autor upravit
	 * @return string html k zobrazení
	 */
	public static function getTemplateUprav($zprava){
		include ("View/view-hlavicky.class.php");
		
		$text = '
				<div class="col-9">
					<h3>Upravit příspěvek</h3>		
				<table>
	<form action="index.php?web=prispevky" method="POST" enctype="multipart/form-data">	
	 <input type="hidden" name="prispevekId" value="'.$zprava["idkupilik_prispevky"].'">
				
		<tr>
			<td>Název:</td>
			<td><input type="text" name="nazev" value="'.$zprava["nazev"].'" required></td>
		</tr>
		<tr>
			<td>Abstract:</td>
			<td><input type="text" name="abstract" value="'.$zprava["abstract"].'" required></td>
		</tr>
		<tr>
			<td>Vyber soubor:</td>
			<td> <input type="file" name="fileToUpload" accept=".pdf" required></td>
		</tr>
		
	</table>
				<div style="text-align:center"> <input type="submit" name="upraveno" value="Dokončeno" ></div>
	</form>
				</div>
				
				';
		
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}
	
	/***
	 * Zobrazí přihlášenému administrátorovi tabulku, ve které bude moci přidělovat recenzentům příspěvky k hodnocení
	 * @param unknown $db Reference na vytvořenou databázi
	 * @return string html k zobrazení
	 */
	public static function getTemplateAdministrator($db){
		include ("View/view-hlavicky.class.php");
		$text = '<div class="col-9">
					<h1>Seznam příspěvků</h1>		
				<div class="tabulkaPrispevky">
				<table>
					<tr>
						<th rowspan="2">Název</th>
						<th rowspan="2">Autor</th>
						<th colspan="6">Recenze</th>
						<th rowspan="2">Rozhodnutí</th>
					</tr>
				  	<tr>
    					<th>Recenzent</th>
    					<th>Orig.</th>
    					<th>Přínos</th>
   						<th>Jazyk</th>
    					<th>Celk.</th>
						<th>Vymazat</th>
  					</tr>';
				
		$zprava = $db->vratVsechnyPrispevky();
		$recenzenti = $db->vratRecenzenty();
		foreach ($zprava as $prispevek){
			$idPrispevku = $prispevek["idkupilik_prispevky"];
			$text .= '<tr>
						 <td rowspan="3">'.$prispevek["nazev"].'</td>
    					<td rowspan="3">'.$prispevek["autor"].'</td>'
		    							;
		    							$hodnoceni = $db->vratHodnoceniPodlePrispevku($prispevek["idkupilik_prispevky"]);
		    							$count = 3 - sizeof($hodnoceni);
		    							$pom = 0;
		    							if ($count == 3) {
		    								for($k = 0; $k < $count; $k++){
		    									$text .=   '
    <td>			<form action="index.php?web=prispevky" method="POST">
							<input type="hidden" name="prispevekID" value="' . $prispevek ["idkupilik_prispevky"] . '">
		    						<select name="recenzenti">';
		    									for($i = 0; $i < sizeof($recenzenti); $i++){
		    											
		    										$text .= '<option value="'.$recenzenti[$i]["idkupilik_user"].'">'.$recenzenti[$i]["login"].'</option>';
		    											
		    									}
		    									$text .= '</select>
		    						</td>
		    						<td colspan="5">
		    						<input type="submit" name="prirad" value="Přidělit k recenzi">
									</form>
									</td>
					
		
  ';
		    									if($k == 0){
		    										$text .= '<td rowspan="3">Nepřijmuto</td>
		    								<td rowspan="3">
										<form action="index.php?web=prispevky" method="POST">
							<input type="hidden" name="prispevekID" value="' . $prispevek ["idkupilik_prispevky"] . '">
							<input type="submit" name="zobraz" value="Zobraz příspěvek">
									</form>
									</td>		    												
		    												</tr>';
		    									}else{
		    										$text .= '</tr>';
		    									}
		    								}
		    							}else{
		    								foreach ( $hodnoceni as $jedno ) {
		    									$prumer = ($jedno ["originalita"] + $jedno ["prinos"] + $jedno ["jazykova_uroven"]) / 3;
		    									$recenzent = $db->najdiUzivateleID ( $jedno ["kupilik_user_idkupilik_user"] );
		    									$text .= '
		
   								 <td>' . $recenzent ["login"] . '</td>
    							<td>' . $jedno ["originalita"] . '</td>
    							<td>' . $jedno ["prinos"] . '</td>
    							<td>' . $jedno ["jazykova_uroven"] . '</td>
    							<td>' . $prumer . '</td>
    							<td>
    								<form action="index.php?web=prispevky" method="POST">
    								<input type="hidden" name="hodnoceniID" value="' . $jedno["idkupilik_hodnoceni"]. '">
    								<input type="submit" name="odstranHodnoceni" value="Odstraň hodnocení">
    								</form>
    									</td>';
		    									if ($pom == 0 && $count == 0) {
		    										$text .= '<td rowspan="3">';
		    										if($prispevek["publikovano"] == 1){
		    											$text .='Přijmuto';
		    										}else{
		    											$text .='Nepřijmuto';
		    										}
		    										$text .= '<form action="index.php?web=prispevky" method="POST">
							<input type="hidden" name="prispevekID" value="' . $prispevek ["idkupilik_prispevky"] . '">
							<input type="submit" name="prijmiPrispevek" value="Přijmout příspěvek">/<input type="submit" name="odmitniPrispevek" value="Odmítnout příspěvek">
									</td>
											</form>
											    								<td rowspan="3">
										<form action="index.php?web=prispevky" method="POST">
							<input type="hidden" name="prispevekID" value="' . $prispevek ["idkupilik_prispevky"] . '">
							<input type="submit" name="zobraz" value="Zobraz příspěvek">
									</form>
									</td>
    									</tr>									
    									<tr>
							';
		    									} else if($pom == 0){
		    										$text .= '<td rowspan="3">Nepřijmuto</td>
		    								<td rowspan="3">
										<form action="index.php?web=prispevky" method="POST">
							<input type="hidden" name="prispevekID" value="' . $prispevek ["idkupilik_prispevky"] . '">
							<input type="submit" name="zobraz" value="Zobraz příspěvek">
									</form>
									</td></tr>
    									<tr>';
		    									}else{
		    										$text .= '</tr><tr>';
		    									}
		    									$pom++;
		    								}
		    								for($k = 0; $k < $count; $k++){
		    									$text .=   '
    <td>						<form action="index.php?web=prispevky" method="POST">
							<input type="hidden" name="prispevekID" value="' . $prispevek ["idkupilik_prispevky"] . '">
		    						<select name="recenzenti1">';
		    									for($i = 0; $i < sizeof($recenzenti); $i++){
		    											
		    										$text .= '<option value="'.$recenzenti[$i]["idkupilik_user"].'">'.$recenzenti[$i]["login"].'</option>';
		    											
		    									}
		    									$text .= '</select>
		    											
									</td>
		    				    <td colspan="5">
		    						<input type="submit" name="prirad1" value="Přidělit k recenzi">
									</form>
									</td>
										
					
  </tr>';
		    								}
		    							}
		}
		
				$text .= '
						</tr>
						</table>
				</div>
				</div>
				';
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}
	
	/****
	 * Zobrazí přihlášenému uživateli příspěvky, které mu administrátor přiřadil k hodnocení.
	 * @param unknown $zprava Příspěvky přiřazené k hodnocení
	 * @param unknown $db Reference na vytvořenou databázi
	 * @return string html k zobrazení
	 */
	public static function getTemplateRecenzent($zprava, $db){
		include ("View/view-hlavicky.class.php");
		if($zprava == null){
			$text = '<div class="col-9">
					<h1>Nemáš přiděleny žádné příspěvky k hodnocení.</h1>
					</div>';
		}else{
			$text = '
				<div class="col-9">
				<h1>Příspěvky přidělené k hodnocení</h1>				
				<div class="tabulkaPrispevky">
			
				<table>
					<tr>
						<th>Název</th>
						<th>Autor</th>
						<th>Hodnocení</th>
						<th>Hodnotit</th>
					</tr>';
			foreach ($zprava as $prispevek){
				$nazev = $prispevek["nazev"];
				$prispevekID = $prispevek["idkupilik_prispevky"];
				$hodnoceni = $db->vratHodnoceniPrumer($_SESSION["user"]["idkupilik_user"], $prispevekID);
				$text .= '
						<tr>
							<td>'.$nazev.'</td>
							<td>'.$prispevek["autor"].'</td>
							<td>'.$hodnoceni.'</td>
				<td>
						<form action="index.php?web=prispevky" method="POST">
						<input type="hidden" name="prispevekID" value="'.$prispevekID.'">
						<input type="submit" name="hodnot" value="Hodnotit">
						</form>
								</td>
						';
			}
			$text .= '
				</table>
				</div>
				</div>';
				
		}
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
		
	}
	
	/***
	 * Zobrazí nepřihlášenému uživateli již publikované příspěvky
	 * @param unknown $zprava Publikované příspěvky
	 * @return string html k zobrazení
	 */
	public static function getTemplateNeprihlaseny($zprava){
		include ("View/view-hlavicky.class.php");
		$text = '
				<div class="col-9">
					<h1>Publikované příspěvky</h1>
				</div>
				';
		
		if($zprava == null){
			$text = '<div class="col-9">
					<h1>Žádné publikované příspěvky k zobrazení!</h1>
					</div>';
		}else{
			$text .= '
				<div class="col-9">';
			foreach ($zprava as $prispevek){
				$nazev = $prispevek["nazev"];
				$autor = $prispevek["autor"];
          			  $text .= "<h2>$nazev</h2>";
            $text .= "Autor: $autor <br><br>";
            $text .= "<div style='text-align:justify;'>Úryvek: $prispevek[abstract]</div>
            		<a href=uploads/$prispevek[nazevSouboru] target='_blank'>Soubor ke stažení</a>
            <hr>";
				}
				$text .= '
				</div>';
		}
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}
	
	/***
	 * Zobrazí příspěvek
	 * @param unknown $nazev Název příspěvku
	 * @param unknown $autor Autor příspěvku
	 * @param unknown $abstract 
	 * @param unknown $file
	 * @return string
	 */
	public static function getTemplatePrispevek($nazev, $autor, $abstract, $file){
		include ("View/view-hlavicky.class.php");
		
		$text = '
				<div class="col-9">
					<table>
						<tr>
							<td>Název</td>
							<td>'.$nazev.'</td>
						</tr>
						<tr>
							<td>Autor</td>
							<td>'.$autor.'</td>
						</tr>
						<tr>
							<td>Abstract</td>
							<td>'.$abstract.'</td>
						</tr>
						<tr>
							<td>Soubor</td>
<td><a href=uploads/'.$file.' target="_blank">Soubor ke stažení</a></td>
						</tr>									
					</table>
				</div>
				';
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
		
	}
}