var toggleButton = document.getElementById('toggleButton');
var cells = document.querySelectorAll('td:nth-child(2)');

toggleButton.addEventListener('click', function() {
  for (var i = 0; i < cells.length; i++) {
    if (cells[i].style.display === 'none') {
      cells[i].style.display = 'table-cell';
      toggleButton.textContent = 'Hide Column 2';
    } else {
      cells[i].style.display = 'none';
      toggleButton.textContent = 'Show Column 2';
    }
  }
});
