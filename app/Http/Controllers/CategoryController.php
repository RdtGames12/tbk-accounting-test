<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->search) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        $categories = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'categories.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view('categories.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        if ($category->coas()->exists()) {

            return back()->with(
                'error',
                'Category still has COA'
            );
        }
        $category->delete();
        return back()->with(
            'success',
            'Deleted successfully'
        );
    }
}
