<?php
function generateTableHTML($data, $switched) {
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
    echo '<div class="originalTable" style="display: block;">';
    echo generateTableHTML($normal, false);
    echo '</div>';
    echo '<div class="transposedTable" style="display: none;">';
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
    echo "[{$_SESSION['sel_from']}]";
    $_SESSION['from_end']=substr($query, $i+5, $len-$i+4);
    echo "[{$_SESSION['from_end']}]";
    $_SESSION['cols'] = [];
    if($_SESSION['sel_from'] === '*'){
        foreach (array_keys($_SESSION['normal'][0]) as $header) {
            array_push($_SESSION['cols'], $header);
        }
    }
    else{
        $_SESSION['cols'] = explode(",", $_SESSION['sel_from']);
        $_SESSION['cols'] = array_map("trim", $_SESSION['cols']);
    }
    foreach($_SESSION['cols'] as $col){
        echo "[$col]";
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
// function ExecuteQuery($conn, $query, &$normal, &$switched)
// {
//     $res = $conn->query($query);
//     if ($res) {
//         $fields = [];
//         while ($field = $res->fetch_field()) {
//             $fields[] = $field->table . '.' . $field->name;
//         }

//         $resNormal = [];
//         while ($row = $res->fetch_assoc()) {
//             $formattedRow = [];
//             foreach ($fields as $field) {
//                 list($table, $name) = explode('.', $field);
//                 $formattedRow[$field] = $row[$name];
//             }
//             $resNormal[] = $formattedRow;
//         }

//         $resSwitched = [];
//         foreach ($resNormal as $rowKey => $row) {
//             foreach ($row as $colKey => $value) {
//                 $resSwitched[$colKey][$rowKey] = $value;
//             }
//         }

//         $normal = $resNormal;
//         $switched = $resSwitched;
//     } else {
//         die("Query failed: " . $conn->error);
//     }
// }
function GetDataType($conn, $databaseName, $tableName, $columnName){
    if (substr($tableName, 0, 1) === '`' && substr($tableName, -1) === '`') {
        // Remove the backticks
        $tableName = substr($tableName, 1, -1);
    }
    $query = "select data_type from information_schema.columns ";
    $query .= "where lower(table_name) = lower('$tableName') and ";
    $query .= "lower(column_name) = lower('$columnName')";
    echo $query;
    $res = mysqli_query($conn, $query);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $dataType = $row['data_type'];
        echo "Data type of column '$columnName' in table '$tableName' is: $dataType";
    } else {
        echo "Column '$columnName' not found in table '$tableName' or database '$databaseName'.";
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
function CaseFilter($conn, $dataType, $caseCol, $caseOpt, $caseValue, $caseColOrderBy, $caseOrderByType){
    echo "[$dataType]";
    $query = "select {$_SESSION['sel_from']} ";
    $query .= "from {$_SESSION['from_end']} ";
    if($dataType === "numeric"){
        $query .= "where $caseCol $caseOpt $caseValue";
    }
    elseif($dataType === "text"){
        $query .= "where $caseCol $caseOpt '$caseValue'";
    }
    elseif($dataType === "year"){
        $query .= "where year($caseCol) $caseOpt $caseValue";
    }
    $query .= " order by $caseColOrderBy $caseOrderByType";
    echo "[$query]";
    // GetDataType($conn, $_SESSION['db_name'], $_SESSION['from_end'], $caseCol);
    ExecuteQuery($conn,$query,$_SESSION['temp'],$_SESSION['tempSwitched']);
}
function generateDownloadForm($table1, $table2) {
    $table1Json = json_encode($table1);
    $table2Json = json_encode($table2);

    echo "
    <form id='downloadForm' method='post' action='download.php'>
        <input type='hidden' name='tableToDownload' id='tableToDownload' value='table1'>
        <input type='hidden' name='table1Data' value='<?php echo htmlspecialchars($table1Json, ENT_QUOTES, 'UTF-8'); ?>'>
        <input type='hidden' name='table2Data' value='<?php echo htmlspecialchars($table2Json, ENT_QUOTES, 'UTF-8'); ?>'>
        <button type='submit'>Download Current View as Excel</button>
    </form>";

}

?>