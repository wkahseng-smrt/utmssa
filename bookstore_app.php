<?php
/* Module 1: User Registration */

// Connect to DB
$conn = new mysqli('localhost', 'root', '', 'bookstore');

// Register User
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $conn->query($sql);
    echo "User registered!";
}

// Login User
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // No session management
        echo "Login successful! Welcome, $username";
    } else {
        echo "Invalid credentials";
    }
}
?>

<!--
<form method="POST">
    <h2>Register</h2>
    Username: <input name="username"><br>
    Password: <input name="password" type="password"><br>
    <button name="register">Register</button>
</form>

<form method="POST">
    <h2>Login</h2>
    Username: <input name="username"><br>
    Password: <input name="password" type="password"><br>
    <button name="login">Login</button>
</form>
-->

<?php
/* Module 2: Shopping Cart Management */

// Add to Cart
if (isset($_GET['add'])) {
    $book_id = $_GET['add'];
    // Directly using book_id without validation
    echo "<p>Added book ID $book_id to cart</p>";
}

// Remove from Cart
if (isset($_GET['remove'])) {
    $book_id = $_GET['remove'];
    echo "<p>Removed book ID $book_id from cart</p>";
}
?>

<!--
<a href="?add=1">Add Book 1 to Cart</a> | <a href="?remove=1">Remove Book 1 from Cart</a>
-->

<?php
/* Module 3: Checkout and Order Placement */

// Place order
if (isset($_POST['checkout'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $credit_card = $_POST['credit_card'];

    $sql = "INSERT INTO orders (name, address, credit_card) VALUES ('$name', '$address', '$credit_card')";
    $conn->query($sql);

    echo "Order placed successfully!";
}
?>

<!--
<form method="POST">
    Name: <input name="name"><br>
    Address: <input name="address"><br>
    Credit Card: <input name="credit_card"><br>
    <button name="checkout">Place Order</button>
</form>
-->

<?php
/* Module 4: Order History and Tracking */

// View order by user_id
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $sql = "SELECT * FROM orders WHERE user_id = $user_id";
    $result = $conn->query($sql);

    echo "<h2>Order History for User ID: $user_id</h2><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>Order ID: " . $row['id'] . " - Status: " . $row['status'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No user_id specified.";
}
?>

<?php
/* Module 5: Admin Panel */

// List all books (no output encoding)
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

echo "<h2>Admin - Manage Books</h2><ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>ID: " . $row['id'] . " Title: " . $row['title'] . " - <a href='?delete=" . $row['id'] . "'>Delete</a></li>";
}

// Delete book
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM books WHERE id = $id";
    $conn->query($sql);
    echo "Deleted book ID $id";
}
echo "</ul>";
?>
