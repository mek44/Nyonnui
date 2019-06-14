<?php
header( 'content-type: text/html; charset=utf-8' );
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
	$libelle='';
	if($classe['niveau']!=13)
	{
		$libelle=$classe['niveau'];
		if($classe['niveau']==1)
			$libelle.=' ';
		else
			$libelle.=' ';
	}
	else
		$libelle=' ';
	
	if($classe['niveau']>10)
		$libelle.=$classe['option_lycee'];

	$libelle.=$classe['intitule'];
	
	return $libelle;
}