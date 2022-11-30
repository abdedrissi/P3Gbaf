<?php
session_start();
if(isset($_SESSION['username'])) // si connexion active
{
	foreach($_POST as $value => $key)
	{
		$_POST[$value] = htmlspecialchars($_POST[$value]);
	}
	$username = htmlspecialchars($_SESSION['username']);
	try
	{
	$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}
	// On vérifie l'identité de username actuel
	$result = $db->prepare('SELECT id_user FROM account WHERE username = :username');
	$result->execute(array('username' => $username));
	$data = $result->fetch();
	$result->closeCursor();
	if(!$data) // si pas de correspondance, ne devrait pas arriver, retour accueil
	{
		header('Location: ../pages/accueil.php');
	}
	else
	{
		$id_user = htmlspecialchars($data['id_user']);
		// Gestion du changement d'identifiant
		if(isset($_POST['username']) AND !empty($_POST['username']))
		{
			// Test si username disponnible
			$result = $db->prepare('SELECT username FROM account WHERE username = :username');
			$result->execute(array('username' => $_POST['username']));
			$data = $result->fetch();
			$result->closeCursor();			
			if(strlen($_POST['username']) < 3)
			{
				// trop court invalide
				$error[] = 'short';			
			}
			elseif($data)
			{
				// username existant
				$error[] = 'exist';
			}
			else
			{
				// si tout se passe bien
				$new_username = $_POST['username'];
				$req = $db->prepare('UPDATE account SET username = :new_username WHERE id_user = :id_user');
				$req->execute(array('new_username' => $new_username, 'id_user' => $id_user));
				$req->closeCursor();			
				$_SESSION['username'] = $new_username;		
			}			
		}
		// Gestion de changement mot de passe
		if(!empty($_POST['actual_pass']) AND !empty($_POST['pass1']) AND !empty($_POST['pass2']))
		{
			if(!preg_match("#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\d)(?=.*[^A-Za-z\d])#",$_POST['pass1']) OR strlen($_POST['pass1']) < 8)
			{
			// format mot de passe invalide
			$error[] = 'invalidpass';
			}
			if($_POST['pass1'] != $_POST['pass2'])
			{
			// les mots de passe ne correspondent pas
			$error[] = 'passnotmatching';
			}
			if(!isset($error))
			{
				$actual_pass = htmlspecialchars($_POST['actual_pass']);
				$result = $db->prepare('SELECT password FROM account WHERE username = :username');
				$result->execute(array('username' => $username));
				$data = $result->fetch();
				$password = htmlspecialchars($data['password']);
				$testpass = password_verify($actual_pass,$password);
				if($testpass)
				{
					$new_password = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
					$req = $db->prepare('UPDATE account SET password = :new_password WHERE id_user = :id_user');
					$req->execute(array('new_password' => $new_password, 'id_user' => $id_user));
					$req->closeCursor();
					$_SESSION['passchanged'] = true;
				}
				else
				{
				// mauvais mot de passe
				$error[] = 'wrongpass';		
				}
			}
		}
		
		}
		// retour à la page de profil
		header('Location: ../pages/profil.php');
	}
	if(isset($error))
	{
		foreach($error as $value => $key)
		{
			$_SESSION[$key] = true;
		}
	}

else // pas de connexion -> retour accueil
{
	header('Location: ../pages/accueil.php');
}
?>