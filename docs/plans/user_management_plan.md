# Implementation Plan - User Management CRUD Module

Add a User Management CRUD module to the Doctoria CRM, enabling administrators to view, create, edit, and delete users directly from a command center.

## User Review Required

- The new User Management module will be restricted to users with the `admin` role. Medicos and Clientes trying to access `/dashboard/users` will be automatically redirected to the main dashboard.
- The user sidebar menu will show the new **User Management** icon to all users, but clicking it will only display the module for administrators.

## Proposed Changes

### Core Database Model

#### [MODIFY] [User.php](file:///lamp/www/naxielly/app/models/User.php)
- Add `updateUser($data)` to support updating name, email, phone, role, and optional password.
- Add `deleteUser($id)` to support deleting users. To prevent foreign key constraints from failing:
  - Associated appointments will be deleted first.
  - Associated chat messages will be deleted first.
  - Finally, the user record itself is deleted.

---

### MVC Controller & Routing

#### [MODIFY] [Dashboard.php](file:///lamp/www/naxielly/app/controllers/Dashboard.php)
- Add the `users()` public action to:
  - Check if the logged-in user is an `admin`.
  - Handle POST actions for `create`, `update`, and `delete`.
  - Load all users using `$this->userModel->getAllUsers()`.
  - Render the `users` section inside the `dashboard/index` view.

---

### Dashboard View & Interface

#### [MODIFY] [index.php](file:///lamp/www/naxielly/app/views/dashboard/index.php)
- **Left Sidebar**: Add the `users` icon (`<i class="fas fa-users-cog"></i>`) linking to `/dashboard/users`.
- **Main View Section**: Add the `users` section markup containing:
  - A toolbar with a "Crear Usuario" button.
  - A tabular layout displaying ID, Name, Email, Phone, Rol, and Actions (Editar / Eliminar).
  - An interactive modal form to Create/Edit a user with field validation.
- **JavaScript Block**: Add client-side logic to handle opening/closing of the modal, population of user data during edits, and resetting form actions.

---

## Verification Plan

### Automated Verification
- Verify database methods using CLI commands.
- Run browser-automated tests to navigate to `https://dev-app.filemonprime.net/naxielly/dashboard/users`:
  - Verify that logging in as `admin@doctoria.com` shows the User Management CRUD interface.
  - Verify that logging in as a doctor `house@doctoria.com` redirects away.
  - Create a test user, edit it, verify changes in database, and delete it.

### Manual Verification
- Deploy to the local apache instance and verify visually.
