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
Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Pemerintah Kabupaten Tabanan<br>Jl. D. Buyan, Delod Peken, Kec. Kediri, Kabupaten Tabanan, Bali 82121<br><br>
© 2026 <strong>DPMPTSP Kabupaten Tabanan</strong> | Powered by <strong>CV Mai Harta</strong>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
