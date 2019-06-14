<?php
include 'modele/connexion_base.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if(isset($_GET['libelle'])){
    $idEcole = $_SESSION['user']['idEcole'];
    $libelle = $_GET['libelle'];
    $prepare = $base->prepare('INSERT INTO type_scolarite (id_ecole, libelle) VALUES(:idEcole, :libelle);');
    $prepare->execute([
        'idEcole'=>$idEcole,
        'libelle'=>$libelle
    ]);
}
