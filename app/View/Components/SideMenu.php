<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideMenu extends Component
{
    private $adminRoles = ['In the Shadows', 'Owners'];
    public $admin_menu;
    public $admin_submenu;
    public $user_menu;
    public $user_submenu;
    public $header;

    public function __construct($admin_menu = 'Admin', $admin_submenu = [], $user_menu = 'User', $user_submenu = [],
                                $header = [], $roles = [])
    {

        $this->admin_menu = $admin_menu;
        $this->admin_submenu = $admin_submenu;
        $this->user_menu = $user_menu;
        $this->user_submenu = $user_submenu;
        $this->roles = $roles;
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
        ];
    }

    private function createUserSubmenu()
    {
        return $this->user_submenu = [
            'Specials' => ['View Specials' => '/specials'],
            'Donations' => ['View Users' => '/users'],
        ];
    }

    private function buildMenu()
    {

        $this->header = []; // Explicit initialization


        if (count(array_intersect($this->roles, $this->adminRoles)) > 0) {
            $this->header['Admin'] = $this->createAdminSubmenu();
        }

        $this->header['User'] = $this->createUserSubmenu();


    }

    public function render(): View
	{
		return view('components.side-menu')->with([
            'header', $this->buildMenu()
        ]);
	}
}
