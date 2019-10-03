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
		   $this->Cell(300,10,'Print at '.date('d/m/Y').' | &copy;  CBN Internship',0,0,'L');
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
	$pdf->Image('./logo/cbn.png',470,105,110);
	$pdf->SetFont('Times','B',14);
	$pdf->Cell(70);
	$pdf->Cell(500,10,'PT. CYBERINDO ADITAMA',0,0,'L');
	$pdf->Ln(14);
	$pdf->SetFont('Times','',12);
	$pdf->Cell(70);
	$pdf->Cell(500,10,'C B N  I N T E R N S H I P',0,0,'L');
	$pdf->Ln(14);
	$pdf->Cell(70);
	$pdf->SetFont('Times','I',9);
	$pdf->Cell(500,10,'Jalan H.R Rasuna Said Blok X5 No. 13 Jakarta Selatan - 12950',0,0,'L');
	$pdf->SetLineWidth(1);
	$pdf->Line(20,72,580,72);
	$pdf->SetLineWidth(1,5);
	$pdf->Line(20,74,580,74);

	if ($dtscope->isTaken == '0') {
		$status = 'Tutup';
	}else{
		$status = 'Buka';
	}

	$pdf->SetY(85);
	$pdf->SetFont('Times', 'BU', 11); 
	$pdf->Cell(0,10,$title,0,0,'C');
	$pdf->Ln(15);

	$pdf->SetLeftMargin(35);
	$pdf->Ln(15);
	$pdf->SetFont('Times', '', 10);
	$pdf->Cell(170,10,'Bagian Kerja',0,0,'L');
	$pdf->Cell(10,10,':',0,0,'L');
	$pdf->Cell(150,10,$dtscope->projectScope,0,0,'L');
	$pdf->Ln(15);
	$pdf->Cell(170,10,'Projek',0,0,'L');
	$pdf->Cell(10,10,':',0,0,'L');
	$pdf->Cell(150,10,name_project($dtscope->projectID),0,0,'L');
	$pdf->Ln(15);
	$pdf->Cell(170,10,'Departemen',0,0,'L');
	$pdf->Cell(10,10,':',0,0,'L');
	$pdf->Cell(150,10,name_dept($dtscope->deptID),0,0,'L');
	$pdf->Ln(15);
	$pdf->Cell(170,10,'Kategori',0,0,'L');
	$pdf->Cell(10,10,': ',0,0,'L');
	$pdf->Cell(150,10,name_category($dtscope->categoryID),0,0,'L');
	$pdf->Ln(15);
	$pdf->Cell(170,10,'Deskripsi',0,0,'L');
	$pdf->Cell(10,10,': ',0,0,'L');
	$pdf->MultiCell(220,15,strip_tags($dtscope->description),0,'L');
	$pdf->Cell(170,10,'Kualifikasi',0,0,'L');
	$pdf->Cell(10,10,': ',0,0,'L');
	$pdf->MultiCell(220,15,strip_tags($dtscope->qualification),0,'L');
	$pdf->Ln(15);
	$pdf->Cell(170,10,'Tanggal Mulai',0,0,'L');
	$pdf->Cell(10,10,': ',0,0,'L');
	$pdf->Cell(150,10,date_format(date_create($dtscope->startDate), 'd F Y'),0,0,'L');
	$pdf->Ln(15);
	$pdf->Cell(170,10,'Tanggal Berakhir',0,0,'L');
	$pdf->Cell(10,10,': ',0,0,'L');
	$pdf->Cell(150,10,date_format(date_create($dtscope->endDate), 'd F Y'),0,0,'L');
	$pdf->Ln(15);
	$pdf->Cell(170,10,'Kebutuhan',0,0,'L');
	$pdf->Cell(10,10,': ',0,0,'L');
	$pdf->Cell(150,10,$dtscope->reqQuantity.' orang',0,0,'L');
	$pdf->Ln(15);
	$pdf->Cell(170,10,'Status',0,0,'L');
	$pdf->Cell(10,10,': ',0,0,'L');
	$pdf->Cell(150,10,$status,0,0,'L');
	$pdf->Ln(15);
	$pdf->Ln(45);

	$pdf->Output($dtscope->projectScope.'-'.date('dFY').'.pdf','I');


?>logo