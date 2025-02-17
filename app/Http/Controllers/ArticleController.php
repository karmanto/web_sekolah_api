<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Tampilkan semua artikel
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    // Tampilkan satu artikel
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    // Simpan artikel baru
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string',
            'content' => 'required',
            'date'    => 'required|date',
            'author'  => 'required|string',
            'image'   => 'nullable|image|max:2048', // Maksimal 2MB
        ]);

        $data = $request->only(['title', 'content', 'date', 'author']);

        if ($request->hasFile('image')) {
            // Simpan file ke folder 'articles' di disk 'public'
            $path = $request->file('image')->store('articles', 'public');
            $data['image'] = $path;
        }

        $article = Article::create($data);

        return response()->json($article, 201);
    }

    // Update artikel
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title'   => 'sometimes|required|string',
            'content' => 'sometimes|required',
            'date'    => 'sometimes|required|date',
            'author'  => 'sometimes|required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'date', 'author']);

        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $path = $request->file('image')->store('articles', 'public');
            $data['image'] = $path;
        }

        $article->update($data);

        return response()->json($article);
    }

    // Hapus artikel
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();

        return response()->json(['message' => 'Article deleted']);
    }
}
