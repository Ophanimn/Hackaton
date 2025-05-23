<?php
class BDD {

	private $mysqli;
	

	public function __construct() {
		$this -> mysqli = false;
	}

	/* Connexion à la base de données */
	public function connexion() {
		mysqli_report(MYSQLI_REPORT_OFF);
		
		$this -> mysqli = new mysqli('192.168.0.50', 'admin-maxime', 'P@ssw0rd', 'atelier_noel');

		if($this -> mysqli -> connect_errno != 0) {
			return false;
		}
		else return true;
	}
	
	
	/* Déconnexion à la base de données */
	public function deconnexion() {
		if($this -> mysqli -> connect_errno != 0) {
			$this -> mysqli -> close();
		}
	}

	/* Fonction pour avoir le nombre total de lettre */
	public function getLettreTotal()
	{
		$requete = $this->mysqli->prepare("SELECT COUNT(id_Lettre) AS total FROM Lettre");
		if (!$requete) return 0;

		$requete->execute();
		$resultat = $requete->get_result();
		$requete->close();

		if ($row = $resultat->fetch_assoc()) {
			return (int)$row['total'];
		}

		return 0;
	}

	public function getLettreComplete()
	{
		$requete = $this->mysqli->prepare(
			"SELECT COUNT(DISTINCT Lettre.id_Lettre) AS complete
			FROM Lettre
			INNER JOIN livre ON Lettre.id_Lettre = livre.id_Lettre
			INNER JOIN Livraison ON livre.id_Livraison = Livraison.id_Livraison
			WHERE datelivraison < CURDATE()"
		);
		if (!$requete) return 0;

		$requete->execute();
		$resultat = $requete->get_result();
		$requete->close();

		if ($row = $resultat->fetch_assoc()) {
			return (int)$row['complete'];
		}

		return 0;
	}

	public function getLettreNonComplete()
	{
		$requete = $this->mysqli->prepare(
			"SELECT COUNT(DISTINCT Lettre.id_Lettre) AS incompletes
			FROM Lettre
			INNER JOIN livre ON Lettre.id_Lettre = livre.id_Lettre
			INNER JOIN Livraison ON livre.id_Livraison = Livraison.id_Livraison
			WHERE datelivraison > CURDATE()"
		);
		if (!$requete) return 0;

		$requete->execute();
		$resultat = $requete->get_result();
		$requete->close();

		if ($row = $resultat->fetch_assoc()) {
			return (int)$row['incompletes'];
		}

		return 0;
	}


	public function getInfoEnfant()
		{
			$lettres = [];

			$requete = $this->mysqli->prepare("SELECT CONCAT(Enfant.nom, ' ' ,Enfant.prenom) AS nom, Lettre.date_reception, GROUP_CONCAT(Type_cadeau.libelle SEPARATOR ', ') AS cadeaux FROM Enfant INNER JOIN Lettre ON Lettre.id_Enfant = Enfant.id_Enfant INNER JOIN livre ON Lettre.id_Lettre = livre.id_Lettre INNER JOIN Type_cadeau ON livre.id_TypeCadeau = Type_cadeau.id_TypeCadeau GROUP BY Enfant.id_Enfant, Lettre.date_reception ORDER BY Enfant.nom, Enfant.prenom");

			if (!$requete) {
				return $lettres;
			}

			$requete->execute();
			$resultat = $requete->get_result();

			while ($ligne = $resultat->fetch_object()) {
				$lettres[] = $ligne;
			}

			$requete->close();
			return $lettres;
		}

		public function getStock()
		{
			$stock = [];
		
			$requete = $this->mysqli->prepare("SELECT libelle, stock FROM Type_cadeau");
			if (!$requete) return $stock;
		
			$requete->execute();
			$resultat = $requete->get_result();
			$requete->close();
		
			while ($row = $resultat->fetch_object()) {
				$stock[] = $row;
			}
		
			return $stock;
		}
		

		public function getLutin()
		{
			$lutins = [];
		
			$requete = $this->mysqli->prepare("
				SELECT nom, prenom, fonction, adresse 
				FROM Lutin 
				INNER JOIN Role ON Lutin.id_Role = Role.id_Role 
				LEFT JOIN Atelier ON Lutin.id_Atelier = Atelier.id_Atelier
			");
			if (!$requete) return $lutins;
		
			$requete->execute();
			$resultat = $requete->get_result();
			$requete->close();
		
			while ($row = $resultat->fetch_object()) {
				$lutins[] = $row;
			}
		
			return $lutins;
		}		

		public function getAtelier()
		{
			$ateliers = [];
		
			$requete = $this->mysqli->prepare("
				SELECT 
					Atelier.secteur, 
					Atelier.adresse, 
					COUNT(Lutin.id_Lutin) AS nb_lutins, 
					GROUP_CONCAT(CONCAT(Lutin.nom, ' ', Lutin.prenom) SEPARATOR ', ') AS noms_lutins 
				FROM Atelier 
				INNER JOIN Lutin ON Lutin.id_Atelier = Atelier.id_Atelier 
				GROUP BY Atelier.id_Atelier, Atelier.secteur, Atelier.adresse 
				ORDER BY Atelier.secteur
			");
			if (!$requete) return $ateliers;
		
			$requete->execute();
			$resultat = $requete->get_result();
			$requete->close();
		
			while ($row = $resultat->fetch_object()) {
				$ateliers[] = $row;
			}
		
			return $ateliers;
		}
		

		public function getLivraison()
		{
			$livraisons = [];
		
			$requete = $this->mysqli->prepare("
				SELECT 
					Livraison.id_Livraison,
					Livraison.datelivraison, 
					Lettre.status, 
					GROUP_CONCAT(CONCAT(Lutin.nom, ' ', Lutin.prenom) SEPARATOR ', ') AS lutins
				FROM Livraison 
				INNER JOIN gere ON Livraison.id_Livraison = gere.id_Livraison 
				INNER JOIN Lutin ON gere.id_Lutin = Lutin.id_Lutin 
				INNER JOIN livre ON Livraison.id_Livraison = livre.id_Livraison 
				INNER JOIN Type_cadeau ON livre.id_TypeCadeau = Type_cadeau.id_TypeCadeau 
				INNER JOIN Lettre ON livre.id_Lettre = Lettre.id_Lettre 
				INNER JOIN Enfant ON Lettre.id_Enfant = Enfant.id_Enfant 
				GROUP BY Livraison.id_Livraison, Livraison.datelivraison, Lettre.status
				ORDER BY Livraison.datelivraison
			");
			if (!$requete) return $livraisons;
		
			$requete->execute();
			$resultat = $requete->get_result();
			$requete->close();
		
			while ($row = $resultat->fetch_object()) {
				$livraisons[] = $row;
			}
		
			return $livraisons;
		}		
}
?>