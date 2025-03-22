# RegistrationWebPage
This project is a **User Registration Webpage** that allows users to register by entering their personal details. The data is stored in a MySQL database, and the webpage includes various features such as client-side and server-side validations, image upload functionality, and integration with a third-party API for WhatsApp number validation.

---

## Features

### 1. **User Registration Form**
   - Users can register by entering the following details:
     - Full Name
     - Username
     - Phone Number
     - WhatsApp Number
     - Address
     - Password
     - Confirm Password
     - User Image
     - Email Address
   - All fields are mandatory.

### 2. **Client-Side Validation**
   - The form includes client-side validation using **JavaScript**:
     - Ensures all fields are filled.
     - Validates email format.
     - Ensures the password is at least 8 characters long, contains at least 1 number, and 1 special character.
     - Checks if the password and confirm password fields match.

### 3. **Server-Side Validation**
   - The form includes server-side validation using **PHP**:
     - Checks if the username already exists in the database using **AJAX**.
     - Validates the email and other fields on the server side.

### 4. **Image Upload**
   - Users can upload a profile image:
     - The image is saved on the server.
     - The image name (including extension) is stored in the database.

### 5. **WhatsApp Number Validation**
   - The webpage integrates with a third-party API (**WhatsApp Number Validator API**) to validate WhatsApp numbers:
     - A button next to the WhatsApp number field triggers the validation.
     - The user is alerted whether the number is valid or not.

### 6. **Database Integration**
   - User data is stored in a **MySQL database**:
     - The database includes a `Users` table with fields for all user details.
     - The password is securely hashed before being stored in the database.

### 7. **Header and Footer**
   - The webpage includes a custom header and footer:
     - The header contains the project title and navigation.
     - The footer contains copyright information and links.

---

