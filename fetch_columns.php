<?php
  include_once ('database.php');

  $selectTable = $_POST['selectTable'];
  $_SESSION['table'] = $selectTable;
  $query = "show columns from `$selectTable`";
  $res = mysqli_query($conn,$query);
  if(isset($_SESSION['columns'])) unset($_SESSION['columns']);
  $cols = array();
  while($row = mysqli_fetch_row($res)) 
  {
    $cols[] = $row[0];
?>
    <div class="col">
        <input class="form-check-input>" type="checkbox" name="columns[]" value="<?php echo $row[0]?>" id="checkbox_<?php echo $row[0]?>">
        <label class="form-check-label" for="checkbox_<?php echo $row[0]?>"><?php echo $row[0]?></label>
    </div>
<?php
    //  $out .=  '<li>'.$row[0].'</li>'; 
  }
  //default value utk session columns adalah semua column
  //baru ketika ada form submission, di overwrite
  $_SESSION['columns']=$cols;
  // echo $out;
?>
