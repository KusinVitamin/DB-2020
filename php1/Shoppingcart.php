<html>
<meta charset="UTF-8">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            var includes = $('[data-include]');
            jQuery.each(includes, function(){
                var file = '/~ollelv-8/php1/' + $(this).data('include') + '.php';
                $(this).load(file);
            });
        });
    </script>
    <style>
        form.CredentialsForm {
            background-color:yellow;
            width:400px;
            border:2px solid black;
            margin:10px;
            padding:10px;



        }
    </style>
</head>

<body>
<div data-include="Header"></div>

<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['AssetName'], $_POST['quantity']) && is_numeric($_POST['AssetName']) && is_numeric($_POST['quantity'])) {
    
    // Set the post variables so we easily identify them, also make sure they are integer
    $AssetName = (int)$_POST['AssetName'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $pdo->prepare('SELECT * FROM Assets WHERE id = ?');
    $stmt->execute([$_POST['AssetName']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($AssetName, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$AssetName] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$AssetName] = $quantity;
            }
        } else {
            // There are no Assets in cart, this will add the first product to cart
            $_SESSION['cart'] = array($AssetName => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: AssetListings.php?page=cart');
    exit;
}

// Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the product from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: AssetListings.php?page=cart');
    exit;
}

// Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: AssetListings.php?page=placeorder');
    exit;
}

// Check the session variable for Assets in cart
$Assets_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$Assets = array();
$subtotal = 0.00;
// If there are Assets in cart
if ($Assets_in_cart) {
    // There are Assets in the cart so we need to select those Assets from the database
    // Assets in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($Assets_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM Assets WHERE id IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the Assets
    $stmt->execute(array_keys($Assets_in_cart));
    // Fetch the Assets from the database and return the result as an Array
    $Assets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($Assets as $product) {
        $subtotal += (float)$product['price'] * (int)$Assets_in_cart[$product['id']];
    }
}
?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="AssetListings.php?page=cart" method="post">
        <table>
            <thead>
            <tr>
                <td colspan="2">Product</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Total</td>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="img">
                            <a href="AssetListings.php?page=product&id=<?=$product['id']?>">
                                <img src="imgs/<?=$product['img']?>" width="50" height="50" alt="<?=$product['name']?>">
                            </a>
                        </td>
                        <td>
                            <a href="AssetListings.php?page=product&id=<?=$product['id']?>"><?=$product['name']?></a>
                            <br>
                            <a href="AssetListings.php?page=cart&remove=<?=$product['id']?>" class="remove">Remove</a>
                        </td>
                        <td class="price">&dollar;<?=$product['price']?></td>
                        <td class="quantity">
                            <input type="number" name="quantity-<?=$product['id']?>" value="<?=$products_in_cart[$product['id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
                        </td>
                        <td class="price">&dollar;<?=$product['price'] * $products_in_cart[$product['id']]?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>