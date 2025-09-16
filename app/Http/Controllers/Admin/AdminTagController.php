<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminTagController extends Controller
{
    public function index()
    {
        $tags = PostTag::withCount('posts')->orderBy('name')->paginate(15);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:post_tags,slug',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default color if not provided
        if (empty($validated['color'])) {
            $validated['color'] = '#6c757d';
        }

        PostTag::create($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully!');
    }

    public function show(PostTag $tag)
    {
        $tag->loadCount('posts');
        $recentPosts = $tag->posts()->with('staff')->latest()->limit(10)->get();

        return view('admin.tags.show', compact('tag', 'recentPosts'));
    }

    public function edit(PostTag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, PostTag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:post_tags,slug,' . $tag->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tag->update($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully!');
    }

    public function destroy(PostTag $tag)
    {
        // Check if tag has posts
        if ($tag->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete tag with existing posts. Please remove the tag from posts first.');
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully!');
    }

    public function toggleStatus(PostTag $tag)
    {
        $tag->update(['status' => $tag->status === 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'Tag status updated successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'tags' => 'required|array',
            'tags.*' => 'exists:post_tags,id',
        ]);

        $tags = PostTag::whereIn('id', $validated['tags'])->get();

        // Check if any tag has posts
        foreach ($tags as $tag) {
            if ($tag->posts()->count() > 0) {
                return back()->with('error', 'Cannot delete tags that have posts. Please remove tags from posts first.');
            }
        }

        PostTag::whereIn('id', $validated['tags'])->delete();

        return back()->with('success', 'Selected tags deleted successfully!');
    }
}
