<?php
require('fpdf.php');

class PDF extends FPDF
{
	protected $col = 0; // Colonne courante
	protected $y0;    
	// En-tête
	function Header()
	{
		// Logo
		//$this->Image('logo.jpg',10,6,30);
		// Police Arial gras 15
		$this->SetFont('Arial','B',18);
		// Décalage à droite
		$this->Cell(30);
		// Titre
		$this->Cell(30,10,strtoupper('récu de paiement'),0,1,'CU');
		$this->Cell(30,10, $_GET['ecole'],0,1,'CU');
		//$this->Image('firstlady.jpg', 180, 20, 15);
		// Saut de ligne
		$this->Ln(10);
	}
	
	/*function SetCol($col)
	{
		// Positionnement sur une colonne
		$this->col = $col;
		$x = 10+$col*65;
		$this->SetLeftMargin($x);
		$this->SetX($x);
	}*/

	function AcceptPageBreak()
	{
		// Méthode autorisant ou non le saut de page automatique
		if($this->col<2)
		{
			// Passage à la colonne suivante
			$this->SetCol($this->col+1);
			// Ordonnée en haut
			$this->SetY($this->y0);
			// On reste sur la page
			return false;
		}
		else
		{
			// Retour en première colonne
			$this->SetCol(0);
			// Saut de page
			return true;
		}
	}
}



// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(10, 10, 'Date de paiement:'.$_GET['date'], 0, 1);

$pdf->Ln(1);
$pdf->Cell(10, 10, 'Mois: '.$_GET['mois'], 0, 1);

$pdf->Ln(1);
$pdf->Cell(10, 10, 'Reçu: '.$_GET['recu'], 0, 1);


$pdf->Ln(1);
$pdf->Cell(10, 10, 'Matricule: '.$_GET['matricule'], 0, 1);

$pdf->Ln(1);
$pdf->Cell(10, 10, 'Nom: '.$_GET['nom'], 0, 1);

$pdf->Cell(1);
$pdf->Cell(10, 10, 'Classe: '.$_GET['classe'], 0, 1);


$pdf->Cell(1);
$pdf->Cell(10, 10, 'Montant payé: '.$_GET['montant'], 0, 1);

$pdf->Cell(1);
$pdf->Cell(10, 10, 'Réduction: '.$_GET['reduction'], 0, 1);

$pdf->Output();
?>
