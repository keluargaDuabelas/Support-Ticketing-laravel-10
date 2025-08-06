<x-filament-panels::page>
    <div class="space-y-4"> <!-- Single Root Element -->

    <div class="p-4 bg-white rounded shadow">

    <h2 class="text-lg font-bold mb-4">Detail Tiket</h2>
    <table class="w-full border-collapse border border-gray-300">
        <tbody>
        <tr class="border-b">
                <td class="p-2 font-semibold text-gray-600 border-r border-gray-300">Nama User</td>
                <td class="p-2 text-gray-500">{{ $comment->tiket->user->name ?? 'N/A' }}</td>
            </tr>
            <tr class="border-b">
                <td class="p-2 font-semibold text-gray-600 border-r border-gray-300">Nomor Tiket</td>
                <td class="p-2 text-gray-500">{{ $comment->tiket->nomor ?? 'N/A' }}</td>
            </tr>
            <tr class="border-b">
                <td class="p-2 font-semibold text-gray-600 border-r border-gray-300">Nama</td>
                <td class="p-2 text-gray-500">{{ $comment->tiket->name ?? 'N/A' }}</td>
            </tr>
            <tr class="border-b">
                <td class="p-2 font-semibold text-gray-600 border-r border-gray-300">Deskripsi</td>
                <td class="p-2 text-gray-500">{{ $comment->tiket->description ?? 'Tidak ada deskripsi' }}</td>
            </tr>
            <tr class="border-b">
                <td class="p-2 font-semibold text-gray-600 border-r border-gray-300">Status</td>
                <td class="p-2 text-gray-500">{{ $comment->tiket->status ?? 'Tidak diketahui' }}</td>
            </tr>
            <tr class="border-b">
                <td class="p-2 font-semibold text-gray-600 border-r border-gray-300">Kategori</td>
                <td class="p-2 text-gray-500">{{ $comment->tiket->kategori->name ?? 'Tidak ada kategori' }}</td>
            </tr>
            <tr class="border-b">
                <td class="p-2 font-semibold text-gray-600 border-r border-gray-300">Sub Kategori</td>
                <td class="p-2 text-gray-500">{{ $comment->tiket->subkategori->description ?? 'Tidak ada sub kategori' }}</td>
            </tr>
            <tr>
                <td class="p-2 font-semibold text-gray-600 border-r border-gray-300">View File</td>
                <td class="p-2 text-gray-500">
                    @if(isset($comment->tiket) && $comment->tiket->upload)
                    <a href="{{ Storage::url($comment->tiket->upload) }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                        <img src="/images/pdf.png" alt="PDF" class="h-20 w-20 mr-2">
                    </a>
                    @endif
                </td>
            </tr>

        </tbody>

    </table>
    <p class="mt-2"><strong>Created tiket:</strong> {{ $comment->created_at->format('d M Y') }}</p>




        </div>
        <div class="p-4 bg-white rounded shadow">
            <h3 class="text-lg font-bold">respond</h3>

        @foreach($comment->responses as $response)
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm mb-4">
    <div class="flex flex-col items-left justify-left gap-4">
        <p class="text-sm text-gray-500 font-semibold">User: {{ $response->user->name }}</p>
        <p class="text-sm text-gray-500 font-semibold">Message: {{ $response->message }}</p>
@if($response->upload)
            <div class="mt-4 flex items-center">
                <a href="{{ Storage::url($response->upload) }}" target="_blank" class="flex items-center space-x-2 text-blue-600 hover:underline">
                    <img src="/images/pdf.png" alt="PDF" class="h-10 w-10 object-cover">

                </a>
            </div>
        @endif
        <span class="text-sm text-gray-500">
        {{ $response->created_at->diffForHumans() }}
        </span>
        <!-- Tombol Hapus -->
        <form action="{{ route('responses.destroy', $response->id) }}" method="POST" class="mt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded shadow-sm text-white" style="background-color: red;">
                    Hapus
                </button>
            </form>
        </div>
    </div>
@endforeach

        </div>

        <div class="p-4 bg-white rounded shadow">
            <h3 class="text-lg font-bold">comment</h3>

                     <form action="{{ route('responses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            <div class="mb-4">
        <!-- <label for="status" class="block text-sm font-medium text-gray-700">Status Tiket</label>
        <select name="status" id="status" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
            <option value="open" {{ $comment->tiket->status == 'open' ? 'selected' : '' }}>Open</option>
            <option value="in_progress" {{ $comment->tiket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>

            <option value="resolved" {{ $comment->tiket->status == 'resolved' ? 'selected' : '' }}>resolved</option>
        </select> -->
    </div>
            <!-- Pesan -->
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                <textarea name="message" id="message" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <!-- Upload File -->
            <div class="mb-4">
    <label for="upload" class="block text-sm font-medium text-gray-700">Lampiran (PDF)</label>
    <input type="file" name="upload" id="upload" accept="application/pdf" class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm">
</div>


            <!-- Submit Button -->
            <!-- Tombol Kirim -->
    <div class="flex justify-center">
        <button type="submit" class="px-4 py-2 rounded shadow-sm text-white" style="background-color: green;">
            Kirim Balasan
        </button>
    </div>
        </form>

        </div>




    </div>

     <!-- End of Single Root Element -->
</x-filament-panels::page>
