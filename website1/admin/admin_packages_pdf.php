<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

require('fpdf/fpdf.php');
include('../db.php'); // <-- Your DB connection file

// Create a new PDF instance
$pdf = new FPDF();
$pdf->AddPage();

// Set title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'All Tour Packages', 0, 1, 'C');
$pdf->Ln(10);

// Fetch all packages
$query = "SELECT * FROM packages";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Place Name: " . $row['place_name'], 0, 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Package Name: " . $row['package_name'], 0, 1);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, "DAY1: " . $row['day1'], 0, 1);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, "DAY2: " . $row['day2'], 0, 1);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 8, "DAY3: " . $row['day3'], 0, 1);
        
        if (!empty($row['image'])) {
            $imagePath = 'uploads/' . $row['image'];
            if (file_exists($imagePath)) {
                $pdf->Image($imagePath, 10, $pdf->GetY() + 2, 50, 40);
                $pdf->Ln(42);
            }
        }
        
        $pdf->Ln(10);
        $pdf->Cell(0, 0, str_repeat('-', 150), 0, 1); // Separator line
        $pdf->Ln(10);
    }
} else {
    $pdf->Cell(0, 10, 'No packages found!', 0, 1);
}

$pdf->Output('D', 'All_Packages.pdf'); // D = Download
?>
