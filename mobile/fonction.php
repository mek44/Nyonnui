<?php
function getAnneeScolaire()
{
    if(isset($_COOKIE['annee'])){
        $anneeScolaire=$_COOKIE['annee'];
    }else{
        $mois=date('m');
        $annee=date('Y');

        if($mois>=9){
            $anneeScolaire=$annee.'-'.($annee+1);
        }else{
            $anneeScolaire=($annee-1).'-'.$annee;
        }
    } 
    
    return $anneeScolaire;
}

/******************************************
 * Fonction développée par JP HORN
 * permet de définir les différents niveaux dans une école
 * selon le niveau de la classe
 */
function getLevels($idEcole){
    global $base;
    $prepare=$base->prepare('SELECT n.Libelle, n.niveau FROM niveau as n INNER JOIN classe as c ON c.niveau=n.niveau WHERE c.id_ecole=:idEcole GROUP BY c.niveau ORDER BY n.niveau;');
    $prepare->execute([
        'idEcole'=>$idEcole
    ]);
    $resultat = $prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}
/*******************************
 * Fonction développée par JPHORN
 * permet de récupérer et définir les frais de scolarité à payer par enfant 
 * en fonction de la classe.
 * 
 */
function getScolarites($idEcole, $annee){
    global $base;
    $niveau = getLevels($idEcole);
    $prepare = $base->prepare('SELECT * FROM frais_scolarite_niveau WHERE id_ecole=:idEcole AND annee=:annee;');
    $resultat = $prepare->fetchAll();
    $prepare->closeCursor();
    return $resultat;
}

function getInfoClasse($id)
{
    global $base;
    $prepare=$base->prepare('SELECT niveau, intitule, option_lycee FROM classe WHERE id=?');
    $prepare->execute([$id]);
    $resultat=$prepare->fetch();
    $prepare->closeCursor();
    return $resultat;
}


function parseReel($nombre){
	$chaine=''.$nombre;
	$chaine=str_replace('.', ',', $chaine);
	$table=explode(',', $chaine);
	$entier=$table[0];
	$decimal='';
	if(count($table)>1)
		$decimal=$table[1];
	
	$chaine=$entier.",";
	for($i=0; $i<2 && $i<strlen($decimal); $i++){
		$chaine.=$decimal[$i];
	}
	
	if(strlen($decimal)<=1)
		$chaine.="0";
	
	return $chaine;
}
	
function formatageMontant($montant)
{
    $chaine=(string)$montant;
    $format='';
    $reste=strlen($chaine)%3;

    if(strlen($chaine)>3)
    {
        if($reste==1)
        {
            $format.=$chaine[0];
            $format.=' ';
        }
        else if($reste==2)
        {
            $format.=$chaine[0];
            $format.=$chaine[1];
            $format.=' ';
        }
    }
    else
    {
        return $chaine;
    }

    $compteur=0;
    for($i=$reste; $i<strlen($chaine); $i++)
    {
        $format.=$chaine[$i];
        $compteur++;
        if($compteur==3)
        {
            $format.=' ';
            $compteur=0;
        }
    }

    return $format;
}


function formatClasse($classe)
{
    $libelle=$classe['niveau'].' ';
/*    if($classe['niveau']!=13)
    {
        $libelle=$classe['niveau'];
        if($classe['niveau']==1)
                $libelle.='ère ';
        else
                $libelle.='ème ';
    }
    else
        $libelle='Terminal';
*/
    if($classe['niveau']>10)
        $libelle.=$classe['option_lycee'];

    $libelle.=$classe['intitule'];

    return $libelle;
}