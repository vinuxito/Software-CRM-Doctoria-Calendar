<?php
require_once 'config/config.php';
require_once 'app/core/Database.php';
require_once 'app/models/User.php';

$userModel = new User();

echo "Running CRUD Tests...\n";

// 1. Create temporary test user
$email = 'test_crud_' . time() . '@example.com';
$data = [
    'name' => 'Test User',
    'email' => $email,
    'phone' => '+57 300 000 0000',
    'role' => 'cliente',
    'password' => password_hash('123456', PASSWORD_DEFAULT)
];

$created = $userModel->register($data);
if (!$created) {
    die("ERROR: Failed to register test user.\n");
}
echo "✓ Test user registered successfully.\n";

// 2. Retrieve user
$user = $userModel->getUserByEmail($email);
if (!$user) {
    die("ERROR: Failed to retrieve user by email.\n");
}
echo "✓ Retrieved user successfully. ID: {$user->id}\n";

// 3. Test email collision check
$exists = $userModel->findUserByEmail($email);
if (!$exists) {
    die("ERROR: findUserByEmail failed to detect existing email.\n");
}
echo "✓ Checked email collision detection.\n";

// 4. Update user
$updateData = [
    'id' => $user->id,
    'name' => 'Updated Test User',
    'email' => $email,
    'phone' => '+57 300 999 9999',
    'role' => 'medico',
    'password' => '' // Do not change password
];

$updated = $userModel->updateUser($updateData);
if (!$updated) {
    die("ERROR: Failed to update user.\n");
}

$userUpdated = $userModel->getUserById($user->id);
if ($userUpdated->name !== 'Updated Test User' || $userUpdated->role !== 'medico' || $userUpdated->phone !== '+57 300 999 9999') {
    die("ERROR: Updated user details do not match.\n");
}
echo "✓ Updated user successfully.\n";

// 5. Delete user
$deleted = $userModel->deleteUser($user->id);
if (!$deleted) {
    die("ERROR: Failed to delete user.\n");
}

$userDeleted = $userModel->getUserById($user->id);
if (!$userDeleted || (int)$userDeleted->is_deleted !== 1) {
    die("ERROR: User is not soft-deleted.\n");
}
echo "✓ Soft deleted user successfully.\n";

echo "ALL CRUD TESTS PASSED!\n";
