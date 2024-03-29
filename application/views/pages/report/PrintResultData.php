<?php
class Coba extends FPDF {

    public function Footer()
    {
           $this->SetY(-40);
           $this->SetLeftMargin(40);
           $this->Ln(1);
           $this->SetLineWidth(1,5);
           $this->Line(42,800,578,800);
		   $this->SetFont('Arial','I',6);
		   $this->Cell(300,10,'Print at '.date('d/m/Y').' | &copy;  CBN Business Profile',0,0,'L');
		   $this->Cell(250,10,'Page '.$this->PageNo().' from {nb}',0,0,'R'); 
    }
}

	$pdf = new Coba('P', 'pt', 'A4'); 
	$pdf->AliasNbPages();
	$pdf->SetTopMargin(30);
	$pdf->SetLeftMargin(20);
	$pdf->SetRightMargin(20);
	$pdf->SetAutoPageBreak(true, 50);

	$pdf->AddPage();
	$pdf->Image('./logo/cbn-logo.png',32,25,35);
	//$pdf->Image('./logo/cbn.png',470,105,110);
	$pdf->SetFont('Times','B',14);
	$pdf->Cell(70);
	$pdf->Cell(500,10,'PT. CYBERINDO ADITAMA',0,0,'L');
	$pdf->Ln(14);
	$pdf->SetFont('Times','',12);
	$pdf->Cell(70);
	$pdf->Cell(500,10,'C B N  B U S I N E S S  P R O F I L E',0,0,'L');
	$pdf->Ln(14);
	$pdf->Cell(70);
	$pdf->SetFont('Times','I',9);
	$pdf->Cell(500,10,'Jalan H.R Rasuna Said Blok X5 No. 13 Jakarta Selatan - 12950',0,0,'L');
	$pdf->SetLineWidth(1);
	$pdf->Line(20,72,580,72);
	$pdf->SetLineWidth(1,5);
	$pdf->Line(20,74,580,74);

	$pdf->SetY(85);
	$pdf->SetFont('Times', 'BU', 11); 
	$pdf->Cell(0,10,$title,0,0,'C');
	$pdf->Ln(15);

	$pdf->SetLeftMargin(35);
	$pdf->Ln(15);
	$pdf->SetFont('Times', '', 10);

	if (!empty($dSearch)) {
		$no = 0;
		$count = count($dSearch);
		$pdf->Cell(80,10,'Total data based on keyword "'.$keyword.'" : '.$count,0,0,'L');
		$pdf->Ln(20);
		foreach ($dSearch as $key) {
			$no++;
			$pdf->Cell(60,10,'No : '.$no,0,0,'L');
			$pdf->Ln(20);
			foreach ($dField as $key2){
				$name = $key2->name;
				$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
				$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
				if(empty($key->$name)){
						$show = 'NULL';
					}else{
						$show = $key->$name;
					}
				if ($key2->type == 'date') {

				$pdf->Cell(150,10,ucwords($pass2),0,0,'L');
				$pdf->Cell(10,10,':',0,0,'L');
				$pdf->Cell(150,10,date_format(date_create($show), 'd F Y'),0,0,'L');
				$pdf->Ln(15);
				
				}elseif ($key2->type == 'text') {
				
				$pdf->Cell(150,10,ucwords($pass2),0,0,'L');
				$pdf->Cell(10,10,': ',0,0,'L');
				$pdf->MultiCell(220,15,strip_tags($show),0,'L');
				$pdf->Ln(15);
				
				}else{
				$pdf->Cell(150,10,ucwords($pass2),0,0,'L');
				$pdf->Cell(10,10,':',0,0,'L');
				$pdf->Cell(150,10,$show,0,0,'L');
				$pdf->Ln(15);
				}
			}
			$pdf->Ln(20);
		}
	}
	$pdf->Ln(45);

	$pdf->Output($title.'-'.date('dFY').'.pdf','I');


?>logo