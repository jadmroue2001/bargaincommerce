<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Updates extends AbstractMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {
        $this->table('cart_items')
            ->addColumn('cart_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('quantity', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'product_id',
                ],
                [
                    'name' => 'cart_items_ibfk_2',
                ]
            )
            ->addIndex(
                [
                    'cart_id',
                ],
                [
                    'name' => 'cart_items_ibfk_1',
                ]
            )
            ->create();

        $this->table('carts')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('products')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('users')
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('cart_items')
            ->addForeignKey(
                'product_id',
                'products',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE',
                    'constraint' => 'cart_items_ibfk_2'
                ]
            )
            ->addForeignKey(
                'cart_id',
                'carts',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE',
                    'constraint' => 'cart_items_ibfk_1'
                ]
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down(): void
    {
        $this->table('cart_items')
            ->dropForeignKey(
                'product_id'
            )
            ->dropForeignKey(
                'cart_id'
            )->save();

        $this->table('cart_items')->drop()->save();
        $this->table('carts')->drop()->save();
        $this->table('products')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
