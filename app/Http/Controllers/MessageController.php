<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
{
    $messages = Message::all();
    return view('dashboard.messages.index', compact('messages'));
}
    public function edit($key)
    {
        $message = Message::where('key', $key)->firstOrFail();
        return view('dashboard.messages.edit', compact('message'));
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $message = Message::where('key', $key)->firstOrFail();
        $message->content = $request->content;
        $message->save();

        return redirect()->back()->with('success', 'تم تحديث الرسالة بنجاح.');
    }
}
