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

function table($normal, $switched){
    echo '<div id="originalTable" style="display: block;">';
    echo generateTableHTML($normal);
    echo '</div>';
    echo '<div id="transposedTable" style="display: none;">';
    echo generateTableHTML($switched, true);
    echo '</div>';
}

function ParseQuery($query){
    $_SESSION['submittedQuery'] = $query;
    $query = strtolower($query);
    $len = strlen($query);

    $i=7;
    while(substr($query, $i, 4)!=="from"){
        if($i > $len) break;
        $i++;
    }
    $_SESSION['sel_from']=substr($query, 7, $i-8);
    $_SESSION['from_end']=substr($query, $i+5, $len-$i+4);

    if($_SESSION['sel_from'] === '*'){
        $_SESSION['cols'] = [];
        foreach (array_keys($_SESSION['normal'][0]) as $header) {
            array_push($_SESSION['cols'], $header);
        }
    }
    else{
        $_SESSION['cols'] = explode(",", $$_SESSION['sel_from']);
    }
}
function ExecuteQuery($conn, $query, &$normal, &$switched)
{
    $res = $conn->query($query);
    if($res){
        $resNormal = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $resNormal[] = $row;
        }
        $resSwitched = [];
        foreach ($resNormal as $rowKey => $row) {
            foreach ($row as $colKey => $value) {
                $resSwitched[$colKey][$rowKey] = $value;
            }
        }
        $normal = $resNormal;
        $switched = $resSwitched;
    }
}

function GroupBy($conn, $aggregate, $aggregateCol, $groupbyCol){
    $query = "select $groupbyCol, ";
    $query .= "$aggregate($aggregateCol) ";
    $query .= "from {$_SESSION['from_end']} ";
    $query .= "group by $groupbyCol";
    echo "[$query]";
    ExecuteQuery($conn,$query,$_SESSION['temp'],$_SESSION['tempSwitched']);
}
function CaseFilter($conn, $caseCol, $caseOpt, $caseYear){
    $query = "select {$_SESSION['sel_from']} ";
    $query .= "from {$_SESSION['from_end']} ";
    $query .= "where year($caseCol) $caseOpt $caseYear";
    echo "[$query]";
    ExecuteQuery($conn,$query,$_SESSION['temp'],$_SESSION['tempSwitched']);
}
?>