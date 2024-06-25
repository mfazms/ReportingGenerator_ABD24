function toggleView() {
    var originalTable = document.getElementById('originalTable');
    var transposedTable = document.getElementById('transposedTable');
    if (originalTable.style.display === 'none') {
        originalTable.style.display = 'block';
        transposedTable.style.display = 'none';
    } else {
        originalTable.style.display = 'none';
        transposedTable.style.display = 'block';
    }
}