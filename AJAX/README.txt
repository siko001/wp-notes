# WordPress AJAX

## Overview
WordPress AJAX lets you send & receive data without reloading the page.

## How to Use AJAX in WordPress
1. **Enqueue the script**
2. **Create an AJAX handler in PHP**
3. **Use `admin-ajax.php` for requests**
4. **Send data using `wp_ajax_` hooks**

### 🛠️ Example AJAX Code:
```php
add_action('wp_ajax_my_action', 'my_ajax_function');
add_action('wp_ajax_nopriv_my_action', 'my_ajax_function');

function my_ajax_function() {
    echo json_encode(['message' => 'Hello from AJAX!']);
    wp_die(); // Always use wp_die() in AJAX responses
}



# AJAX Form Submission in WordPress

This guide explains the flow of an AJAX form submission in WordPress, including the use of a nonce for security. Below is a detailed step-by-step breakdown of the process.

---

## 1. Form Submission (User Interaction)

The user fills out the form and clicks the "Submit" button.

### What happens:
Normally, when a form is submitted, the page would reload, and the data would be sent to the URL specified in the `action` attribute of the form. However, here, we prevent that default behavior using JavaScript.

---

## 2. JavaScript Prevents Default Form Submission

JavaScript listens for the form’s `submit` event using:

```js
form.addEventListener('submit', function(event) {...});
Inside the event handler, we call event.preventDefault(), which stops the form from submitting in the usual way (no page reload).

## 3. Prepare Form Data for AJAX

The form data is gathered using `FormData(form)`. This collects all form inputs (e.g., text fields, checkboxes) into a `FormData` object.

Additionally, we append the nonce and the `action` parameter to the form data before sending it to the server:

```js
formData.append('security', myAjax.nonce); // Adds the nonce for security
formData.append('action', 'my_ajax_action'); // Tells WordPress what AJAX action to run


### What happens:
The form data, including the nonce and action, is bundled into the request to send to the server. This ensures the request is secure and processed by WordPress through the specified AJAX action.

---

## 4. Send the AJAX Request (Using Fetch API)

The `fetch()` method is used to send the AJAX request to `admin-ajax.php` (the WordPress AJAX handler).

```js
fetch(myAjax.ajaxurl, {
    method: 'POST',
    body: formData,
})
.then(response => response.json())  // Converts the response to JSON
.then(data => {
    if (data.success) {
        alert('Form submitted successfully!');
    } else {
        alert('Error: ' + data.data);
    }
});
