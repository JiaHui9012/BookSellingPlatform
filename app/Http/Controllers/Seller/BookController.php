<?php


namespace App\Http\Controllers\Seller;


use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;


class BookController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:Seller']);
    }


    public function index(Request $request)
    {
        $books = $request->user()->books()->latest()->paginate(15);
        return view('seller.books.index', compact('books'));
    }


    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('seller.books.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $user = $request->user();
        $profile = $user->sellerProfile;
        if (!$profile || $profile->status !== 'approved') {
            return redirect()->back()->withErrors(['seller' => 'Your seller account must be approved before uploading books.']);
        }


        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'cover' => 'required|image|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:10240',
        ]);


        $book = Book::create([
            'seller_id' => $user->id,
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'status' => 'draft',
        ]);


        if ($request->hasFile('cover')) {
            $book->addMediaFromRequest('cover')->toMediaCollection('covers');
        }
        if ($request->hasFile('pdf')) {
            $book->addMediaFromRequest('pdf')->toMediaCollection('pdfs');
        }


        return redirect()->route('seller.books.index')->with('success', 'Book uploaded successfully.');
    }
}
