function submitSignupForm(event) {
            event.preventDefault(); // Prevent the default form submission

            // Create a FormData object from the signup form
            const formData = new FormData(document.getElementById('signupForm'));

            // Send the form data using fetch API
            fetch('signup.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Show the alert with the response from PHP
                alert(data);
                // Optionally, you can clear the form fields
                document.getElementById('signupForm').reset();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }