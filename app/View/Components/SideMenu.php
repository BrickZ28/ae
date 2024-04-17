<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Game;
use App\Models\Playstyle;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideMenu extends Component
{
    private $adminRoles = ['In the Shadows', 'Head Admin'];
    public $admin_menu;

    public $admin_submenu;

    public $user_menu;

    public $user_submenu;

    public $store_menu;

    public $store_submenu;

    public $header;

    public function __construct($admin_menu = 'Admin', $admin_submenu = [], $user_menu = 'User', $user_submenu = [],
         $roles = [], $store_menu = 'Store', $store_submenu = [])
    {

        $this->admin_menu = $admin_menu;
        $this->admin_submenu = $admin_submenu;
        $this->user_menu = $user_menu;
        $this->user_submenu = $user_submenu;
        $this->roles = $roles;
        $this->store_menu = $store_menu;
        $this->store_submenu = $store_submenu;
    }

    private function createAdminSubmenu()
    {
        return $this->admin_submenu = [
            'users' => ['View Users' => route('users.index')],
            'rules' => ['New Rule' => route('rule.create'),
                'View Rules' => route('rules.index')],
            'screenshots' => ['Upload Screenshot' => route('screenshots.create'),
                'Pending Screenshots' => route('screenshots.index')],
            'servers' => ['Create Server' => route('servers.create'),
                'View Servers' => route('servers.index')],
            'games' => ['Create Game' => route('games.create'),
                'View Games' => route('games.index')],
            'specials' => ['Create Special' => route('specials.create'),
                'View Specials' => route('specials.index')],
            'trivia' => ['Create Question' => route('questions.create'),
                'View Questions' => route('questions.index')],
            'playstyles' => ['Create Playstyle' => route('playstyles.create'),
                'View Playstyles' => route('playstyles.index')],
            'categories' => ['Create Category' => route('categories.create'),
                'View Categories' => route('categories.index')],
            'items' => ['Create Item' => route('items.create'),
                'View Items' => route('items.index')],
            'packages' => ['Create Package' => route('packages.create'),
                'View Packages' => route('packages.index')],
            'gates' => ['Create Gate' => route('gates.create'),
                'View Gates' => route('gates.index')],
        ];
    }

    private function createUserSubmenu()
    {
        $categories = Category::all(); // Retrieve all categories

        $cart_link =  auth()->user() && auth()->user()->cart ? route('carts.show', ['cart' => auth()->user
    ()->cart->id]) : '#';

        $shopSubmenu = [];
        foreach ($categories as $category) {
            $shopSubmenu[$category->name] = route('items.index', ['category' => $category->id]);
        }

        return $this->user_submenu = [
            'Trivia' => ['View Question' => route('questions.user.random')],
            'Calendar' => ['View calendar' => route('calendar.index')],
            'Shop' => $shopSubmenu, // Add the Shop submenu
            'Invoices' => ['View Transactions' => route('user.transactions', ['id' => Auth::id()]),
                'View Cart' =>  $cart_link],
        ];
    }

   private function createStoreSubmenu()
{
    $playstyles = Playstyle::all(); // Retrieve all playstyles
    $games = Game::all(); // Retrieve all games
    $categories = Category::all(); // Retrieve all categories

    $storeSubmenu = [];

    foreach ($games as $game) {
        foreach ($playstyles as $playstyle) {
            foreach ($categories as $category) {
                $storeSubmenu[$game->display_name . ' ' . $playstyle->name][$category->name] = route('items.index.gpc', ['game' => $game->display_name, 'playstyle' => $playstyle->name, 'category' => $category->id]);
            }
        }
    }

    return $this->store_submenu = $storeSubmenu;
}

    private function buildMenu()
    {

        $this->header = []; // Explicit initialization

        if (count(array_intersect($this->roles, $this->adminRoles)) > 0) {
            $this->header['Admin'] = $this->createAdminSubmenu();
        }

        $this->header['User'] = $this->createUserSubmenu();
        $this->header['Store'] = $this->createStoreSubmenu();

    }

    public function render(): View
    {
        return view('components.side-menu')->with([
            'header', $this->buildMenu(),
        ]);
    }
}
