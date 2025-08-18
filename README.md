# huni-sa-tribu

## Initialization

Before running the application, follow these steps to set it up properly:

---

### 1. Create the configuration file
Copy or rename the template file:
```bash
cp config-template.php config.php
```

The project uses `config.php` to store sensitive credentials, specifically the **Brevo API key** for sending email verifications.
We keep a separate `config-template.php` so you can easily set up your own configuration without committing secrets to version control.

---

### 2. Add your Brevo API key

Open `config.php` and insert your personal Brevo API key:

```php
$BREVO_API_KEY = "your_api_key_here";
```

The email verification flow (`api/v1/index.php`) sends emails through the Brevo (formerly Sendinblue) SMTP API.
Without a valid API key, the server cannot send verification emails to users.

---

### 3. Initialize the database

Run:

```bash
php init.php
```

The `init.php` script sets up a new SQLite database (`database.db`) with the required tables:

* `users` → stores registered users, their login info, and session tokens.
* `email_verifications` → stores verification codes and tracks whether an email has been verified.

This step must be done **once** before starting the server.

---

### 4. Start the local server

Run:

```bash
php -S localhost:8000
```

This command starts PHP’s built-in development server on port **8000**, making the application accessible at:
[http://localhost:8000](http://localhost:8000).