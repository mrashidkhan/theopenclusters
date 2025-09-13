<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostComment;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $query = PostComment::with(['post']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by post
        if ($request->has('post') && $request->post) {
            $query->where('post_id', $request->post);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('content', 'LIKE', '%' . $request->search . '%');
            });
        }

        $comments = $query->orderBy('created_at', 'desc')->paginate(20);
        $posts = Post::select('id', 'title')->get();

        return view('admin.comments.index', compact('comments', 'posts'));
    }

    public function show(PostComment $comment)
    {
        $comment->load(['post', 'parent', 'replies']);
        return view('admin.comments.show', compact('comment'));
    }

    public function edit(PostComment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, PostComment $comment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'content' => 'required|string|max:1000',
            'status' => 'required|in:pending,approved,spam,rejected',
            'is_featured' => 'boolean',
        ]);

        $comment->update($validated);

        return redirect()->route('admin.comments.index')->with('success', 'Comment updated successfully!');
    }

    public function destroy(PostComment $comment)
    {
        // Delete replies first
        $comment->replies()->delete();
        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Comment deleted successfully!');
    }

    public function approve(PostComment $comment)
    {
        $comment->update(['status' => 'approved']);
        return back()->with('success', 'Comment approved successfully!');
    }

    public function reject(PostComment $comment)
    {
        $comment->update(['status' => 'rejected']);
        return back()->with('success', 'Comment rejected successfully!');
    }

    // public function spam(PostComment $comment)
    // {
    //     $comment->update(['status' => 'spam']);
    //     return back()->with('success', 'Comment marked as spam!');
    // }

    public function toggleFeatured(PostComment $comment)
    {
        $comment->update(['is_featured' => !$comment->is_featured]);
        return back()->with('success', 'Comment featured status updated!');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:approve,reject,spam,delete',
            'comments' => 'required|array',
            'comments.*' => 'exists:post_comments,id',
        ]);

        $comments = PostComment::whereIn('id', $validated['comments']);

        switch ($validated['action']) {
            case 'approve':
                $comments->update(['status' => 'approved']);
                $message = 'Comments approved successfully!';
                break;
            case 'reject':
                $comments->update(['status' => 'rejected']);
                $message = 'Comments rejected successfully!';
                break;
            case 'spam':
                $comments->update(['status' => 'spam']);
                $message = 'Comments marked as spam!';
                break;
            case 'delete':
                // Delete replies first
                PostComment::whereIn('parent_id', $validated['comments'])->delete();
                $comments->delete();
                $message = 'Comments deleted successfully!';
                break;
        }

        return back()->with('success', $message);
    }

    public function reply(Request $request, PostComment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        PostComment::create([
            'post_id' => $comment->post_id,
            'parent_id' => $comment->id,
            'name' => 'Admin',
            'email' => config('mail.from.address'),
            'content' => $validated['content'],
            'status' => 'approved',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Reply posted successfully!');
    }

    public function pending()
    {
        $comments = PostComment::with(['post'])
                              ->where('status', 'pending')
                              ->orderBy('created_at', 'desc')
                              ->paginate(20);

        return view('admin.comments.pending', compact('comments'));
    }

    public function spam()
    {
        $comments = PostComment::with(['post'])
                              ->where('status', 'spam')
                              ->orderBy('created_at', 'desc')
                              ->paginate(20);

        return view('admin.comments.spam', compact('comments'));
    }
}
