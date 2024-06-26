<?php
function generateTableHTML($data, $switched = false) {
    $html = "<table class='table table-striped'>";
    if ($switched) {
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

function ParseQuery($query){
    $query = strtolower($query);
    $len = strlen($query);

    $i=7;
    while(substr($query, $i, 4)!=="from"){
        if($i > $len) break;
        $i++;
    }
    $_SESSION['sel_from']=substr($query, 7, $i-8);
    $_SESSION['from_end']=substr($query, $i+5, $len-$i+4);
    ParseColumns($_SESSION['sel_from']);
    if($_SESSION['sel_from'] === '*'){
        $_SESSION['sel_from'] = [];
        foreach (array_keys($_SESSION['normal'][0]) as $header) {
            array_push($_SESSION['sel_from'], $header);
        }
    }
}
function ParseColumns($col){
    $len = strlen($col);
    $i=0;
    $_SESSION['cols'] = explode(",",$col);
    
}
?>