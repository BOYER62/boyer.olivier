<?php
    require_once 'Settings/bdd.inc.php'; // Fait le lien etre PHP et la base de donnée
        //require_once 'Settings/init.inc.php';
    include_once 'Includes/header.inc.php'; // En-tete
    //include_once 'Includes/menu.inc.php'; // Menu
    require_once('libs/Smarty.class.php'); // Librairi de smarty
        // mise en place de Smarty
        
    $smarty = new Smarty();
    $smarty->setTemplateDir('templates/'); // repertoire de templates
    $smarty->setCompileDir('templates_c/');// repertoire de compilatoin de smarty
        //$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
        //$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');
        
        //on prepare la pagination
    if(isset($_COOKIE['sid']))
    {
    $sql = $bdd -> prepare ("SELECT COUNT(*) as nbArticles FROM articles WHERE publie=1");
    $sql -> execute();
    $tabArticles = $sql -> fetchAll (PDO::FETCH_ASSOC);
    $totalArticles = $tabArticles[0] ['nbArticles'];
    $nbreArticleParPage = 2;
    if (isset($_GET['numPage']))
        {
        $numPage = $_GET['numPage'];
        }
        else 
            {
            $numPage = 1;
            }
    $nbrePages = ceil($totalArticles/$nbreArticleParPage);
    function returnIndex($numPage, $nbreArticleParPage)
        {
        return ceil(($numPage-1)*$nbreArticleParPage);
        }
    $indexDepart = returnIndex($numPage, $nbreArticleParPage);
        // fin pagination

        //requete qui enregistre tous les articles dans une variable tableau : $tab_articles
    
    $sth = $bdd -> prepare("SELECT id, titre, texte, DATE_FORMAT(date, '%d,%M,%Y') as date_fr 
                	FROM articles 
			WHERE publie = :publie
			LIMIT $indexDepart, $nbreArticleParPage"); //préparation de la requete.
		
    $sth -> bindvalue(':publie', 1, PDO::PARAM_INT); //on prepare la variable et on la securise
                				//la variable :publie ne prendra qu'un entier int
    $sth -> execute();
                    
    $tab_articles = $sth -> fetchAll(PDO::FETCH_ASSOC);

		
        //print_r ($tab_articles);
        //fin requete enregistrement des articles
        //prepare les variables pour smarty de la page Index    
    $smarty->assign('nbrePages',$nbrePages);
    $smarty->assign('tab_articles',$tab_articles);

    $smarty->display('Index.tpl');
    
    include_once 'Includes/menu.inc.php';
    include_once 'Includes/footer.inc.php';
    }
 else {
     header("location: connexion.php");
}
