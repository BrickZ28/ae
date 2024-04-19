<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Game;
use App\Models\Playstyle;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideMenu extends Component
{
    public $categories;
    public $asa;
    public $ase;
    public $pvp;
    public $pve;

    public function __construct(Category $categories, Game $asa, Game $ase, Playstyle $pvp, Playstyle $pve)
    {
        $this->categories = $categories->all();
        $this->asa = $asa->where('display_name', 'ASA')->first();
        $this->ase = $ase->where('display_name', 'ASE')->first();
        $this->pvp = $pvp->where('name', 'PVP')->first();
        $this->pve = $pve->where('name', 'PVE')->first();
    }

    public function render(): View
    {
        return view('components.side-menu')->with([
            'header' => $this->buildMenu(),
            'categories' => $this->categories,
            'asa' => $this->asa,
            'ase' => $this->ase,
            'pvp' => $this->pvp,
            'pve' => $this->pve,
        ]);
    }

    private function buildMenu()
    {
        return [
            [
                'heading' => 'Admin',
                'submenu' => [
                    [
                        'title' => 'Rules',
                        'submenu' => [
                            ['title' => 'View Rules', 'route' => route('rules.index')],
                            ['title' => 'Create Rule', 'route' => route('rules.create')],
                        ],
                    ],
                    [
                        'title' => 'Server',
                        'submenu' => [
                            ['title' => 'View Servers', 'route' => route('servers.index')],
                            ['title' => 'Create Server', 'route' => route('servers.create')],
                        ],
                    ],
                ],
            ],
            [
                'heading' => 'User',
                'submenu' => [
                    ['title' => 'View Users', 'route' => route('users.index')],
                ],
            ],
            [
                'heading' => 'Shop',
                'submenu' => [
                    [
                        'title' => 'ASA',
                        'submenu' => [
                            ['title' => 'PVP', 'route' => route('categories.index', ['game' => 'ASA', 'mode' =>
                                'PVP'])],
                            ['title' => 'PVE', 'route' => route('categories.index', ['game' => 'ASA', 'mode' =>
                                'PVE'])],
                        ],
                    ],
                    [
                        'title' => 'ASE',
                        'submenu' => [
                            ['title' => 'PVP', 'route' => route('categories.index', ['game' => 'ASE', 'mode' =>
                                'PVP'])],
                            ['title' => 'PVE', 'route' => route('categories.index', ['game' => 'ASE', 'mode' =>
                                'PVE'])],
                        ],
                    ],
                ],
            ],
        ];
    }


}
