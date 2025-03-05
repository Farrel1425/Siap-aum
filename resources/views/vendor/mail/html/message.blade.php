<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Pemerintah Kabupaten Buleleng<br>Mall Pelayanan Publik - Lantai III Pasar Banyuasri, Kelurahan Banyuasri, Kecamatan Buleleng <br><br>
© 2024 <strong>DPMPTSP Kabupaten Buleleng</strong> | Powered by <strong>CV Mai Harta</strong>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
