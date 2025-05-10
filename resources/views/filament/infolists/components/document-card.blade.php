@props([
    'media' => null,
    'label' => 'Document',
    'collection' => 'default'
])

@if(!$media)
    {{-- Tampilan ketika dokumen belum diupload --}}
    <div class="border-2 border-dashed border-gray-200 rounded-lg p-4 text-center bg-gray-50 min-h-40 flex flex-col items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
        </svg>
        <p class="mt-2 text-sm font-medium text-gray-600">Berkas Belum Di Upload</p>
        <p class="text-xs text-gray-500">{{ $label }}</p>
    </div>
@elseif(str($media->mime_type)->contains('pdf'))
    {{-- Tampilan untuk file PDF --}}
    <div class="border rounded-lg overflow-hidden bg-gray-50">
        <div class="bg-gray-100 p-4 flex flex-col items-center justify-center h-40">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
            <p class="mt-2 text-sm font-medium text-gray-700">PDF Document</p>
        </div>
        <div class="p-3 bg-white border-t">
            <a href="{{ $media->getUrl() }}" target="_blank" class="flex items-center justify-between group">
                <span class="text-sm text-blue-600 group-hover:text-blue-800 truncate">{{ $media->file_name }}</span>
                <span class="text-xs text-gray-500 whitespace-nowrap">{{ round($media->size / 1024) }} KB</span>
            </a>
        </div>
    </div>
@else
    {{-- Tampilan untuk gambar --}}
    <div class="group relative">
        <a href="{{ $media->getUrl() }}" target="_blank" class="block">
            <div class="border rounded-lg overflow-hidden bg-white h-40 flex items-center justify-center">
                <img 
                    src="{{ $media->getUrl() }}" 
                    alt="{{ $label }}"
                    class="max-w-full max-h-full object-contain"
                    loading="lazy"
                >
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center transition-all duration-200">
                    <span class="opacity-0 group-hover:opacity-100 bg-white/90 text-gray-800 px-3 py-1 rounded-full text-sm font-medium shadow transition-opacity duration-200">
                        Lihat Dokumen
                    </span>
                </div>
            </div>
            <div class="mt-1 text-center">
                <p class="text-sm text-gray-600">{{ $label }}</p>
                <p class="text-xs text-gray-400">{{ $media->mime_type }} • {{ round($media->size / 1024) }} KB</p>
            </div>
        </a>
    </div>
@endif