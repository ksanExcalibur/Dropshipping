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
