<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    // Display all contact messages
    public function AllMessages()
    {
        $messages = ContactMessage::latest()->get();
        return view('backend.messages.all_messages', compact('messages'));
    }

    // View a specific message and mark it as read
    public function ViewMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // Mark message as read if it's unread
        if ($message->status === 'unread') {
            $message->status = 'read';
            $message->save();
        }
        
        return view('backend.messages.view_message', compact('message'));
    }

    // Delete a message
    public function DeleteMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        
        $notification = array(
            'message' => 'Message deleted successfully',
            'alert-type' => 'success'
        );
        
        return redirect()->route('all.messages')->with($notification);
    }
}
