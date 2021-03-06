<?php
require('fpdf17/fpdf.php');
$con=mysqli_connect('localhost','root','syp3523','jimarketie');
mysqli_select_db($con,'phpfpdftutorial');


class PDF extends FPDF {
	function Header(){
		$this->SetFont('Arial','B',15);
		
		//dummy cell to put logo
		//$this->Cell(12,0,'',0,0);
		//is equivalent to:
		$this->Cell(12);
		
		//put logo
		$this->Image('jimarketielogo.png',13,15,15);
		
		$this->Cell(100,10,'Jimarketie Products',0,1);
		
		//dummy cell to give line spacing
		//$this->Cell(0,5,'',0,1);
		//is equivalent to:
		$this->Ln(5);
		
		$this->SetFont('Arial','B',11);
		
		$this->SetFillColor(180,180,255);
		$this->SetDrawColor(180,180,255);
		$this->Cell(40,5,'Product Name',1,0,'',true);
		$this->Cell(40,5,'Sub-Category',1,0,'',true);
		$this->Cell(25,5,'Price',1,0,'',true);
		$this->Cell(65,5,'featured',1,0,'',true);
		// $this->Cell(60,5,'deleted',1,1,'',true);
		$this->Cell(60,5,'status',1,1,'',true);
		
	}
	function Footer(){
		//add table's bottom line
		$this->Cell(190,0,'','T',1,'',true);
		
		//Go to 1.5 cm from bottom
		$this->SetY(-15);
				
		$this->SetFont('Arial','',8);
		
		//width = 0 means the cell is extended up to the right margin
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}
}


//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new PDF('P','mm','A4'); //use new class

//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();

$pdf->SetFont('Arial','',9);
$pdf->SetDrawColor(180,180,255);

$query=mysqli_query($con,"SELECT * FROM products INNER JOIN sub_category ON products.subcategory_id=sub_category.subcategory_id
 WHERE deleted=1");
while($data=mysqli_fetch_array($query)){
	$pdf->Cell(40,5,$data['product_name'],'LR');
	$pdf->Cell(40,5,$data['subcategory_name'],'LR');///,0);
	$pdf->Cell(25,5,$data['product_price'],'LR');//,0);
	$pdf->Cell(60,5,$data['featured'],'LR');//,1);
	// $pdf->Cell(25,5,$data['deleted'],'LR',0);
	$pdf->Cell(60,5,$data['status'],'LR',1);
		}

$pdf->Output();
?>
