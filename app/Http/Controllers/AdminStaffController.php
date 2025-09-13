<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminStaffController extends Controller
{
    public function index()
    {
        $staff = Staff::withCount('posts')->orderBy('name')->paginate(15);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'slug' => 'nullable|string|unique:staff,slug',
            'position' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.github' => 'nullable|url',
            'social_links.dribbble' => 'nullable|url',
            'social_links.behance' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Filter out empty social links
        if (isset($validated['social_links'])) {
            $validated['social_links'] = array_filter($validated['social_links']);
        }

        Staff::create($validated);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member created successfully!');
    }

    public function show(Staff $staff)
    {
        $staff->loadCount(['posts', 'publishedPosts']);
        $recentPosts = $staff->posts()->with('category')->latest()->limit(10)->get();

        return view('admin.staff.show', compact('staff', 'recentPosts'));
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'slug' => 'nullable|string|unique:staff,slug,' . $staff->id,
            'position' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'social_links' => 'nullable|array',
            'social_links.facebook' => 'nullable|url',
            'social_links.twitter' => 'nullable|url',
            'social_links.linkedin' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.github' => 'nullable|url',
            'social_links.dribbble' => 'nullable|url',
            'social_links.behance' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($staff->avatar) {
                Storage::disk('public')->delete($staff->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Filter out empty social links
        if (isset($validated['social_links'])) {
            $validated['social_links'] = array_filter($validated['social_links']);
        }

        $staff->update($validated);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully!');
    }

    public function destroy(Staff $staff)
    {
        // Check if staff has posts
        if ($staff->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete staff member with existing posts. Please reassign or delete the posts first.');
        }

        // Delete avatar
        if ($staff->avatar) {
            Storage::disk('public')->delete($staff->avatar);
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully!');
    }

    public function toggleStatus(Staff $staff)
    {
        $staff->update(['status' => $staff->status === 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'Staff status updated successfully!');
    }

    public function removeAvatar(Staff $staff)
    {
        if ($staff->avatar) {
            Storage::disk('public')->delete($staff->avatar);
            $staff->update(['avatar' => null]);
        }

        return back()->with('success', 'Avatar removed successfully!');
    }

    public function profile(Staff $staff)
    {
        $staff->loadCount(['posts', 'publishedPosts']);
        $posts = $staff->posts()
                      ->with('category')
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('admin.staff.profile', compact('staff', 'posts'));
    }
}
