{{-- <div class="table-responsive"> --}}
<table class="table rounded table-sm syarat-form"
       id="syarat-form-table">
    <thead>
        <tr class="d-none">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        {{-- <tr class="bg-white">
            <td width="5%" class="text-start">
                <p class="d-none counter">1</p>
                <i class="isax isax-textalign-justifycenter fs-4"></i>
            </td>
            <td class="text-center">
                <div class="form-group mb-0 row align-items-center gap-2">
                    <div class="col-auto">
                        <label class="col-form-label fw-bold text-sm"
                               for="nama_form_1">Nama Form</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control"
                               id="nama_form_1"
                               name="syarat_form[]['nama']"
                               placeholder="Masukkan nama form"
                               type="text" required>
                    </div>
                </div>
            </td>
            <td class="text-center">
                <div class="form-group mb-0 row align-items-center gap-2">
                    <div class="col-auto">
                        <label class="col-form-label fw-bold text-sm"
                               for="kode_isian_1">Kode Isian</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control"
                               id="kode_isian_1"
                               name="syarat_form[]['kode_isian']"
                               placeholder="contoh NO_REGISTRASI"
                               type="text" required>
                    </div>
                </div>
            </td>
            <td class="text-center">
                <div class="form-group mb-0 row align-items-center gap-2">
                    <div class="col-auto">
                        <label class="col-form-label fw-bold text-sm"
                               for="tipe_form_1">Tipe Form</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select"
                                id="tipe_form_1"
                                name="syarat_form[]['tipe_form']" required>
                            <option hidden>Pilih Tipe Form</option>
                            <option value="text">Text</option>
                            <option value="date">Date</option>
                        </select>
                    </div>
                </div>
            </td>
            <td><i class="isax isax-trash fs-4 delete-data"></i></td>
        </tr> --}}
    </tbody>
</table>
<button class="btn btn-primary btn-sm"
        onclick="tambahDataForm()"
        type="button">+ Tambah Syarat Form</button>
{{-- </div> --}}

@push('styles')
    <style>
        .syarat-form .row>* {
            padding: 0 !important;
        }

        .syarat-form label {
            font-size: 0.775rem !important;
        }

        .syarat-form input,
        .syarat-form select {
            width: 100% !important;
            font-size: 0.775rem !important;
        }

        .delete-data {
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#syarat-form-table').DataTable({
                lengthChange: false,
                searching: false,
                paging: false,
                info: false,
                // row reorder
                rowReorder: {
                    enable: true,
                }
            });

            $('#syarat-form-table tbody').on('click', '.delete-data', function() {
                // var table = $('#syarat-form-table').DataTable();
                // table.row($(this).parents('tr')).remove().draw();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var table = $('#syarat-form-table').DataTable();
                        table.row($(this).parents('tr')).remove().draw();
                    }
                });
            });
        });

        function tambahDataForm(nama_form, kode_isian, tipe_form) {
            if (tipe_form !== 'text' && tipe_form !== 'date') {
                tipe_form = '';
            }
            // get last counter
            var lastCounter = $('#syarat-form-table tbody tr:last-child .counter').text();
            // increment counter
            var newCounter = parseInt(lastCounter ? lastCounter : 0) + 1;
            var table = $('#syarat-form-table').DataTable();
            var row = table.row.add([
                '<p class="d-none counter">' + newCounter +
                '</p><i class="isax isax-textalign-justifycenter fs-4"></i>',
                '<div class="form-group mb-0 row align-items-center gap-2"><div class="col-auto"><label class="col-form-label fw-bold text-sm" for="nama_form_' +
                newCounter +
                '">Nama Form</label></div><div class="col-8"><input class="form-control" id="nama_form_' +
                newCounter + '" name="syarat_form[' + newCounter +
                '][nama]" placeholder="Masukkan nama form" type="text" required></div></div>',
                '<div class="form-group mb-0 row align-items-center gap-2"><div class="col-auto"><label class="col-form-label fw-bold text-sm" for="kode_isian_' +
                newCounter +
                '">Kode Isian</label></div><div class="col-8"><input class="form-control" id="kode_isian_' +
                newCounter + '" name="syarat_form[' + newCounter +
                '][kode_isian]" placeholder="contoh NO_REGISTRASI" type="text" required></div></div>',
                '<div class="form-group mb-0 row align-items-center gap-2"><div class="col-auto"><label class="col-form-label fw-bold text-sm" for="tipe_form_' +
                newCounter +
                '">Tipe Form</label></div><div class="col-8"><select class="form-select" id="tipe_form_' +
                newCounter + '" name="syarat_form[' + newCounter +
                '][tipe_form]" required><option hidden value="">Pilih Tipe Form</option><option value="text">Text</option><option value="date">Date</option></select></div></div>',
                '<i class="isax isax-trash fs-4 delete-data"></i>'
            ]).draw(false).node();
            $(row).addClass('bg-white');
            $(row).find('td').eq(0).addClass('text-start').css('width', '5%');
            $(row).find('td').eq(1).addClass('text-center').css('width', '30%');
            $(row).find('td').eq(2).addClass('text-center').css('width', '30%');
            $(row).find('td').eq(3).addClass('text-center').css('width', '30%');

            // set value
            $('#nama_form_' + newCounter).val(nama_form);
            $('#kode_isian_' + newCounter).val(kode_isian);
            $('#tipe_form_' + newCounter).val(tipe_form);
        }

        // function consoleLogInputForm() {
        //     var data = [];
        //     $('#syarat-form-table tbody tr').each(function() {
        //         var nama_form = $(this).find('input[name="syarat_form[][nama]"]').val();
        //         var kode_isian = $(this).find('input[name="syarat_form[][kode_isian]"]').val();
        //         var tipe_form = $(this).find('select[name="syarat_form[][tipe_form]"]').val();
        //         data.push({
        //             nama_form: nama_form,
        //             kode_isian: kode_isian,
        //             tipe_form: tipe_form
        //         });
        //     });
        //     console.log(data);
        // }
    </script>
@endpush
