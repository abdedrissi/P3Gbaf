<header class="header_content">
	
	<?php
		if(isset($_SESSION['username'])) //si session active
		{
			try
			{
			$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
			}
			catch (Exception $e)
			{
			        die('Erreur : ' . $e->getMessage());
			}
			$nom = htmlspecialchars($_SESSION['last_name']);
			$prenom = htmlspecialchars($_SESSION['first_name']);
			$username = htmlspecialchars($_SESSION['username']);					
			?>
			<div class="logo_gbaf">
				<a href="accueil.php"><img src="../pages/logos/gbaf.png" title="GBAF" alt="GBAF logo"/></a>
			</div>
			<div class="user_ref">
				<div class="user_photo">
					<img  src="logos/avatar.png" alt="logo avatar" />
				</div>
				<div class="user_name">
					<a href="profil.php" title="Voir mon profil"><p><?= $prenom . ' ' . $nom; ?></p></a>
				</div>
				<form class="deconnection_form" action="../traitement/trait_deconnexion.php" method="post"><input type="submit" value="deconnexion"/></form>				
			</div>
			<?php
		}
		else // pas de session
		{
			?>

			<div class="logo_gbaf">
				<a href="accueil.php"><img src="logos/gbaf.png" title="GBAF" alt="GBAF logo"/></a>
			</div>
			<div class="inscription_link">
				<a href="inscription.php">S'inscrire</a><p>/</p><a href="../index.php">Se connecter</a>
			</div>
			<?php
		}
	?>
</header>