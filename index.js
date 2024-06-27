function toggleView() {
    var originalTable = document.getElementsByClassName('originalTable');
    originalTable = originalTable[0];
    var transposedTable = document.getElementsByClassName('transposedTable');
    transposedTable = transposedTable[0];
    // var tableToDownload = document.getElementById('tableToDownload');
    var btnPivot = document.getElementById('btn-pivot');
    if (originalTable.style.display === 'none') {
        originalTable.style.display = 'block';
        transposedTable.style.display = 'none';
        transposedTable.querySelector('table').removeAttribute('id');
        originalTable.querySelector('table').id='toDownload';
        // tableToDownload.value = 'table1';
        btnPivot.textContent = 'Pivot';
    } else {
        originalTable.style.display = 'none';
        transposedTable.style.display = 'block';
        originalTable.querySelector('table').removeAttribute('id');
        transposedTable.querySelector('table').id='toDownload';
        // tableToDownload.value = 'table2';
        btnPivot.textContent = 'Unpivot';
    }
}
function Export() {
    var t = new Table2Excel();
    t.export(document.getElementById('toDownload'));    
}
function init(){
    var originalTable = document.getElementsByClassName('originalTable');
    originalTable = originalTable[0];
    originalTable.querySelector('table').id='toDownload';
}
init();