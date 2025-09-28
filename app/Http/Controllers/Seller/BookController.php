namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::where('user_id', Auth::id())->get();
        return view('books.index', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cover' => 'nullable|image|max:2048',
        ]);

        $book = new Book();
        $book->title = $validated['title'];
        $book->description = $validated['description'] ?? null;
        $book->price = $validated['price'];
        $book->user_id = Auth::id();
        $book->save();

        if ($request->hasFile('cover')) {
            $book->addMediaFromRequest('cover')->toMediaCollection('covers');
        }

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        if ($book->user_id != Auth::id()) {
            abort(403);
        }
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if ($book->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cover' => 'nullable|image|max:2048',
        ]);

        $book->update($validated);

        if ($request->hasFile('cover')) {
            $book->clearMediaCollection('covers');
            $book->addMediaFromRequest('cover')->toMediaCollection('covers');
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
