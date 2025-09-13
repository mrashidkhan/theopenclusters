<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withCount('posts')->orderBy('sort_order')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:post_categories,slug',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default color if not provided
        if (empty($validated['color'])) {
            $validated['color'] = '#007bff';
        }

        // Set default sort order
        if (empty($validated['sort_order'])) {
            $validated['sort_order'] = PostCategory::max('sort_order') + 1;
        }

        PostCategory::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function show(PostCategory $category)
    {
        $category->loadCount('posts');
        $recentPosts = $category->posts()->with('staff')->latest()->limit(10)->get();

        return view('admin.categories.show', compact('category', 'recentPosts'));
    }

    public function edit(PostCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, PostCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:post_categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default color if not provided
        if (empty($validated['color'])) {
            $validated['color'] = '#007bff';
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(PostCategory $category)
    {
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing posts. Please move or delete the posts first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(PostCategory $category)
    {
        $category->update(['status' => $category->status === 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'Category status updated successfully!');
    }

    public function updateOrder(Request $request)
    {
        $categories = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:post_categories,id',
            'categories.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($categories['categories'] as $categoryData) {
            PostCategory::where('id', $categoryData['id'])
                       ->update(['sort_order' => $categoryData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
