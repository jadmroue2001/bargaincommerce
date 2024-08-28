<?php
// src/Controller/AppController.php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        // Load the Auth Component
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password',
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'authError' => 'Please log in to access that area.',
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ]
        ]);

        // Allow the display action so our pages controller
        // continues to work.
        $this->Auth->allow(['display']);
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // Allow the user to access login, logout actions without authentication
        $this->Auth->allow(['login', 'logout']);
    }
}
