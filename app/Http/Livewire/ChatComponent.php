<?php
namespace App\Http\Livewire;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ChatComponent extends Component
{
    public $userIds = [];
    public $selectedUser = null;
    public $message = '';
    public $messages = []; // Will store array data

    protected $listeners = ['newMessage' => 'handleNewMessage'];

    public function mount()
    {
        $authUser = Auth::user();
        
        $this->userIds = User::where('id', '!=', $authUser->id)
            ->when($authUser->role === 'vendor', function ($query) {
                return $query->whereIn('role', ['user', 'admin']);
            })
            ->pluck('id')
            ->toArray();
    }

    public function loadMessages($userId)
    {
        if (!in_array($userId, $this->userIds)) {
            abort(403, 'Unauthorized action.');
        }

        $this->selectedUser = $userId;

        $this->messages = Message::with(['from', 'to'])
            ->where(function ($query) use ($userId) {
                $query->where([
                    'from_id' => Auth::id(),
                    'to_id' => $userId
                ]);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where([
                    'from_id' => $userId,
                    'to_id' => Auth::id()
                ]);
            })
            ->latest()
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'from_id' => $message->from_id,
                    'from_name' => $message->from->name,
                    'to_id' => $message->to_id,
                    'message' => $message->message,
                    'created_at' => $message->created_at->format('h:i A'),
                    'is_me' => $message->from_id == Auth::id()
                ];
            })
            ->toArray();

        $this->dispatch('messages-updated');
    }
    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:500',
            'selectedUser' => ['required', Rule::in($this->userIds)]
        ]);
    
        $message = Message::create([
            'from_id' => Auth::id(),
            'to_id' => $this->selectedUser,
            'message' => $this->message,
        ]);
    
        broadcast(new MessageSent([
            'id' => $message->id,
            'from_id' => $message->from_id,
            'from_name' => Auth::user()->name, // Add sender's name
            'to_id' => $message->to_id,
            'message' => $message->message,
            'created_at' => $message->created_at->format('h:i A')
        ]));
    
        $this->reset('message');
        $this->loadMessages($this->selectedUser);
    }

    public function handleNewMessage($messageData)
    {
        if (in_array($this->selectedUser, [$messageData['from_id'], $messageData['to_id']])) {
            $this->loadMessages($this->selectedUser);
        }
    }

    public function render()
    {
        return view('livewire.chat-component', [
            'users' => User::findMany($this->userIds)
        ]);
    }
}