<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class GoogleController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        // This action will render the Google-like homepage
        // No additional logic needed as we're just displaying a static page
    }
}
