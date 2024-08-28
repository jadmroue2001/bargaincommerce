<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>
<?= $this->Form->postLink(
                'View Cart',
                ['controller' => 'Carts', 'action' => 'view']
            ) ?>
<h2>Products</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= h($product->name) ?></td>
        <td><?= h($product->description) ?></td>
        <td><?= h($product->price) ?></td>
        <td>
            <?= $this->Form->postLink(
                'Add to Cart',
                ['controller' => 'Carts', 'action' => 'add', $product->id],
                ['confirm' => 'Are you sure?']
            ) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
