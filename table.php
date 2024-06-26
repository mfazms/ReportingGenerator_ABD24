<div id="originalTable" style="display: block;">
    <?php echo generateTableHTML($_SESSION['normal']); ?>
</div>
<div id="transposedTable" style="display: none;">
    <?php echo generateTableHTML($_SESSION['switched'], true); ?>
</div>