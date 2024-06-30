<?php
function generateTableHTML($data, $isPivoted = false) {
    $html = "<table class='table table-striped'>";
    if ($isPivoted) {
        // $html .= ">";
        foreach ($data as $colKey => $colData) {
            $html .= "<tr>";
            $html .= "<th>$colKey</th>";
            foreach ($colData as $value) {
                $html .= "<td>$value</td>";
            }
            $html .= "</tr>";
        }
    } else {
        if (!empty($data)) {
            // $html .= "id='toDownload'>";
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

function table($unpivoted, $pivoted){
    echo '<div class="unpivotedDiv" style="display: block;">';
    echo generateTableHTML($unpivoted, false);
    echo '</div>';
    echo '<div class="pivotedDiv" style="display: none;">';
    echo generateTableHTML($pivoted, true);
    echo '</div>';
}
function ExecuteQuery($conn, $query, &$unpivoted, &$pivoted)
{
    $res = $conn->query($query);
    if($res){
        $res_unpivoted = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $res_unpivoted[] = $row;
        }
        $res_pivoted = [];
        foreach ($res_unpivoted as $rowKey => $row) {
            foreach ($row as $colKey => $value) {
                $res_pivoted[$colKey][$rowKey] = $value;
            }
        }
        $unpivoted = $res_unpivoted;
        $pivoted = $res_pivoted;
    }
}

function GroupBy($conn, $aggregate, $aggregateCol, $groupbyCol){
    $query = "select $groupbyCol, ";
    $query .= "$aggregate($aggregateCol) ";
    $query .= "from `{$_SESSION['table']}` ";
    $query .= "group by $groupbyCol";
    // echo "[$query]";
    ExecuteQuery($conn,$query,$_SESSION['unpivoted_groupBy'],$_SESSION['pivoted_groupBy']);
}
function CaseFilter($conn, $dataType, $caseCol, $caseOpt, $caseValue, $caseColOrderBy, $caseOrderByType){
    // echo "[$dataType]";
    $query = "select {$_SESSION['selectedColumnsText']} ";
    $query .= "from `{$_SESSION['table']}` ";
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
    // echo "[$query]";
    ExecuteQuery($conn,$query,$_SESSION['unpivoted_case'],$_SESSION['pivoted_case']);
}

function getPermissions($inputUsername, $inputPassword) {
    if (($handle = fopen("user.csv","r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $cur_username = $data[0];
            $cur_password = $data[1];
            $permissions = $data[2];
            // echo "<p>$inputUsername $cur_username | $inputPassword $cur_password</p>";
            if ($cur_username == $inputUsername && $cur_password == $inputPassword) {
                $permissionsArray = explode(',', $permissions);
                // foreach($permissionsArray as $p){
                //     echo "<p>[$p]</p>";
                // }
                fclose($handle);
                return $permissionsArray;
            }
        }
        fclose($handle);
    }
    return null;
}
?>