<?php
class BDD {

	private $mysqli;
	

	public function __construct() {
		$this -> mysqli = false;
	}

	/* Connexion à la base de données */
	public function connexion() {
		mysqli_report(MYSQLI_REPORT_OFF);
		
		$this -> mysqli = new mysqli('172.16.119.3', 'operateur', 'operateur', 'Quizz');

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
		$lettre = null;	//Servira a stocker les lettres

		/* On crée la requete SQL et on lie les paramètres */
		$requete = $this -> mysqli-> prepare("SELECT COUNT(id_Lettre) FROM Lettre");
		if (!$requete) {
    		return $lettre;
		}
		
		/* On execute la requete et on récupère le résultat */
		$requete -> execute();
		$resultat = $requete -> get_result();
		
		/* On libère la requête */
		$requete -> close();
			
		/* On parcours les résultats pour les stocker */
		if($enregistrement = $resultat -> fetch_object()) {
				$lettre = $enregistrement;
		}	
		
		return $lettre;
	}

	public function getLettreComplete()
	{
		$lettre = null;	//Servira a stocker les lettres

		/* On crée la requete SQL et on lie les paramètres */
		$requete = $this -> mysqli-> prepare("SELECT COUNT(Lettre.id_Lettre) FROM Lettre INNER JOIN livre ON Lettre.id_Lettre = livre.id_Lettre INNER JOIN Livraison ON livre.id_Livraison = Livraison.id_Livraison WHERE datelivraison < CURDATE();");
		if (!$requete) {
    		return $lettre;
		}
		
		/* On execute la requete et on récupère le résultat */
		$requete -> execute();
		$resultat = $requete -> get_result();
		
		/* On libère la requête */
		$requete -> close();
			
		/* On parcours les résultats pour les stocker */
		if($enregistrement = $resultat -> fetch_object()) {
				$lettre = $enregistrement;
		}	
		
		return $lettre;
	}

	public function getLettreNonComplete()
	{
		$lettre = null;	//Servira a stocker les lettres

		/* On crée la requete SQL et on lie les paramètres */
		$requete = $this -> mysqli-> prepare("SELECT COUNT(DISTINCT Lettre.id_Lettre) FROM Lettre INNER JOIN livre ON Lettre.id_Lettre = livre.id_Lettre INNER JOIN Livraison ON livre.id_Livraison = Livraison.id_Livraison WHERE datelivraison > CURDATE()");
		if (!$requete) {
    		return $lettre;
		}
		
		/* On execute la requete et on récupère le résultat */
		$requete -> execute();
		$resultat = $requete -> get_result();
		
		/* On libère la requête */
		$requete -> close();
			
		/* On parcours les résultats pour les stocker */
		if($enregistrement = $resultat -> fetch_object()) {
				$lettre = $enregistrement;
		}	
		
		return $lettre;
	}

	public function getInfoEnfant()
	{
		$lettre = null;	//Servira a stocker les lettres

		/* On crée la requete SQL et on lie les paramètres */
		$requete = $this -> mysqli-> prepare("SELECT nom, prenom, pays, ville, type_voie, code_postal, libelle, Lettre.status FROM Enfant INNER JOIN Adresse ON Enfant.id_Enfant = Adresse.id_Adresse INNER JOIN Lettre ON Lettre.id_Enfant = Enfant.id_Enfant INNER JOIN livre ON Lettre.id_Lettre = livre.id_Lettre INNER JOIN Type_cadeau ON livre.id_TypeCadeau = Type_cadeau.id_TypeCadeau GROUP BY nom");
		if (!$requete) {
    		return $lettre;
		}
		
		/* On execute la requete et on récupère le résultat */
		$requete -> execute();
		$resultat = $requete -> get_result();
		
		/* On libère la requête */
		$requete -> close();
			
		/* On parcours les résultats pour les stocker */
		if($enregistrement = $resultat -> fetch_object()) {
				$lettre = $enregistrement;
		}	
		
		return $lettre;
	}

	public function getStock()
	{
		$lettre = null;	//Servira a stocker les lettres

		/* On crée la requete SQL et on lie les paramètres */
		$requete = $this -> mysqli-> prepare("SELECT libelle, stock FROM TypeCadeau");
		if (!$requete) {
    		return $lettre;
		}
		
		/* On execute la requete et on récupère le résultat */
		$requete -> execute();
		$resultat = $requete -> get_result();
		
		/* On libère la requête */
		$requete -> close();
			
		/* On parcours les résultats pour les stocker */
		if($enregistrement = $resultat -> fetch_object()) {
				$lettre = $enregistrement;
		}	
		
		return $lettre;
	}

	public function getLutin()
	{
		$lettre = null;	//Servira a stocker les lettres

		/* On crée la requete SQL et on lie les paramètres */
		$requete = $this -> mysqli-> prepare("SELECT nom, prenom, fonction, adresse FROM Lutin INNER JOIN `Role` ON Lutin.id_Role = Role.id_Role LEFT JOIN Atelier ON Lutin.id_Atelier = Atelier.id_Atelier");
		if (!$requete) {
    		return $lettre;
		}
		
		/* On execute la requete et on récupère le résultat */
		$requete -> execute();
		$resultat = $requete -> get_result();
		
		/* On libère la requête */
		$requete -> close();
			
		/* On parcours les résultats pour les stocker */
		if($enregistrement = $resultat -> fetch_object()) {
				$lettre = $enregistrement;
		}	
		
		return $lettre;
	}

	
	
}
?>