<?php
$pageValide=false;

if(isset($_SESSION['user']) && isset($_SESSION['annee']))
{
    include_once('modele/connexion_base.php');
    include_once('modele/controle_presence.php');
    include_once('fonction.php');

    if($_SESSION['user']['nom_fonction']=='Directeur général' || $_SESSION['user']['nom_fonction']=='Proviseur' || $_SESSION['user']['nom_fonction']=='Principal' ||
                    $_SESSION['user']['nom_fonction']=='Directeur' || $_SESSION['user']['nom_fonction']=='Enseignant'){
        $pageValide=true;
        
        $mois=date('m');
        $annee=date('Y');
        $jour=date('d');

        $date=date('Y-m-d');

        if($_SESSION['user']['nom_fonction']==='Enseignant'){
            $listeClasse= getClasseEnseignant($_SESSION['user']);
        }else{
            $listeClasse=getListeClasse($_SESSION['user']['idEcole']);
        }

        $listeEleve=[];
        $periode=[];
        if(count($listeClasse)>0){
            $periodes=getPeriode($listeClasse[0]['id'], date('w'), $_SESSION['annee']);
            $periode='';
            if(is_array($periodes) && count($periodes)>0){
                $periode=$periodes[0]['debut'].' - '.$periodes[0]['fin'];
            }
            $listeEleve=getListeEleve($listeClasse[0]['id'], $_SESSION['annee'], $date, $periode);
        }
    }
}

include_once('vue/controle_presence.php');
