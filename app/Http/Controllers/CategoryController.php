<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return $this->categoryService->index();
    }

    public function create()
    {
        return $this->categoryService->create();
    }

    public function store(Request $request)
    {
        return $this->categoryService->store($request);
    }

    public function edit(Category $category)
    {
        return $this->categoryService->edit($category);
    }

    public function update(Request $request, Category $category)
    {
        return $this->categoryService->update($request, $category);
    }

    public function destroy(Category $category)
    {
        return $this->categoryService->destroy($category);
    }
}
