<h2>Your Cart</h2>
<?php if (!empty($cart->cart_items)): ?>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php foreach ($cart->cart_items as $item): ?>
            <tr>
                <td><?= h($item->product->name) ?></td>
                <td><?= h($item->quantity) ?></td>
                <td><?= h($item->product->price * $item->quantity) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="<?= $this->Url->build(['action' => 'checkout']) ?>">Checkout</a>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>
