<?php
    
    session_start(); //pour transporter les données de variables de pages en pages.
					//car toutes les données sont supprimées en fin de script (fin de page)

    require_once 'settings/bdd.inc.php'; // creer le lien entre PHP et PHPMyadmin
	//require_once 'settings/init.inc.php';
    require_once('libs/Smarty.class.php');

    $smarty = new Smarty();

    $smarty->setTemplateDir('templates/');
    $smarty->setCompileDir('templates_c/');
    //$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
    //$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

	//la structure if (pour un formulaire déjà rempli) /else (1ère visite sur la page, formulaire non rempli)
    
    if((isset($_POST['motRechercher']) OR 
            isset($_POST['ajouter']) OR 
            isset($_GET['modifier']) OR 
            isset($_POST['valider_modifier'])) AND 
            isset($_COOKIE['sid']))
        {
	//echo "Formulaire OK!";
		
	$date_ajout = date("Y-m-d"); //on enregistre la date du système dans une variable
	$_POST['date']=$date_ajout; //on ajoute la date à la liste de POST
	
		//si la case est cochée on met publie à 1
			//condition simple
				//if(isset($_POST['publie'])){ //isset = est-ce qu'il existe?
				//	$_POST['publie'] = 1;
				//}else{
				//	$_POST['publie'] = 0;
				//}
                                //
        if($_GET['modifier']>=1) //prepare les variables a affiher
            {
            $id=$_GET['modifier'];        
            $sql = $bdd -> prepare ("SELECT * FROM articles WHERE id=$id");
            $sql -> execute();
            $tabArticles = $sql -> fetchAll (PDO::FETCH_ASSOC);
            $titre=$tabArticles[0]['titre'];
            $texte=$tabArticles[0]['texte'];
            $date=$tabArticles[0]['date'];
            $publie=$tabArticles[0]['publie'];
            $id=$tabArticles[0]['id'];
            //print_r($tabArticles);
            }
            else
                {
                
                
                	//condition ternaire (écriture plus simple)
                        $_POST['publie'] = isset($_POST['publie']) ? 1 : 0;
	
                        //les contrôles
                        //print_r ($_POST); //variable qui récupère tout ce qui a dans la page (method="post")
                        //print_r ($_FILES); //variable qui récupère les images
                        //exit();
		
                        if($_FILES['image']['error'] == 0)
                            {
                            if(isset($_POST['ajouter']))
                                {
                                $sth = $bdd->prepare("INSERT INTO articles (titre, texte, publie, date) VALUES (:titre, :texte, :publie, :date)"); //préparation de la requête.
                                }
                                elseif (isset ($_POST['valider_modifier']))
                                    {
                                    $sth = $bdd->prepare("UPDATE articles SET titre=:titre, texte=:texte, publie=:publie, date=:date WHERE id=:id");
                                    $sth -> bindvalue(':id', $_POST['id'], PDO::PARAM_INT); //la variable :id prendra qu'un entier
                                    }
                            //on prépare les variables et on les sécurises
                            $sth -> bindvalue(':titre', $_POST['titre'], PDO::PARAM_STR); //la variable :titre ne prendra qu'un varchar
                            $sth -> bindvalue(':texte', $_POST['texte'], PDO::PARAM_STR); //la variable :texte ne prendra qu'un text
                            $sth -> bindvalue(':publie', $_POST['publie'], PDO::PARAM_INT); //la variable :publie ne prendra qu'un entier int
                            $sth -> bindvalue(':date', $_POST['date'], PDO::PARAM_STR); //la variable :date ne prendra qu'une date
                    								
                            $sth -> execute();
			
                            $id = $bdd->lastInsertId();
                            echo "Dernier id = $id";
                    
                            move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__)."/img/$id.jpg");
                            echo 'dirname(_FILE_)."/img/$id.jpg"';
				
                            $_SESSION['ajout_article'] = TRUE;
                            //redirection vers une autre page
                            header("location: article.php");
                            }
                            else
                                {
                                echo "Erreur de chargement de l'image!";
                                exit();
                                }
                        
                }
        include_once 'includes/header.inc.php';
        //include_once 'includes/menu.inc.php';
        $smarty->assign('modifier',$_GET['modifier']);
        $smarty->assign('id',$id); // passage de php a smarty
        $smarty->assign('titre',$titre); // passage de php a smarty
        $smarty->assign('texte',$texte); // passage de php a smarty
        $smarty->display('article.tpl');
        if (isset($_SESSION['ajout_article']))
        {
            //session_destroy();
        }}
        else
            {
            //echo "Formulaire NOK!";
            include_once 'includes/header.inc.php';
            //include_once 'includes/menu.inc.php';
            $smarty->display('article.tpl');
            }
    include_once 'Includes/menu.inc.php';    
    include_once 'Includes/footer.inc.php';
        
?>