<?php
include 'conf.php';

// Set timezone to Sri Lanka Standard Time
date_default_timezone_set('Asia/Colombo');

// Function to generate the HTML preview of the report
function generateReportPreview($result, $creationTime, $createdBy) {
    $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Mico Organic - Daily Report</title>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; background-color: white; }
                    .header { background-color: #4CAF50; padding: 10px; color: white; text-align: center; }
                    .header h1 { margin: 0; font-size: 2em; }
                    .header h3 { margin: 5px 0; font-style: italic; }
                    .header img { width: 100px; height: auto; margin-bottom: 10px; } 
                    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; }
                    .table th { background-color: #4CAF50; color: white; }
                    .table tr:nth-child(even) { background-color: #f2f2f2; }
                    .summary { margin-top: 30px; border: 1px solid #ddd; padding: 10px; }
                    .summary th { background-color: #4CAF50; color: white; }
                    .summary td { padding: 8px; text-align: right; }
                    .footer { text-align: center; margin-top: 30px; font-size: 0.9em; }
                    .footer a { color: #4CAF50; text-decoration: none; }
                    
                    @media print {
                        .print-button {
                            display: none !important;
                        }
                            .back-button {
                            display: none !important;
                        }
                    }

                    .print-button {
                        background-color: #4CAF50;
                        color: white;
                        padding: 10px 20px;
                        font-size: 1em;
                        border: none;
                        cursor: pointer;
                        border-radius: 5px;
                        margin-top: 20px;
                        display: inline-block;
                    }

                    .print-button:hover {
                        background-color: #45a049;
                    }

                    .print-button:active {
                        background-color: #39843c;
                    }

                    /* Style for the Back button */
                    .back-button {
                        background-color: #39843c; /* Red */
                        color: white;
                        padding: 10px 20px;
                        font-size: 1em;
                        border: none;
                        cursor: pointer;
                        border-radius: 5px;
                        margin-top: 20px;
                        display: inline-block;
                    }

                    .back-button:hover {
                        background-color: #39843c;
                    }

                    .back-button:active {
                        background-color: #39843c;
                    }
                </style>
                <script>
                    function printReport() {
                        window.print();
                    }

                    function goBack() {
                        window.history.back(); // Navigate to the previous page
                    }
                </script>
            </head>
            <body>
                <div class="header">
                    <img src="https://micoceylonorganics.lk/assets/img/mico.png" alt="Mico Organic Logo"> 
                    <h1>Mico Organic</h1>
                    <h3>Daily Report</h3>
                    <p class="meta-info"> Created by: ' . $createdBy . ' | Created on: ' . $creationTime . ' </p>                    
                </div>
                
                <table class="table">
                    <tr>
                        <th>Date</th>
                        <th>Material ID</th>
                        <th>Product ID</th>
                        <th>Material Stock</th>
                        <th>Product Stock</th>
                    </tr>';

    $totalMaterial = 0;
    $totalProduct = 0;

    while ($report = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $report['date'] . '</td>';
        $html .= '<td>' . $report['mid'] . '</td>';
        $html .= '<td>' . $report['pid'] . '</td>';
        $html .= '<td>' . number_format($report['mstock'], 2) . '</td>';
        $html .= '<td>' . number_format($report['pstock'], 2) . '</td>';
        $html .= '</tr>';

        $totalMaterial += $report['mstock'];
        $totalProduct += $report['pstock'];
    }

    $materialBalance = $totalMaterial - $totalProduct;

    $html .= '</table>';
    $html .= '<div class="summary">
                <h3>Summary of Stock Report</h3>
                <table>
                    <tr><th>Total Material</th><th>Total Product</th><th>Material Balance</th></tr>
                    <tr>
                        <td>' . number_format($totalMaterial, 2) . '</td>
                        <td>' . number_format($totalProduct, 2) . '</td>
                        <td>' . number_format($materialBalance, 2) . '</td>
                    </tr>
                </table>
              </div>';

    $html .= '<div class="footer">
                <p>&copy; ' . date('Y') . ' Mico Organic. All rights reserved.</p>
                <p><a href="#">www.micoorganic.com</a></p>
              </div>
            </body>
            </html>';

    return $html;
}

$reportId = $_POST['report_id'] ?? '';
$startDate = $_POST['start_date'] ?? '';
$endDate = $_POST['end_date'] ?? '';

$query = "SELECT * FROM edaily WHERE 1=1";
$params = [];
$types = '';

if ($reportId) {
    $query .= " AND id = ?";
    $params[] = $reportId;
    $types .= 'i';
}

if ($startDate) {
    $query .= " AND date >= ?";
    $params[] = $startDate;
    $types .= 's';
}

if ($endDate) {
    $query .= " AND date <= ?";
    $params[] = $endDate;
    $types .= 's';
}

$stmt = $conn->prepare($query);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$creationTime = date('Y-m-d H:i:s');
$createdBy = 'Employee';

$reportPreview = generateReportPreview($result, $creationTime, $createdBy);

echo $reportPreview;
echo '<input type="button" class="print-button" value="Print Report" onclick="printReport()">';
echo '<input type="button" class="back-button" value="Back" onclick="goBack()">';
?>
