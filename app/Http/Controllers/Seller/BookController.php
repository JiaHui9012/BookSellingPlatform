<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\SellerProfile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $sellers = collect();

        if ($user->hasRole('Admin')) {
            $books = Book::latest()->get();
            $sellers = SellerProfile::with('user:id,name')->get();
        } else {
            $books = Book::where('user_id', $user->id)->latest()->get();
        }
        return view('home.seller.books.index', compact('books', 'sellers'));
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
        // return view('books.edit', compact('book'));
        return view('home.seller.books.partials.bookFields', compact('book'))->render();
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

    public function search(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $keyword = $request->input('keyword');
        $sellerId = $request->input('seller');

        $books = Book::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'LIKE', "%{$keyword}%");
                });
            })
            ->when($user->hasRole('Seller'), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($user->hasRole('Admin') && $sellerId && $sellerId != 0, function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->get();

        $sellers = collect();
        if ($user->hasRole('Admin')) {
            $sellers = SellerProfile::with('user:id,name')->get();
        }

        return view('home.seller.books.index', [
            'books' => $books,
            'sellers' => $sellers,
            'keyword' => $keyword,
            'sellerfilter' => $sellerId,
        ]);
    }

    public function filterBySeller(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $sellerId = $request->input('seller');

        $books = Book::when($sellerId != 0, function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->get();

        $sellers = collect();
        if ($user->hasRole('Admin')) {
            $sellers = SellerProfile::with('user:id,name')->get();
        }

        return view('home.seller.books.index', [
            'books' => $books,
            'sellers' => $sellers,
            'sellerfilter' => $sellerId,
        ]);
    }
}
