<x-filament-panels::page>




        <!-- Form untuk Cek Tiket (dalam tampilan setengah ukuran) -->
        <div class="w-full sm:w-1/2 mx-auto bg-white shadow-md rounded-xl p-4">
            <form wire:submit.prevent="cekTiket" class="space-y-4">
                <x-filament::input label="Nomor Tiket" wire:model.defer="nomorTiket" class="mb-4" />

                <!-- Tombol Cek Tiket -->
                <x-filament::button type="submit" class="w-full mt-4 bg-blue-600 text-white hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">Cek Tiket</x-filament::button>
            </form>
        </div>


<!-- Menampilkan Informasi Tiket dan Komentar -->





                <h3 class="text-xl font-semibold mb-6 text-gray-800">Respons</h3>
                @if(!empty($comments) && is_array($comments)) <!-- Cek jika $comments tidak null dan merupakan array -->
@foreach($comments as $comment)
    <div class="bg-white p-6 rounded-lg shadow-lg mt-8 border border-gray-300">
    <p class="text-yellow-500">Belum ada respons untuk tiket ini.</p>

        @foreach($comment['responses'] as $response)
            <div class="space-y-3 text-gray-700">
<p><strong>user :</strong> <span class="text-blue-600">{{ $response['user']['name'] ?? 'Guest' }}</span></p>
                <p><strong>comment :</strong> {{ $response['message'] }}</p>

                <p><strong>View file:</strong></p>
                <td class="p-2 text-gray-500">
                    @if($response['upload'])
                        <a href="{{ Storage::url($response['upload']) }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                            <img src="/images/pdf.png" alt="PDF" class="h-20 w-20 mr-2">
                        </a>
                    @endif
                    <span class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($response['created_at'])->diffForHumans() }}
                    </span>
                </td>
            </div>
        @endforeach
    </div>
@endforeach
@else
    <p class="text-gray-500">Tidak ada Tiket untuk ditampilkan.</p>
@endif






</x-filament-panels::page>
