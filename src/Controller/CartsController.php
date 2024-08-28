<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class CartsController extends AppController
{
    public function index()
    {
        // Display a confirmation message or redirect to a different page
        $this->Flash->success(__('Thank you for your purchase! Ishtri Baa3d!'));
        return $this->redirect(['controller' => 'Products', 'action' => 'index']);
    }
    public function add($productId)
    {
        $this->request->allowMethod(['post', 'put']);

        $cart = $this->Carts->findOrCreate(['user_id' => $this->Auth->user('id')]);
        $cartItemsTable = TableRegistry::getTableLocator()->get('CartItems');

        $cartItem = $cartItemsTable->find()
            ->where(['cart_id' => $cart->id, 'product_id' => $productId])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
        } else {
            $cartItem = $cartItemsTable->newEntity([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        if ($cartItemsTable->save($cartItem)) {
            $this->Flash->success(__('Product added to cart.'));
        } else {
            $this->Flash->error(__('Unable to add product to cart.'));
        }

        return $this->redirect($this->referer());
    }

    public function view()
    {
        $cart = $this->Carts->find()
            ->where(['user_id' => $this->Auth->user('id')])
            ->contain(['CartItems' => ['Products']])
            ->firstOrFail();

        $this->set(compact('cart'));
    }

    public function checkout()
    {
        $cart = $this->Carts->find()
            ->where(['user_id' => $this->Auth->user('id')])
            ->contain(['CartItems' => ['Products']])
            ->firstOrFail();

        $this->set(compact('cart'));
    }

    public function processPayment()
    {
        $this->request->allowMethod(['post']);

        $cart = $this->Carts->find()
            ->where(['user_id' => $this->Auth->user('id')])
            ->contain(['CartItems' => ['Products']])
            ->firstOrFail();

        $totalAmount = 0;
        foreach ($cart->cart_items as $item) {
            $totalAmount += $item->product->price * $item->quantity;
        }

        \Stripe\Stripe::setApiKey('sk_test_51P1Ab9P838haqhnmCJXXqAjCzdEaJflX7w6vTUdXu1GMt4ra15jeFNEgGX5xe5Y46w3yv2RL9W9u7X1MZkD099ZX00nfFSLNFA');

        try {
            $charge = \Stripe\Charge::create([
                'amount' => $totalAmount * 100, // Convert to cents
                'currency' => 'cad',
                'description' => 'Your purchase from BargainCommerce',
                'source' => $this->request->getData('stripeToken'),
            ]);

            // Payment successful, clear the cart
            $this->Carts->delete($cart);

            $this->Flash->success(__('Payment successful. Thank you for your purchase.'));
            return $this->redirect(['action' => 'index']);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $this->Flash->error(__('Payment failed. Please try again.'));
            return $this->redirect(['action' => 'checkout']);
        }
    }
}
