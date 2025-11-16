@php
    $sekolah = \App\Models\Sekolah::find($get('id_sekolah'));
@endphp

<div class="p-4 rounded-xl bg-gray-50 border space-y-1">
    <div class="font-semibold text-gray-800">Informasi Rekening Sekolah</div>

    @if(!$sekolah)
        <div class="text-sm text-gray-500">Pilih sekolah terlebih dahulu.</div>
    @else
        <div class="text-sm"><strong>Nama Rekening:</strong> {{ $sekolah->nama_rekening }}</div>
        <div class="text-sm"><strong>No Rekening:</strong> {{ $sekolah->no_rekening }}</div>
    @endif
</div>
