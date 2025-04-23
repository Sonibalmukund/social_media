

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Friends') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="container">
                  <h2>My Friends</h2>
                  <ul>
                      @forelse ($friends as $friend)
                          <li>
                              {{ $friend->user_id === auth()->id() ? $friend->friend->name : $friend->user->name }}
                          </li>
                      @empty
                          <li>You have no friends yet.</li>
                      @endforelse
                  </ul>
              
                  <hr>
              
                  <h2>Friend Requests</h2>
                  <ul>
                      @forelse ($pendingRequests as $request)
                          <li>
                              {{ $request->user->name }}
                              <form action="{{ route('friends.acceptRequest', $request->user_id) }}" method="POST" style="display:inline">
                                  @csrf
                                  <x-primary-button class="ms-3">
                                    {{ 'Accept' }}
                                  </x-primary-button>
                              </form>
                              <form action="{{ route('friends.declineRequest', $request->user_id) }}" method="POST" style="display:inline">
                                  @csrf
                                  <x-primary-button class="ms-3">
                                    {{ 'Decline' }}
                                  </x-primary-button>
                              </form>
                          </li>
                      @empty
                          <li>No pending requests.</li>
                      @endforelse
                  </ul>
              
                  <hr>
              
                  <h2>Send Friend Request</h2>
                  <form action="{{ route('friends.sendRequest', ['friendId' => 0]) }}" method="POST" id="sendRequestForm">
                      @csrf
                      <label for="friend_id">Select User:</label>
                      <select name="friend_id" id="friend_id">
                          @foreach ($allUsers as $user)
                              @if ($user->id !== auth()->id())
                                  <option style="color: black;" value="{{ $user->id }}">{{ $user->name }}</option>
                              @endif
                          @endforeach
                      </select>
                      <x-primary-button class="ms-3">
                        {{ __('Send Request') }}
                      </x-primary-button>
                  </form>
              </div>
              
              <script>
                  document.getElementById('sendRequestForm').addEventListener('submit', function(e) {
                      e.preventDefault();
                      const friendId = document.getElementById('friend_id').value;
                      const form = e.target;
                      form.action = `/friends/${friendId}/send-request`;
                      form.submit();
                  });
              </script>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
