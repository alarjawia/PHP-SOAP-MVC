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

The PHP-SOAP-MVC routing system provides a straightforward and expressive way to define routes for your application. Routes are configured in the `web.php` file, establishing a clear link between URLs and corresponding controller actions.

Example route definition in `web.php`:

```php
$app->get('/', [HomeController::class, 'index']);
```

In this example, the `get` method designates a route for the root URL ("/"), directing it to invoke the `index` method within the `HomeController` class.

The first parameter in the route definition represents the path, and the second parameter is an array containing two elements. The first element is the Controller, and the second is the function name. Here, when a user accesses the root ("/") route, the framework calls the `index` method in the `HomeController`.

You can also define a route for a POST request:

```php
$app->post('/store', [HomeController::class, 'store']);
```

The `post` route will only be triggered when a user submits a form with a POST request to the "/store" path.

It's possible to define multiple routes with the same path but different HTTP methods:

```php
$app->post('/login', [AuthController::class, 'login']);
$app->get('/login', [AuthController::class, 'loginView']);
```

Here, the `get` route is called when a user accesses "/login" via a browser, while the `post` route is triggered when the user submits a form to the "/login" path.

Including parameters in a route is also supported:

```php
$app->get('/edit/{id}', [HomeController::class, 'edit']);
```

In this case, the `edit` route expects an "id" parameter in the URL. For instance, accessing "/edit/15" would pass "15" as the "id" parameter to the controller.

Middleware can be applied to restrict access to specific routes:

```php
$app->get('/register', [AuthController::class, 'registerView'])->only('guest');
```

Using the `->only` method, you specify the middleware name (in this example, 'guest') to limit access to the "registerView" page to guests only.

# Controller

Controllers in PHP-SOAP-MVC play a crucial role in handling user input, interacting with the model and view, and defining the application's behavior. Each controller class represents a set of related actions.

Here's an example controller (`HomeController`):

```php
class HomeController
{
    public function index()
    {
        echo "test";
    }

    // Other controller methods for show, create, store, edit, update, delete, etc.
}
```

The `index` method, as an example, can be invoked when a corresponding route is accessed. Any output from this method will be displayed in the browser.

By default, a controller in PHP-SOAP-MVC includes seven methods: `index`, `show`, `create`, `store`, `edit`, `update`, and `delete`. These methods correspond to common CRUD (Create, Read, Update, Delete) operations. For instance:

- The `index` method may display a page with a table of products.
- The `show` method could present details for a specific product.
- The `create` method provides a form for creating a new product.
- The `store` method processes the form data submitted for creating a new product.
- The `edit` method displays an edit page for a product.
- The `update` method stores the edited data in the database.
- The `delete` method deletes a product.

If a route includes parameters (e.g., `/edit/{id}`), you can capture these parameters in the method:

```php
public function edit($params)
{
    $id = $params['id'];
}
```

For methods like `store`, which handle form submissions, you can retrieve data from the `$_POST` global variable:

```php
public function store()
{
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $userid = $_SESSION['userid'];

        // Process and store the form data
    }
}
```

When calling a method and subsequently rendering a view with parameters, you can create an associative array and pass it to the `View::load` method:

```php
public function edit($params)
{
    $data['name'] = 'PHP';
    $data['age'] = 21;

    View::load('edit', $data);
}
```

In the associated view (`edit.php`), you can directly use variables like `$name` and `$age`:

```php
<title><?php echo $name ?></title>
```

Remember that the `View` class automatically applies `htmlspecialchars` to variables, enhancing security.

You can create multiple controllers to organize your application's logic effectively. Each controller focuses on a specific set of related actions.
    

# Model

Models in PHP-SOAP-MVC represent the data and business logic of your application. While your example does not include a specific model class, you can create models to interact with the database or external services.

To create a new model, you need to extend the `DB` class, which is defined in the `app/config/db.php` file. In this file, you must define your database connection details, including the host, database name, username, and password:

```php
define("HOST", '');
define("DATABASE", '');
define("USERNAME", '');
define("PASSWORD", '');
```

Here's an example of a PDO connection string for MySQL:

```php
$this->db = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE, USERNAME, PASSWORD);
```

However, if you're using a different database type, you should modify the connection string accordingly. Here are examples for various databases:

### PostgreSQL:

```php
$this->db = new PDO("pgsql:host=" . HOST . ";dbname=" . DATABASE, USERNAME, PASSWORD);
```

### SQLite:

```php
$this->db = new PDO("sqlite:" . PATH_TO_SQLITE_FILE);
```

### SQL Server:

```php
$this->db = new PDO("sqlsrv:Server=" . HOST . ";Database=" . DATABASE, USERNAME, PASSWORD);
```

### Oracle:

```php
$this->db = new PDO("oci:dbname=//". HOST ."/". DATABASE, USERNAME, PASSWORD);
```

After defining your database connection details and extending the `DB` class, you can start writing SQL queries in your model. For example, a method to retrieve all products from the database:

```php
public function getAllProducts()
{
    $sql = 'SELECT * FROM product';
    $ps = $this->conn->prepare($sql);
    $ps->execute();
    $products = $ps->fetchAll(PDO::FETCH_ASSOC);
    return $products;
}
```

If you want to create a method to insert data into the database, you can do it like this:

```php
public function createProduct($name, $price, $stock, $userid)
{
    try {
        $sql = "INSERT INTO product (name, price, stock, user_id) VALUES (:name, :price, :stock , :userid);";
        $ps = $this->conn->prepare($sql);
        $ps->bindParam(':name', $name);
        $ps->bindParam(':price', $price);
        $ps->bindParam(':stock', $stock);
        $ps->bindParam(':userid', $userid);
        $ps->execute();

        // Return true if the query executed successfully
        return true;
    } catch (PDOException $e) {
        // Handle the exception as needed
        throw $e;
    }
}
```

Now, you can use these model methods in your controller to interact with the database:

```php
public function store()
{
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $userid = $_SESSION['userid'];

        $db = new ProductModel();
        $insert = $db->createProduct($name, $price, $stock, $userid);

        if ($insert) {
            header("Location: /");
            exit;
        }
    }
}
```

This way, you maintain a clear separation of concerns between the model, which handles data and database interactions, and the controller, which manages the application's logic.

# View

In the PHP-SOAP-MVC framework, the view layer is responsible for presenting data to the user. Views are defined in separate files, typically located in the `app/Views` folder. These files can contain HTML, CSS, and JavaScript code to structure and style the content.

To include external resources like images or stylesheets in your views, it's recommended to organize them in the `public` folder. For instance, you can create an `assets` subfolder within `public` to store images, and then use the following syntax to link to them in your views:

```html
<img src="/assets/images/img.png" alt="Description">
```

In the example above, the `img.png` file is located in the `public/assets/images` folder.

When rendering a view in a controller, you can use the `View::load` method:

```php
View::load('edit');
```

If you need to pass data to the view, you can create an associative array and pass it as the second parameter to the `View::load` method:

```php
$data = ['name' => 'test'];
View::load('edit', $data);
```

In the view file (`edit.php`), the data from the array becomes accessible as variables:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
</head>
<body>
    <h1>Welcome to the Edit Page, <?php echo $name; ?></h1>
    <!-- Your HTML content goes here -->
</body>
</html>
```

Here, the variable `$name` is directly available in the view and can be used to dynamically populate the content.

By following this structure, you can keep your code organized and maintain a clear separation of concerns between the view and other components of your application.



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

The `Validations` class in PHP-SOAP-MVC provides a convenient mechanism for handling validation errors and preserving form data between requests. It includes methods to add errors, check for errors, retrieve errors, add data, and show data.

Here's an example of how to use the `Validations` class in a controller method:

```php
public function store()
{
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $userid = $_SESSION['userid'];

        if (empty($name)) {
            Validations::addError('Please enter a name');
        }

        if (empty($price)) {
            Validations::addError('Please enter a price');
        }

        if (empty($stock)) {
            Validations::addError('Please enter stock information');
        }

        if (Validations::isErrors()) {
            Validations::addData($_POST);
            header("Location: /create");
            exit;
        } else {
            $db = new ProductModel();
            $insert = $db->createProduct($name, $price, $stock, $userid);

            if ($insert) {
                header("Location: /");
                exit;
            }
        }
    }
}
```

Here's a breakdown of how it works:

- **Adding Errors:** Use `Validations::addError` to add an error message to the session if there is a validation error in the user's input.

- **Checking for Errors:** `Validations::isErrors` checks if any error messages have been added to the session.

- **Preserving Form Data:** If there are errors, use `Validations::addData($_POST)` to store the user's input data in the session. This is helpful for repopulating the form with the user's previous input.

- **Redirecting on Errors:** If there are errors, redirect the user back to the create page to fix the issues.

- **Showing Errors in the View:** In the view, you can retrieve and display validation errors using `Validations::getErrors`. This method returns an array of error messages, and each message is displayed in the view.

```php
<?php
foreach (Validations::getErrors() as $error) {
    echo '<div class="alert alert-danger" role="alert">';
    echo $error;
    echo '</div>';
}
?>
```

- **Populating Form Fields with Previous Input:** Use `Validations::showData('field_name')` to show the previous input data in the corresponding form field. This helps users avoid retyping information when there are validation errors.

```html
<input type="text" class="form-control" id="productName" placeholder="Enter product name" name="name" value="<?php Validations::showData('name') ?>">
```

Remember that calling `Validations::showData` will also remove the data from the session, ensuring it is only used once for repopulating the form.

By incorporating these validation techniques, you can enhance the user experience by providing clear error messages and preserving user input between form submissions.
    

# Middleware

Middleware in PHP-SOAP-MVC allows you to execute custom logic before reaching the controller. You have defined two middleware classes: `AuthMiddleware` and `GuestMiddleware`.

To create a Middleware, you need to create a class and file inside the `App/Middleware` directory.

```php
class GuestMiddleware
{
    public function handle()
    {
        if (isset($_SESSION['userid'])) {
            return false;
        } else {
            return true;
        }
    }
}
```

You must define a `handle` method so that the framework knows how to determine if the user is a guest or not. In this example, if the method doesn't find `$_SESSION['userid']`, it considers the user a guest.

To check if a user is logged in:

```php
class AuthMiddleware
{
    public function handle()
    {
        if (!isset($_SESSION['userid'])) {
            return false;
        } else {
            return true;
        }
    }
}
```

You can change the `$_SESSION` key name to where you save the user id in the session.

After defining your Middleware, add it to the `MiddlewareMap.php` file:

```php
class MiddlewareMap extends Middleware
{
    public const MAP = [
        'guest' => [GuestMiddleware::class, '/'],
        'auth' => [AuthMiddleware::class, '/login'],
    ];
}
```

Provide the name you want for your middleware and then an array. The first parameter is the Middleware class, and the second is the path that redirects the user back. For example, if a page requires the `auth` middleware, the user will be sent back to the login page.

You can use Middleware in your routes:

```php
$app->get('/login', [AuthController::class, 'loginView'])->only('guest');
$app->post('/login', [AuthController::class, 'login'])->only('guest');

$app->get('/logout', [AuthController::class, 'logout'])->only('auth');
```

Use the `only` method and then the middleware name. This method will only allow this middleware to call this route.

You can also use middleware in the view to display or hide some data:

```php
<?php if (MiddlewareMAP::role('guest')) : ?>
    <a class="btn btn-primary mb-3" href="/login">Login</a>
    <a class="btn btn-primary mb-3" href="/register">Register</a>
<?php endif; ?>
```

Here, we display the login and register links only to the guest middleware using the `role` static method.

If you have a post and want to show the delete and edit button only to the owner of this post, you can use the `isOwner` method:

```php
<?php foreach ($products as $row) : ?>
    <tr>
        <td style="width: 25%;"><?php echo $row["name"] ?></td>
        <td style="width: 25%;"><?php echo $row["price"] ?></td>
        <td style="width: 25%;"><?php echo $row["stock"] ?></td>
        <?php if (MiddlewareMAP::isOwner($row['user_id'])) : ?>
            <td style="width: 25%;">
                <a href="<?php echo ('edit/' . $row['id']); ?>" class="btn btn-primary">Update</a>
                <!-- Form for delete -->
                <form method="post" action="/delete/<?php echo $row['id']; ?>" style="display: inline;">
                    <button class="btn btn-danger" name="delete">Delete</button>
                </form>
            </td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>
```

Here, we loop through all products, and in the model, we get the `user_id` of the owner from the database. The `isOwner` function will check if this id is in the session.

If this doesn't work for you because maybe you use another name for the userid in the session, you have to change the name in the `app/core/Middleware.php` file, in the `isOwner` function, and change `$_SESSION['userid']` to the name in the session where you store the user id.

For more security, use `isOwner` in the controller:

```php
public function edit($params)
{
    $id = $params['id'];
    $db = new ProductModel();
    $data['product'] = $db->getProductById($id);
    $userid = $data['product']['user_id'];

    if (!$data['product']) {
        // Handle error, product not found
        View::load('errors/404');
        return;
    } else if (!MiddlewareMap::isOwner($userid)) {
        View::load('errors/404');
        return;
    }

    View::load('edit', $data);
}
```

Here, we check in the `edit` method if the user is the owner of this post using the `isOwner` method.

For more security, use it also in the `Store` method so that the user cannot see the edit page if he

is not the owner and cannot send a form to the store method if he is not the owner.


        






