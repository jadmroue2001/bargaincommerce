<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CartItems Controller
 *
 * @property \App\Model\Table\CartItemsTable $CartItems
 * @method \App\Model\Entity\CartItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CartItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Carts', 'Products'],
        ];
        $cartItems = $this->paginate($this->CartItems);

        $this->set(compact('cartItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Cart Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cartItem = $this->CartItems->get($id, [
            'contain' => ['Carts', 'Products'],
        ]);

        $this->set(compact('cartItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cartItem = $this->CartItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $cartItem = $this->CartItems->patchEntity($cartItem, $this->request->getData());
            if ($this->CartItems->save($cartItem)) {
                $this->Flash->success(__('The cart item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart item could not be saved. Please, try again.'));
        }
        $carts = $this->CartItems->Carts->find('list', ['limit' => 200])->all();
        $products = $this->CartItems->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('cartItem', 'carts', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cart Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cartItem = $this->CartItems->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cartItem = $this->CartItems->patchEntity($cartItem, $this->request->getData());
            if ($this->CartItems->save($cartItem)) {
                $this->Flash->success(__('The cart item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cart item could not be saved. Please, try again.'));
        }
        $carts = $this->CartItems->Carts->find('list', ['limit' => 200])->all();
        $products = $this->CartItems->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('cartItem', 'carts', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cart Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cartItem = $this->CartItems->get($id);
        if ($this->CartItems->delete($cartItem)) {
            $this->Flash->success(__('The cart item has been deleted.'));
        } else {
            $this->Flash->error(__('The cart item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
