<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('home.admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = new Category();
        $category->name = $validated['name'];
        $category->description = $validated['description'] ?? null;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category added successfully.');
    }

    public function edit(Category $category)
    {
        return view('home.admin.categories.partials.categoryFields', compact('category'))->render();
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }

    public function updateBookCategory(Request $request, Book $book)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $book->update([
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return back()->with('success', 'Book category updated successfully.');
    }
}
