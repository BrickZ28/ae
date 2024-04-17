<?php

// app/Http/Controllers/ItemController.php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Item;
use App\Models\Playstyle;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        return $this->itemService->index();
    }

    public function create()
    {
        return $this->itemService->create();
    }

    public function store(Request $request)
    {
        return $this->itemService->store($request);
    }

    public function edit(Item $item)
    {
        return $this->itemService->edit($item);
    }

    public function update(Request $request, Item $item)
    {
        return $this->itemService->update($request, $item);
    }

    public function destroy(Item $item)
    {
        return $this->itemService->destroy($item);
    }

    private function getFilters()
    {
        if(auth()->user()->hasAnyRole(['Owners', 'Head Admin', 'In the Shadows'])){
            $filters = ['name', 'category', 'price', 'Updated on', 'view', 'edit', 'delete'];
        } else {
            $filters = ['image', 'name', 'price', 'Last update', 'View', 'add to cart', 'view cart'];
        }

        return $filters;
    }

    public function indexByGamePlaystyleCategory($game, $playstyle, $category)
    {
        $gameId = Game::where('display_name', $game)->first()->id;
        $playstyleId = Playstyle::where('name', $playstyle)->first()->id;

        $items = Item::where('game_id', $gameId)
                     ->where('playstyle_id', $playstyleId)
                     ->where('category_id', $category)
                     ->get();$filters = $this->getFilters();

        if(auth()->user()->hasAnyRole([ 'Owners', 'Head Admin', 'In the Shadows'])){
            return view('dashboard.item.index', compact('items', 'filters'));
        }

        return view('buyer.item.index', compact('items', 'filters', ));
    }
}
