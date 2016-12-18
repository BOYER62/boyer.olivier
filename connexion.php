
<?php
require_once 'Settings/bddf.inc.php';
require_once('libs/Smarty.class.php');

include_once 'includes/header.inc.php';
// include_once 'includes/menu.inc.php';

$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');

if (isset($_POST['Valider'])) {

    $sth = $bddf->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mdp = :mdp");

    $sth->bindvalue(':email', $_POST['email'], PDO::PARAM_STR);
    $sth->bindvalue(':mdp', $_POST['mdp'], PDO::PARAM_STR);

    $sth->execute();
    $count = $sth->rowCount();
//            print_r($sth);

    if ($count > 0) {
        
        $tabUser = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        $sid = md5($tabUser[0]['email'] . time()); //variable aleatoire
        //print_r($tabUser);
        //echo "valeur de SID : ". $sid;
        $id=$tabUser[0]['id'];
        //echo "valeur de l'ID : ".$id;
        $sql = $bddf->prepare("UPDATE utilisateurs SET sid=:sid WHERE id=:id");
        $sql->bindvalue(':sid', $sid, PDO::PARAM_STR);
        $sql->bindvalue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        
        
        setcookie('sid', $sid, time() + 5*60); // definir le cookie
        
        
        header("location: Index.php");
    } else {
        echo 'erreur dans le formulaire';
        header("location: connexion.php");
    }
} else {
// put your code here
    

//** un-comment the following line to show the debug console
// $smarty->debugging = true;

$smarty->display('connexion.tpl');
include_once 'includes/menu.inc.php';
include_once 'includes/footer.inc.php';    
}
?>

    