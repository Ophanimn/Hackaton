<?php
	include("bdd.php");
	include("template.php");

	class AppMVC {

		private $bdd;

		public function __construct() {
			$this -> bdd = new BDD();
		}

		public function afficherPage($mapage) {
			if(!$this -> bdd -> connexion()) {//Connexion à la BDD
				echo "Une erreur est survenue à la connexion";
				return;
			}
			
			if($mapage == 1) $this -> page1();
			else if($mapage == 2) $this -> page2();
			else if($mapage == 3) $this -> page3();
			else if($mapage == 4) $this -> page4();
			else if($mapage == 5) $this -> page5();
			else $this -> page1();
			
			$this -> bdd -> deconnexion();
		}

		public function page1()
        {
            $vue = new Template('template/index.html');

			echo $vue -> getSortie();
        }

		/*public function page2()
        {
            $vue = new Template('template/lettres.html');

			echo $vue -> getSortie();
        }

		public function page3()
        {
            $vue = new Template('template/lutins_ateliers.html');

			echo $vue -> getSortie();
        }

		public function page4()
        {
            $vue = new Template('template/livraisons.html');

			echo $vue -> getSortie();
        }

		public function page5()
        {
            $vue = new Template('template/cadeaux.html');

			echo $vue -> getSortie();
        }*/


        public function page2()
        {	
			$lettres = $this -> bdd -> getInfoEnfant();
			
			$contenu = '';
    		foreach ($lettres as $lettre) {
        		$contenu .= '<td>' . htmlspecialchars($lettre->nom) . '</td>';
        		$contenu .= '<td>' . htmlspecialchars($lettre->date_reception) . '</td>';
        		$contenu .= '<td>' . htmlspecialchars($lettre->cadeaux) . '</td>';
        		$contenu .= '<td><button>Voir</button> <button>Supprimer</button></td>';
    		}
			
			$template = file_get_contents('template/lettres.html');

    		// On remplace le placeholder par le contenu HTML généré
   		 	$html = str_replace('{{LETTRES}}', $contenu, $template);

    		// On affiche le HTML complet
    		echo $html;
        }


        public function page3()
        {
			$ateliers = $this -> bdd -> getAtelier();
			
			$contenu1 = '';
    		foreach ($ateliers as $atelier) {
        		$contenu1 .= '<td>' . htmlspecialchars($atelier->secteur) . '</td>';
        		$contenu1 .= '<td>' . htmlspecialchars($atelier->adresse) . '</td>';
        		$contenu1 .= '<td>' . htmlspecialchars($atelier->nb_lutins) . '</td>';
    		}

			$lutins = $this -> bdd -> getLutin();
			
			$contenu2 = '';
    		foreach ($lutins as $lutin) {
        		$contenu2 .= '<td>' . htmlspecialchars($lutin->nom) . '</td>';
        		$contenu2 .= '<td>' . htmlspecialchars($lutin->fonction) . '</td>';
        		$contenu2 .= '<td>' . htmlspecialchars($lutin->adresse) . '</td>';
    		}

			$template = file_get_contents('template/lettres.html');

    		// On remplace le placeholder par le contenu HTML généré
   		 	$html = str_replace('{{ATELIER}}', $contenu1, $template);
			$html = str_replace('{{LUTIN}}', $contenu2, $template);

    		// On affiche le HTML complet
    		echo $html;
        }

		public function page4()
        {
            $livraisons = $this -> bdd -> getLivraison();
			
			$contenu = '';
    		foreach ($livraisons as $livraison) {
				$contenu .= '<td>' . htmlspecialchars($livraison->id_Livraison) . '</td>';
        		$contenu .= '<td>' . htmlspecialchars($livraison->datelivraison) . '</td>';
        		$contenu .= '<td>' . htmlspecialchars($livraison->status) . '</td>';
        		$contenu .= '<td>' . htmlspecialchars($livraison->lutins) . '</td>';
    		}
			
			$template = file_get_contents('template/livraisons.html');

    		// On remplace le placeholder par le contenu HTML généré
   		 	$html = str_replace('{{LIVRAISON}}', $contenu, $template);

    		// On affiche le HTML complet
    		echo $html;
        }

		public function page5()
        {
            $cadeaux = $this -> bdd -> getStock();
			
			$contenu = '';
    		foreach ($cadeaux as $cadeau) {
				$contenu .= '<td>' . htmlspecialchars($cadeau->libelle) . '</td>';
        		$contenu .= '<td>' . htmlspecialchars($cadeau->stock) . '</td>';
        		$contenu .= '<td><button>Voir</button> <button>Supprimer</button></td>';
    		}
			
			$template = file_get_contents('template/cadeaux.html');

    		// On remplace le placeholder par le contenu HTML généré
   		 	$html = str_replace('{{CADEAUX}}', $contenu, $template);

    		// On affiche le HTML complet
    		echo $html;
        }
    }
?>
