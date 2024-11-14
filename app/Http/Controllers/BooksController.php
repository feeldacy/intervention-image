<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;


class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->middleware('auth')->except(['register', 'login', 'store', 'authenticate']);
    }

    public function index()
    {
        $books_data = Books::all()->sortBy('id');

        return view('book.index', compact('books_data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'cover' => 'image|required|max:1999',
        ]);

        if ($request->hasFile('cover')) {
            $image = Image::read($request->file('cover'));
            $filenameWithExt = $request->file('cover')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('cover')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('cover')->storeAs('cover_book_images', $filenameSimpan);
            $image->cover(300, 300, 'center')->save(storage_path("app/public/cover_book_images_resized/{$filenameSimpan}"));
        }

        $buku = new Books();
        $buku->judul = $request->judul; // lihat name di view
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->photo = $filenameSimpan;
        $buku->save();

        return redirect('/books')
        ->with('pesan', 'Data buku berhasil di Simpan');
    }

    /**
     * Display the specified resource.
     */
    public function showCover(string $id)
    {
        $books_data = Books::find($id);
        return view('book.detail', compact('books_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Books::find($id);
        return view('book.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Books::find($id);
        $buku->judul = $request->input('judul');
        $buku->penulis = $request->input('penulis');
        $buku->harga = $request->input('harga');
        $buku->tgl_terbit = $request->input('tgl_terbit');

        $buku->save();

        return redirect('/books')->with('pesan', 'Data buku berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Books::find($id);

        if($buku){

            Storage::disk('public')->delete('cover_book_images_resized/' . $buku->photo);
            Storage::disk('public')->delete('cover_book_images/' . $buku->photo);

            $buku ->delete();
        }

        return redirect('/books')->with('pesan', 'Data buku berhasil di Hapus');
    }
}
