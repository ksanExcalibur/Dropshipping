<div>
    <h3>Chat with Users</h3>

    <!-- User List -->
    <div class="mb-3">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle w-100" type="button" 
                    id="userDropdown" data-bs-toggle="dropdown">
                {{ $selectedUser ? ($users->firstWhere('id', $selectedUser)->name ?? 'Select User') : 'Select User' }}
            </button>
            <ul class="dropdown-menu w-100">
                @foreach($users as $user)
                    <li>
                        <a class="dropdown-item" href="#" 
                           wire:click.prevent="loadMessages({{ $user->id }})">
                            <strong>{{ $user->name }}</strong> 
                            <small>({{ $user->role }})</small>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Chat Messages -->
    <div id="chatBox" class="border rounded p-3 mb-3 bg-dark text-light" 
         style="height: 300px; overflow-y: auto;">
        @foreach($messages as $message)
            <div class="d-flex mb-2 {{ $message['is_me'] ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="p-2 rounded {{ $message['is_me'] ? 'bg-primary text-white' : 'bg-light text-dark' }}" 
                     style="max-width: 70%;">
                    <strong>{{ $message['is_me'] ? 'You' : $message['from_name'] }}:</strong>
                    <div>{{ $message['message'] }}</div>
                    <small class="d-block text-end mt-1">
                        {{ $message['created_at'] }}
                    </small>
                </div>
            </div>
        @endforeach
    </div>

    @if($selectedUser)
    <!-- Message Input -->
    <form wire:submit.prevent="sendMessage">
        <div class="input-group">
            <input type="text" class="form-control" 
                   wire:model="message" 
                   placeholder="Type your message..." 
                   required>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </form>
    @endif
</div>
