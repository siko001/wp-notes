document.addEventListener('DOMContentLoaded', () => {
	const form = document.getElementById('my-ajax-form');

	form.addEventListener('submit', function (event) {
		event.preventDefault(); // Prevent form from submitting normally

		// Prepare the form data
		const formData = new FormData(form);
		formData.append('security', myAjax.nonce); // Add nonce to form data
		formData.append('action', 'my_ajax_action'); // Add the action for WordPress AJAX

		// Send AJAX request
		fetch(myAjax.ajaxurl, {
			method: 'POST',
			body: formData,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					alert(data.data.message); // Success message
				} else {
					alert(data.data.message); // Error message
				}
			})
			.catch((error) => console.error('Error:', error));
	});
});
