<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Thread;
use App\Models\Like;
use App\Models\Comment;

class DiscussController extends Controller
{
    // show all thread
    public function index()
    {
        return view('forum.index', [
            'app' => Application::all(),
            'title' => 'Forum',
            'threads' => Thread::with(['comment', 'user', 'like'])->latest()->paginate(6)
        ]);
    }

    // add new thread
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255|string',
            'content' => 'required|max:1000|string'
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        Thread::create($validatedData);
        return back()->with('addTopicSuccess', 'Thread berhasil ditambah!');
    }

    // add & unlike
    public function like(Request $request)
    {
        $data = Like::where('user_id', auth()->user()->id)->where('thread_id', $request->id)->first();
        if ($data) {
            $data->delete();
            return response()->json(['message' => 'unlike success', 'count' => Like::where('thread_id', $request->id)->count()]);
        } else {
            Like::create([
                'user_id' => auth()->user()->id,
                'thread_id' => $request->id
            ]);
            return response()->json(['message' => 'like success', 'count' => Like::where('thread_id', $request->id)->count()]);
        }
    }

    // detail thread
    public function details(Thread $thread)
    {
        return view('forum.details', [
            'app' => Application::all(),
            'title' => 'Detail Thread: ' . $thread->title,
            'threads' => Thread::with(['comment', 'user', 'like'])->latest()->get(),
            'thread' => $thread->load('like'),
            'comments' => Comment::with(['replies', 'user'])->where('thread_id', $thread->id)->whereNull('parent_id')->get()
        ]);
    }

    // delete thread topic
    public function deleteThread(Request $request)
    {
        $idThread = decrypt($request->code);
        Like::where('thread_id', $idThread)->delete();
        Comment::where('thread_id', $idThread)->delete();
        Thread::destroy($idThread);
        return back()->with('deleteTopicSuccess', 'Thread berhasil dihapus!');
    }

    // search threads
    public function search()
    {
        if (request('q') === null) {
            return redirect('/view/discuss');
            exit;
        }

        return view('forum.search', [
            'app' => Application::all(),
            'title' => 'Forum',
            'threads' => Thread::with(['comment', 'user', 'like'])->latest()->searching(request('q'))->paginate(6)
        ]);
    }

    // add comment
    public function comment(Thread $thread, Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'max:1000|string'
        ]);
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['thread_id'] = $thread->id;
        if ($request->parent_id) {
            $validatedData['parent_id'] = $request->parent_id;
        }

        Comment::create($validatedData);
        return back();
    }

    // delete comment
    public function destroy(Comment $comment)
    {
        if ($comment->parent_id == NULL) {
            Comment::where('parent_id', $comment->id)->delete();
            Comment::destroy($comment->id);
        } else {
            Comment::destroy($comment->id);
        }
        return back();
    }
}
