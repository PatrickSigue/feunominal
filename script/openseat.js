document.querySelectorAll('.open-seat-modal').forEach(button => {
    button.addEventListener('click', function () {
        const showingId = this.getAttribute('data-showing-id');

        // Fetch the seat selection form dynamically
        fetch(`php/load_seats.php?showing_id=${showingId}`)
          .then(res => res.text())
          .then(html => {
              document.getElementById('seatModalBody').innerHTML = html;
              document.getElementById('seatModal').style.display = 'block';
          });
    });
});

document.querySelector('.close').addEventListener('click', function () {
    document.getElementById('seatModal').style.display = 'none';
});

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('seatModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
}