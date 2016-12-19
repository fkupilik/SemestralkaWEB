<?php
class ViewUzivatele{
	public function __construct(){
		
	}
	
	/***
	 * Zobrazí administrátorovi informace o uživateli.
	 * @param unknown $uzivatel 
	 * @return string
	 */
	public static function getTemplateUzivatel($uzivatel){
		include ("View/view-hlavicky.class.php");
		
		$text = '
				<div class="col-9">
					<h1>Upravit uživatele</h1>
					<form action="index.php?web=uzivatele" method="POST">
					<input type="hidden" name="userId" value="'.$uzivatel["idkupilik_user"].'">
					<table>
				
						<tr>
							<td>Login</td>
							<td>'.$uzivatel["login"].'</td>							
						</tr>
						<tr>
							<td>Jméno</td>
							<td>'.$uzivatel["name"].'</td>
						</tr>
						<tr>
							<td>Práva</td>
							<td><select name="prava">
  									<option value="1">Administrátor</option>
  									<option value="2">Autor</option>
  									<option value="3">Recenzent</option>
								</select></td>
						</tr>
					</table>
					<div style="text-align:center"> <input type="submit" name="uloz" value="Ulož">
					<input type="submit" name="odstran" value="Odstraň uživatele">
					<input type="submit" name="zpet" value="Zpět bez uložení"></div>
						</form>
					</div>
				';
		
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}
	
	/****
	 * Zobrazí administrátorovi všechny registrované uživatele
	 * @param unknown $zprava
	 * @return string
	 */
	public static function getTemplate($zprava){
		include ("View/view-hlavicky.class.php");
		
		if($zprava == null){
			$text = '<div class="col-9">
					Nejsou registrovaní žádní uživatelé.
					</div>
					';
		}else{
		
		$text = '
				
				<div class="col-9">
					<h1>Registrovaní uživatelé</h1>
				<div class="tabulkaPrispevky">
				<table>
					<tr>
						<th>Login</th>
						<th>Jméno</th>
						<th>Práva</th>
					</tr>
				';
		foreach($zprava as $uzivatel){
			$text .= '
					<tr>
						<td>'.$uzivatel["login"].'</td>
						<td>'.$uzivatel["name"].'</td>';
			if($uzivatel["kupilik_prava_idkupilik_prava"] == 2){
				$text .= '<td>Autor</td>';
			}else if($uzivatel["kupilik_prava_idkupilik_prava"] == 3){
				$text .= '<td>Recenzent</td>';
				
			}
						$text .= '<td>
							<form action="index.php?web=uzivatele" method="POST">
						    <input type="hidden" name="userId" value="'.$uzivatel["idkupilik_user"].'">
							<input type="submit" name="zobraz" value="Zobraz">
						    </form>
						</td>
					</tr>
					
					
					';
		}
		
		$text .= '</table>
				</div>
				  </div>';
		}
		
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}
}