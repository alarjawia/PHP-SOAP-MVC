# PHP-SOAP-MVC

Welcome to SOAP-MVC Framework. This framework is a simple PHP MVC framework designed for ease of use and understanding.

## Key Features

This framework incorporates essential components for starting a project using the MVC concept. It includes:

- **MODEL**: Handles data and business logic.
- **VIEW**: Responsible for the presentation layer.
- **CONTROLLER**: Manages user input and communicates with the model and view.
- **Route**: Defines the routing mechanism for the application.
- **Middleware**: Allows for the execution of custom logic before reaching the controller.
- **Validation**: Provides a mechanism for validating user input.

## Getting Started

To begin using the framework, follow these steps:

1. Download the framework files and place them in your `htdocs` directory.

2. Open your Apache `httpd-vhosts.conf` file located at `apache\conf\extra\httpd-vhosts.conf`.

3. Create a virtual host entry by specifying the path to the public directory of the framework. You can customize the local domain (`mvc.local` in this example).

    ```apache
    <VirtualHost mvc.local:80>
        DocumentRoot "YOUR PATH/htdocs/MVC/public"
        ServerName mvc.local
        <Directory "YOUR PATH /htdocs/MVC/public">
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    ```

    Ensure that `YOUR PATH` is replaced with the actual path to your project.

4. Update your hosts file based on your operating system:

    - **Windows**: Open `c:\Windows\System32\Drivers\etc\hosts` file and add:
        ```
        127.0.0.1 mvc.local
        ```
    - **Linux**: Open `/etc/hosts` file and add the line:
        ```
        127.0.0.1 mvc.local
        ```
    - **Mac**: Open `/private/etc/hosts` file and add:
        ```
        127.0.0.1 mvc.local
        ```

5. Save the changes.

6. Open your browser and navigate to `mvc.local`. You should see the framework in action.

This setup allows you to create a virtual host and access your application with a custom local domain. The provided framework is now ready for you to build upon for your PHP projects.




# Route

The routing system in PHP-SOAP-MVC allows you to define clean and expressive routes for your application. Routes are defined in the `web.php` file, providing a clear mapping between URLs and controller actions.

Example route definition in `web.php`:

```php
$app->get('/', [HomeController::class, 'index']);
```

Here, the `get` method defines a route for the root URL ("/") that maps to the `index` method of the `HomeController` class.

# Controller

Controllers in PHP-SOAP-MVC handle user input, interact with the model and view, and define the application's behavior. Each controller class represents a set of related actions.

Example controller (`HomeController`):

```php
class HomeController
{
    public function index()
    {
        View::load('home');
    }

    // Other controller methods for show, create, store, edit, update, delete, etc.
}
```

In this example, the `index` method is responsible for loading the "home" view. You can add more methods to handle various actions in your application.

# Model

Models in PHP-SOAP-MVC represent the data and business logic of your application. While your example does not include a specific model class, you can create models to interact with the database or external services.

# View

The view layer is responsible for presenting the data to the user. Views are defined in separate files and loaded by the controller.

Example view (`home.php`):

```php
<!-- home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <h1>Welcome to the Home Page</h1>
    <!-- Your HTML content goes here -->
</body>
</html>
```

# Validation

The `Validations` class provides a simple mechanism for handling validation errors and preserving form data between requests. It includes methods to add errors, check for errors, retrieve errors, add data, and show data.

Example usage in a controller method:

```php
public function store()
{
    // Validation logic
    if ($someConditionIsNotMet) {
        Validations::addError('Some error message');
    }

    // Store data
    $data = ['key' => 'value'];
    Validations::addData($data);

    // Redirect back
    header('Location: /previous-page');
    exit();
}
```

# Middleware

Middleware in PHP-SOAP-MVC allows you to execute custom logic before reaching the controller. You have defined two middleware classes: `AuthMiddleware` and `GuestMiddleware`.

Example usage in `web.php`:

```php
$app->get('/', [HomeController::class, 'index'])
    ->only('guest'); // Apply the GuestMiddleware for the home page, allowing only guests to access.
```

The `only` method is used to specify which middleware to apply to a particular route.

Ensure your middleware classes (`AuthMiddleware` and `GuestMiddleware`) handle the logic appropriately.

Note: Always validate and sanitize user inputs to prevent security vulnerabilities such as SQL injection and cross-site scripting (XSS).
