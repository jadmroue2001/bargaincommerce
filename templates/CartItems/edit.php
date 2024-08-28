<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CartItem $cartItem
 * @var string[]|\Cake\Collection\CollectionInterface $carts
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cartItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cartItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cart Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cartItems form content">
            <?= $this->Form->create($cartItem) ?>
            <fieldset>
                <legend><?= __('Edit Cart Item') ?></legend>
                <?php
                    echo $this->Form->control('cart_id', ['options' => $carts, 'empty' => true]);
                    echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
                    echo $this->Form->control('quantity');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
