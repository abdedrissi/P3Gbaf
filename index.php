<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="pages/style.css" />
		<link rel="icon" type="image/png" href="pages/logos/gbaf_ico.png" />
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&family=Roboto&display=swap" rel="stylesheet"> 
		<title>Connexion GBAF</title>
	</head>
	<body>
	<?php include("includes/inc_header.php"); ?>
		<div class="content accueil_content">
		<?php
		if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
		{
			header('Location: pages/accueil.php');
		}
		else
		{
			?>
			<form class="connection_form" action="traitement/trait_connexion.php" method="post">
				<fieldset>
					<legend>Connexion</legend>
						<?php
							if(isset($_SESSION['passchanged']))
							{
								    echo '<p style=color:red;>La modification du mot de passe a bien été prise en compte.</p>';
								    unset($_SESSION['passchanged']);
							}							
							if(isset($_SESSION['wrong']))
							{
								    echo '<p style=color:red;>Le mot de passe ou l\'identifiant est incorrect.</p>';
								    unset($_SESSION['wrong']);
							}
							if(isset($_SESSION['success']))
							{
								    echo '<p style=color:red;>Inscription réussie !</p>';
								    unset($_SESSION['success']);
							}														
						?>
						<label for="username">Indentifiant / nom d'utilisateur :</label><input type="text" name="username" id="username"/>

						<label for="password">Mot de passe :</label><input type="password" name="password" id="password"/>

						<div class="connection_link"><a href="pages/reinitialisation.php?fgt=1">Mot de passe oublié ?</a><p>  |  </p><a href="pages/inscription.php">Je ne suis pas encore inscrit</a></div>

						<input type="submit" name="submit" value="Me connecter">
			
				</fieldset>			
			</form>
			<?php		
		}
	?>
		</div>
		<?php include("includes/inc_footer.php"); ?>
	</body>
</html>