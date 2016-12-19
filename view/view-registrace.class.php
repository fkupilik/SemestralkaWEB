<?php
class ViewRegistrace {
	public function __construct() {
	}
	
	/***
	 * Zobrazí formulář k registraci nového uživatele
	 * @param unknown $zprava 
	 * @return string
	 */
	public static function getTemplate($zprava=null) {
		include ("View/view-hlavicky.class.php");
		$text = "";
		if(isset($_SESSION["user"]) == false){
		$text .= 
				'<div class="col-9">
				<div class="formular">
				<h1>Registrace</h1>
					<form action="index.php?web=registrace" method="POST">

				<table>
		<tr>
			<td>Login:</td>
			<td><input type="text" name="login" required></td>
		</tr>
		<tr>
			<td>Heslo 1:</td>
			<td><input type="password" name="heslo" required></td>
		</tr>
		<tr>
			<td>Heslo 2:</td>
			<td><input type="password" name="heslo2" required></td>
		</tr>
		<tr>
			<td>Jméno:</td>
			<td><input type="text" name="jmeno"
				></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><input type="email" name="email"
				></td>
		</tr>
	</table>
				<div style="text-align:center;"> <input type="submit" name="potvrzeni" value="Registrovat" >
				</div>
	</form>
				</div>
				</div>';
		}else{
			$text = "<div class='col-9'><h1>Přihlášený uživatel se nemůže znovu registrovat. </h1></div>";
		}
		if($zprava != null){
			$text .= "<div class='col-9'><h1>$zprava</h1></div>";
		}
		
		return ViewHlavicky::getHTMLHeader().$text.ViewHlavicky::getHTMLFooter();
	}			
}
?>
