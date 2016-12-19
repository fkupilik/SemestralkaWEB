<?php
class ViewPrihlaseni{
	public function __construct(){
		
	}
	
	/***
	 * Zobrazí formulář pro přihlášení uživatele
	 * @param unknown $zprava Zpráva, která se zobrazí, když přihlášení není možné
	 * @return string html k zobrazení
	 */
	public static function getTemplate($zprava){
		include("view/view-hlavicky.class.php");
		$text = "";
		if ($zprava != null) {
			$text .= "<div class='col-9'><h1>$zprava</h1></div>";
		}
			$text .= '<div class="col-9">
				<h1>Přihlášení</h1>
					<form action="index.php?web=prihlaseni" method="POST">
			
			<table>
		<tr>
			<td>Login:</td>
			<td><input type="text" name="login" required></td>
		</tr>
		<tr>
			<td>Heslo:</td>
			<td><input type="password" name="heslo" required></td>
		</tr>
			
	</table>
				<div style="text-align:center"> <input type="submit" name="potvrzeni" value="Přihlásit" ></div>
	</form>
				</div>';
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
		
	}
}