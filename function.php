<?php
function generateTableHTML($data, $isTransposed = false) {
    $html = "<table class='table'>";
    if ($isTransposed) {
        // Display the transposed data
        foreach ($data as $colKey => $colData) {
            $html .= "<tr>";
            $html .= "<th>$colKey</th>";
            foreach ($colData as $value) {
                $html .= "<td>$value</td>";
            }
            $html .= "</tr>";
        }
    } else {
        // Display the original data
        if (!empty($data)) {
            $html .= "<tr>";
            foreach (array_keys($data[0]) as $header) {
                $html .= "<th scope='col'>$header</th>";
            }
            $html .= "</tr>";
            foreach ($data as $row) {
                $html .= "<tr>";
                foreach ($row as $value) {
                    $html .= "<td>$value</td>";
                }
                $html .= "</tr>";
            }
        }
    }
    $html .= "</table>";
    return $html;
}
?>