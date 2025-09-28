<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            $books = Book::latest()->get();
        } else {
            $books = Book::where('user_id', $user->id)->latest()->get();
        }
        $categories = Category::all();
        return view('home.seller.books.index', compact('books', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'cover' => 'nullable|image|max:2048',
        ]);

        $book = new Book();
        $book->title = $validated['title'];
        $book->description = $validated['description'] ?? null;
        $book->category_id = $validated['category_id'] ?? null;
        $book->price = $validated['price'];
        $book->stock = $validated['stock'];
        $book->user_id = Auth::id();
        $book->save();

        if ($request->hasFile('cover')) {
            $book->addMediaFromRequest('cover')->usingName($book->title)->toMediaCollection('covers');
        }

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        if ($book->user_id != Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        // return view('books.edit', compact('book'));
        return view('home.seller.books.partials.bookFields', compact('book', 'categories'))->render();
    }

    public function update(Request $request, Book $book)
    {
        if ($book->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'cover' => 'nullable|image|max:2048',
        ]);

        $book->update($validated);

        if ($request->hasFile('cover')) {
            // $book->clearMediaCollection('covers');
            $book->addMediaFromRequest('cover')->usingName($book->title)->toMediaCollection('covers');
        }

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->user_id != Auth::id()) {
            abort(403);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}
