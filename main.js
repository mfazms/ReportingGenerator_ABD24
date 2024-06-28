function toggleView() {
    console.log("halo");
    var unpivotedDiv = document.getElementsByClassName('unpivotedDiv');
    unpivotedDiv = unpivotedDiv[0];
    var pivotedDiv = document.getElementsByClassName('pivotedDiv');
    pivotedDiv = pivotedDiv[0];
    var btnPivot = document.getElementById('btn-pivot');
    if (unpivotedDiv.style.display === 'none') {
        unpivotedDiv.style.display = 'block';
        pivotedDiv.style.display = 'none';
        pivotedDiv.querySelector('table').removeAttribute('id');
        unpivotedDiv.querySelector('table').id='toDownload';
        btnPivot.textContent = 'Pivot';
    } else {
        unpivotedDiv.style.display = 'none';
        pivotedDiv.style.display = 'block';
        unpivotedDiv.querySelector('table').removeAttribute('id');
        pivotedDiv.querySelector('table').id='toDownload';
        btnPivot.textContent = 'Unpivot';
    }
}
function Export() {
    var t = new Table2Excel();
    t.export(document.getElementById('toDownload'));    
}
function init(){
    var unpivotedDiv = document.getElementsByClassName('unpivotedDiv');
    unpivotedDiv = unpivotedDiv[0];
    unpivotedDiv.querySelector('table').id='toDownload';
}
init();