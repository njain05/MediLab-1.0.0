<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $agreeTerms = isset($_POST['agreeTerms']) ? true : false;

    // Initialize response array
    $response = array(
        'status' => 'error',
        'message' => '',
        'errors' => array()
    );

    // Validate form data
    if (empty($firstName)) {
        $response['errors']['firstName'] = 'First name is required';
    }
    if (empty($lastName)) {
        $response['errors']['lastName'] = 'Last name is required';
    }
    if (empty($email)) {
        $response['errors']['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['errors']['email'] = 'Invalid email format';
    }
    if (empty($password)) {
        $response['errors']['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $response['errors']['password'] = 'Password must be at least 8 characters long';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $response['errors']['password'] = 'Password must contain at least one uppercase letter';
    } elseif (!preg_match('/[a-z]/', $password)) {
        $response['errors']['password'] = 'Password must contain at least one lowercase letter';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $response['errors']['password'] = 'Password must contain at least one number';
    } elseif (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $response['errors']['password'] = 'Password must contain at least one special character';
    }
    if ($password !== $confirmPassword) {
        $response['errors']['confirmPassword'] = 'Passwords do not match';
    }
    if (!$agreeTerms) {
        $response['errors']['agreeTerms'] = 'You must agree to the terms and conditions';
    }

    // If no validation errors, proceed with signup
    if (empty($response['errors'])) {
        // TODO: Add database connection and user creation logic here
        // For now, we'll just simulate a successful signup
        
        $response['status'] = 'success';
        $response['message'] = 'Account created successfully!';
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?> 