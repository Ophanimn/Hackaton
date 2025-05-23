<?php
	include("bdd.php");
	include("template.php");

	class AppMVC {

		private $bdd;

		public function __construct() {
			$this -> bdd = new BDD();
		}

		public function afficherPage($mapage) {
			//if(!$this -> bdd -> connexion()) {//Connexion à la BDD
			//	echo "Une erreur est survenue à la connexion";
			//	return;
			//}
			
			if($mapage == 1) $this -> page1();
			else if($mapage == 2) $this -> page2();
			else if($mapage == 3) $this -> page3();
			else if($mapage == 3) $this -> page4();
			else if($mapage == 3) $this -> page5();
			else $this -> page1();
			
			$this -> bdd -> deconnexion();
		}

		public function page1()
        {
            $vue = new Template('template/index.html');

			echo $vue -> getSortie();
        }

        public function page2()
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
            $vue = new Template('template/cadeau.html');

			echo $vue -> getSortie();
        }
    }
?>