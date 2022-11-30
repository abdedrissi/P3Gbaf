<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="fr">
	
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css" />
		<link rel="icon" type="image/png" href="logos/gbaf_ico.png" />
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&family=Roboto&display=swap" rel="stylesheet"> 
        <title>Groupement Banque Assurance Français</title>
	</head>
	
	<body>
	<?php include("../includes/inc_header.php"); ?>
		<div class="content accueil_content">
		<?php
		if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
		{
			?>
			<section class="presentation_section">
				<h1>Présentation du Groupement Banque Assurance Français</h1>
				<p>Le Groupement Banque Assurance Français​ (GBAF) est une fédération  représentant les 6 grands groupes français :</p>
				<div class="presentationListActeurs">
                    <ul>
                        <li><span  class="li_content">BNP Paribas </span></li>
                        <li><span  class="li_content">BPCE </span></li>
                        <li><span  class="li_content">Crédit Agricole </span></li>
                	</ul>
                    <ul>   
                        <li><span  class="li_content">Crédit Mutuel-CIC </span></li>
                        <li><span  class="li_content">Société Générale </span></li>
                        <li><span  class="li_content">La Banque Postale </span></li>
                    </ul>
                
                </div>
                 <p>Même s’il existe une forte concurrence entre ces entités, elles vont toutes travailler  de la même façon pour gérer près de 80 millions de comptes sur le territoire  national.  Le GBAF est le représentant de la profession bancaire et des assureurs sur tous  les axes de la réglementation financière française. Sa mission est de promouvoir  l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics.  </p>
                                 
			<section class="actors_list_section">
				<div class="actors_list_intro">
					<h2>Présentation des acteurs</h2>
						<p>Liste des différents acteurs du système bancaire français :</p>
				</div>
				<div class="illustration">
					<div class="illustration_logos_container">
						<a href="#"><img src="logos/banques/BP.jpg" alt="banque_postale"/></a>
						<a href="#"><img src="logos/banques/CA.png" alt="credit_agricole"/></a>
						<a href="#"><img src="logos/banques/SG.png" alt="societe_generale"/></a>
						<a href="#"><img src="logos/banques/CIC.png" alt="cic"/></a>			
						<a href="#"><img src="logos/banques/BPCE.png" alt="bpce"/></a>
						<a href="#"><img src="logos/banques/CM.png" alt="credit_mutuel"/></a>
						<a href="#"><img src="logos/banques/BNP.png" alt="bnp_paribas"/></a>
					</div>
				</div>
			</section>

			<section class="actors_list_section">
				<div class="actors_list_intro">
					<h2>Présentation des acteurs</h2>
                	<p>Liste des différents acteurs du système bancaire français :</p>
                		
					<?php // Récupération des infos et extraits de tous les partenaires
						try
						{
						$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', 'root');
						}
						catch (Exception $e)
						{
						        die('Erreur : ' . $e->getMessage());
						}
						$result = $db->query('SELECT * FROM actor');
						while($data = $result->fetch())
						{
							$content = htmlspecialchars($data['description']);
							$extract = explode(" ",$content);
							?>								
								    <div class="actor">
								    	<div class="actor_logo_n_desc">
								    		<div class="actor_logo"><img src="logos/<?= $data['logo']; ?>" alt="logo <?= $data['actor']; ?>"></div>
								    			<div class="actor_description">
									    			<h3><?= $data['actor']; ?></h3>									    			
									    			<p><?php /* boucle pour écrire les 25 premiers mots pour un rendu plus homogène, si on veut exactement la première phrase on demande d'afficher $phrase où $phrase = strtok($content,"."); mais résultat pas terrible si phrase trop courte. */
									    			$i = 0;
									    			while($i < 25)
									    			{
									    				echo $extract[$i] . ' ';
									    				$i++;
									    			}
									    			?>
									    		</div>
									    	</div>
									    	<a class="actor_read_more" href="acteur.php?act=<?= $data['id_actor']; ?>">Lire la suite</a>
								    </div>
							<?php
						}
						$result->closeCursor();
					?>
			</section>
		<?php
		}
		else
		{
			header('Location: ../index.php');
		}
	?>
		</div>
		<?php include("../includes/inc_footer.php"); ?>
	</body>
</html>