<?php

class PDFWrapper extends FPDF {
	function createGroupReport($details) {
		$this->AddPage();
		$this->Image(IMG_PATH . 'logo.png', 15, 10, 30);
		$this->SetFont('Arial','B',16);
		$this->Cell(0,10, $details[0]['group_code'] . ': Grade Report', 0, 1, 'C');
		foreach ($details as $item) {
			$this->SetFont('Arial','', 15);
			$this->Cell(0, 20, $item['assessment_title'],0, 1, 'C');
			$header = ['Student ID', 'Student Name', 'Result'];
			$this->BasicTable($header, $item['students']);
			$this->SetFont('Arial','B',12);
			$this->Cell(45, 10, 'Average:', 0, 0, 'R');
			$this->SetFont('Arial','',12);
			$this->Cell(45, 10, $this->avg($item['students']), 0, 0, 'L');
			$this->SetFont('Arial','B',12);
			$this->Cell(45, 10, 'Median:', 0, 0, 'R');
			$this->SetFont('Arial','',12);
			$this->Cell(45, 10, $this->median($item['students']), 0, 0, 'L');
			$this->Cell(0, 10, '', 0, 1);
		}
	}

	function Footer() {				
    	// Position at 1.5 cm from bottom
    	$this->SetY(-15);
    	// Arial italic 8
    	$this->SetFont('Arial','I',12);
    	// Text color in gray
    	$this->SetTextColor(128);
    	// Page number
    	$this->Cell(0,10,'Online Gradebook',0,0,'C');
	}

	function BasicTable($header, $data)
	{
    	// Header
    	$this->SetFont('Arial','B', 11);
    	$this->Cell(5, 6, '', 0, 0);
    	foreach($header as $col)
        	$this->Cell(60,7,$col,'B', 0, 'C');
    	$this->Ln();
    	$this->SetFont('Arial','', 11);
    	foreach($data as $row) {
    		if (empty($row['result'])) {
    			$x = '-';
    		} else {
    			$x = $row['result'][0]['grade'];
    		}
    		$this->Cell(5, 6, '', 0, 0);
            $this->Cell(60,8,$row['student_id'],'B', 0, 'C');
            $this->Cell(60,8,$row['user']['user_fullname'],'B', 0, 'C');
            $this->Cell(60,8,$x,'B', 0, 'C');
        	$this->Ln();
    	}
	}

	private function avg($details) {
		$res = 0;
		$num = 0;
		foreach ($details as $row) {
			if (empty($row['result'])) {
				continue;
			} else {
				$x = intval($row['result'][0]['grade']);
				$res += $x;
				$num++;
			}
		}

		if ($num === 0) {
			return 0;
		} else {
			return number_format($res / $num, 2, '.', '');
		}
	}

	private function median($details) {
		$numbers = [];
		foreach ($details as $row) {
			if (empty($row['result'])) {
				continue;
			} else {
				$x = intval($row['result'][0]['grade']);
				array_push($numbers, $x);
			}
		}

		if (empty($numbers)) {
			return 0;
		}

		sort($numbers);
		if (count($numbers) == 2) {
			return ($numbers[0] + $numbers[1]) / 2;
		} else if (count($numbers) == 1) {
			return $numbers[0];
		}

		$mid = intval((count($numbers) / 2));
		if ($mid % 2 != 0) {
			$res = $numbers[$mid];
		} else {
			$res = $numbers[$mid-1] + $numbers[$mid];
			$res /= 2;
		}
		return number_format($res, 2, '.', '');
	}

}