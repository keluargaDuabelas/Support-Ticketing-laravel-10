@extends('layouts.app') <!-- Sesuaikan dengan layout Anda -->

@section('content')
<div class="container mx-auto py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Balas Komentar</h2>

        <!-- Chat Container -->
        <div class="chat-container border rounded-lg p-4 h-96 overflow-y-scroll bg-gray-50">
        @foreach($comment->responses ?? [] as $response)
        <div>
            <strong>{{ $response->user->name }}</strong>: {{ $response->message }}
        </div>
    @endforeach
            <!-- @foreach($comment->responses as $response)
                <div class="mb-4">
                    <div class="text-sm {{ $response->user_id === auth()->id() ? 'text-right' : '' }}">
                        <span class="font-bold">{{ $response->user->name }}</span>
                        <span class="text-gray-500 text-xs">{{ $response->created_at->format('H:i') }}</span>
                    </div>
                    <div class="mt-1 {{ $response->user_id === auth()->id() ? 'bg-blue-100' : 'bg-gray-100' }} p-3 rounded-lg">
                        {{ $response->message }}
                    </div>
                </div>
            @endforeach -->
        </div>

        <!-- Input Form -->
        <form action="{{ route('comments.sendResponse', $comment->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="flex items-center">
                <input
                    type="text"
                    name="message"
                    class="flex-1 border rounded-l-lg p-2 focus:outline-none focus:ring focus:border-blue-300"
                    placeholder="Tulis balasan Anda..."
                    required>
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
