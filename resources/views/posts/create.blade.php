





<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Posts') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
                      <div class="container">
                      <h2>Create Post</h2>
                      <form method="POST" action="{{ route('posts.store') }}">
                          @csrf
                          <div class="form-group">
                              <label for="content">Content</label>
                              <textarea name="content" class="form-control" required></textarea>
                          </div>
                          <x-primary-button class="ms-3">
                            {{ __('Post') }}
                          </x-primary-button>
                      </form>
                    </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
