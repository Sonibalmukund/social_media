



<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Posts') }}
      </h2>
      
      <a href="{{ route('posts.create') }}" class = 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150'>Posts Create</a>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
                  @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                  @endif
                <div class="container">
                    <h2>Friend Posts</h2>
                    @foreach($posts as $post)
                        <div class="card my-3">
                            <div class="card-body">
                                <h5>{{ $post->user->name }}</h5>
                                <p>{{ $post->content }}</p>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach
                    @php
                      $user = auth()->user();
                      $friends = ($user->friend ?? collect())->merge($user->friendOf ?? collect());
                      $canInteract = $post->user_id === $user->id || $friends->pluck('id')->contains($post->user_id);
                    @endphp
                    @if ($canInteract)
                      <form action="{{ route('posts.like', $post->id) }}" method="POST">
                          @csrf
                          <x-primary-button class="ms-3">
                            {{ $post->likes->where('user_id', $user->id)->count() ? 'Unlike' : 'Like' }}
                          </x-primary-button>
                          <span>{{ $post->likes->count() }} likes</span>
                      </form>
                    @endif
                    @foreach ($post->comments as $comment)
    <div>
        <strong>{{ $comment->user->name }}</strong>: {{ $comment->body }}
    </div>
@endforeach


@if ($canInteract)
    <form action="{{ route('comments.store', $post) }}" method="POST">
        @csrf
        <textarea name="body" rows="2" placeholder="Write a comment..." required></textarea>
        <x-primary-button class="ms-3">
          {{ __('Comment') }}
        </x-primary-button>
    </form>
@endif

                </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
