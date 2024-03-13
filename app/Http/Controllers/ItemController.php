<?php

// app/Http/Controllers/ItemController.php

namespace App\Http\Controllers;

use App\Models\Item;
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
}
