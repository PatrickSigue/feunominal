document.querySelectorAll('.open-seat-modal').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const showingId = this.getAttribute('data-showing-id');
        const modal = document.getElementById('seatModal');
        const modalBody = document.getElementById('seatModalBody');

        // Load seat selection form from php/load_seats.php
        fetch(`php/load_seats.php?showing_id=${showingId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status} - ${response.statusText}`);
                }
                return response.text();
            })
            .then(html => {
                modalBody.innerHTML = html;
                modal.style.display = 'block';
            })
            .catch(error => {
                console.error('Error loading seats:', error);
                modalBody.innerHTML = '<p>Error loading seats: ' + error.message + '</p>';
                modal.style.display = 'block';
            });
    });
});

// Close seat modal
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('seatModal').style.display = 'none';
});

// Handle seat selection form submission
document.addEventListener('submit', function(event) {
    if (event.target.matches('form[action="php/confirm_booking.php"]')) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const data = new URLSearchParams();

        // Handle all form fields except seats
        for (const [key, value] of formData.entries()) {
            if (key === 'seats[]') {
                data.append('seats[]', value); // Append each seat individually
            } else {
                data.append(key, value);
            }
        }

        // Open confirmation modal
        const confirmModal = document.getElementById('confirmModal');
        const confirmModalBody = document.getElementById('confirmModalBody');

        fetch('php/confirm_booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status} - ${response.statusText}`);
            }
            return response.text();
        })
        .then(html => {
            confirmModalBody.innerHTML = html;
            confirmModal.style.display = 'block';
            document.getElementById('seatModal').style.display = 'none';
        })
        .catch(error => {
            console.error('Error loading confirmation:', error);
            confirmModalBody.innerHTML = '<p>Error loading confirmation: ' + error.message + '</p>';
            confirmModal.style.display = 'block';
        });
    }
});

// Handle confirmation form submission
document.addEventListener('submit', function(event) {
    if (event.target.matches('#confirmBookingForm')) {
        event.preventDefault();
        fetch(event.target.action, {
            method: 'POST',
            body: new FormData(event.target)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Booking confirmed!');
                document.getElementById('confirmModal').style.display = 'none';
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error confirming booking:', error);
            alert('Error confirming booking.');
        });
    }
});

// Close confirmation modal
document.querySelector('.close-confirm').addEventListener('click', function() {
    document.getElementById('confirmModal').style.display = 'none';
});

// Close modals when clicking outside
window.addEventListener('click', function(event) {
    const seatModal = document.getElementById('seatModal');
    const confirmModal = document.getElementById('confirmModal');
    if (event.target === seatModal) {
        seatModal.style.display = 'none';
    }
    if (event.target === confirmModal) {
        confirmModal.style.display = 'none';
    }
});