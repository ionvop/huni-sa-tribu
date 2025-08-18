# huni-sa-tribu

## Initialization

Follow these steps to set up the project:

1. **Create the configuration file**  
   Copy or rename the template file:
   ```bash
   cp config-template.php config.php
   ```

2. **Add your Brevo API key**
   Open `config.php` and replace the placeholder with your own Brevo API key:

   ```php
   $BREVO_API_KEY = "your_api_key_here";
   ```

3. **Initialize the project**
   Run the initialization script:

   ```bash
   php init.php
   ```

4. **Start the local server**
   Launch PHP’s built-in server:

   ```bash
   php -S localhost:8000
   ```

   The application will be available at [http://localhost:8000](http://localhost:8000).