<div class="form-group mt-4">
    <div class="row align-items-center">
        <div class="col-9">
            <select class="form-select d-block"
                    id="verifikator_data">
                <option></option>
            </select>
        </div>
        <div class="col-3">
            <button class="btn btn-primary"
                    onclick="add()"
                    type="button">+ Tambah Verifikator</button>
        </div>
    </div>
</div>
<table class="table rounded table-sm alur-verifikator"
       id="alur-verifikator-table">
    <thead>
        <tr class="d-none">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('styles')
    <style>
        .alur-verifikator .row>* {
            padding: 0 !important;
        }

        .alur-verifikator label {
            font-size: 0.775rem !important;
        }

        .alur-verifikator input,
        .alur-verifikator select {
            width: 100% !important;
            font-size: 0.775rem !important;
        }

        .delete-data {
            cursor: pointer;
        }

        .select2-results__option,
        .select2-selection__rendered {
            font-size: 0.775rem !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#alur-verifikator-table').DataTable({
                lengthChange: false,
                searching: false,
                paging: false,
                info: false,
                // row reorder
                rowReorder: {
                    enable: true,
                }
            });

            $('#alur-verifikator-table tbody').on('click', '.delete-data', function() {
                // var table = $('#alur-verifikator-table').DataTable();
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
                        var table = $('#alur-verifikator-table').DataTable();
                        table.row($(this).parents('tr')).remove().draw();
                    }
                });
            });

            $('#verifikator_data').select2({
                placeholder: 'Pilih Verifikator',
                theme: 'bootstrap-5',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: '{{ route('admin.master-data.jenis-izin.list-verifikator') }}',
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page || 1,
                            except: $("input[name='alur_verifikator[][id]']")
                                .map(function() {
                                    return $(this).val();
                                }).get()
                        }
                    }
                },
            });
        });

        function tambahAlurVerifikator(nama_verifikator, id_verifikator, jenis_verifikator) {
            if (nama_verifikator == null || id_verifikator == null || nama_verifikator == '' || id_verifikator == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pilih verifikator terlebih dahulu!',
                });
                return;
            } else {
                // get last counter
                var lastCounter = $('#alur-verifikator-table tbody tr:last-child .counter').text();
                // increment counter
                var newCounter = parseInt(lastCounter ? lastCounter : 0) + 1;
                var table = $('#alur-verifikator-table').DataTable();
                var row = table.row.add([
                    '<p class="d-none counter">' + newCounter +
                    '</p><i class="isax isax-textalign-justifycenter fs-4"></i>',
                    '<div class="form-group mb-0 row align-items-center gap-2"><div class="col-auto"><label class="col-form-label fw-bold text-sm" for="nama_' +
                    newCounter +
                    '">Nama Verifikator</label></div><div class="col-8"><input class="form-control" id="nama_verifikator_' +
                    newCounter +
                    '" name="alur_verifikator[' + newCounter +
                    '][nama]" type="hidden"><input class="form-control" id="id_verifikator_' +
                    newCounter +
                    '" name="alur_verifikator[' + newCounter +
                    '][id]" type="hidden"><input class="form-control" id="nama_' +
                    newCounter +
                    '" readonly type="text" value="' + nama_verifikator + '"></div></div>',
                    '<div class="form-group mb-0 row align-items-center gap-2"><div class="col-auto"><label class="col-form-label fw-bold text-sm" for="jenis_verifikator_' +
                    newCounter +
                    '">Jenis Verifikator</label></div><div class="col-8"><select class="form-select" id="jenis_verifikator_' +
                    newCounter +
                    '" name="alur_verifikator[' + newCounter +
                    '][jenis_verifikator]" required><option></option><option value="0">Verifikator FO</option><option value="1">Verifikator OPD</option><option value="2">Verifikator BO</option><option value="3">Verifikator JF</option><option value="4">Penandatangan</option></select></div></div>',
                    '<i class="isax isax-trash fs-4 delete-data"></i>'
                ]).draw(false).node();
                $(row).addClass('bg-white');
                $(row).find('td').eq(0).addClass('text-start').css('width', '5%');
                $(row).find('td').eq(1).addClass('text-start').css('width', '50%');
                $(row).find('td').eq(2).addClass('text-start').css('width', '30%');
                $(row).find('td').eq(3).css('width', '15%');

                // set value
                $('#nama_verifikator_' + newCounter).val(nama_verifikator);
                $('#nama_' + newCounter).text(nama_verifikator);
                $('#id_verifikator_' + newCounter).val(id_verifikator);
                $('#jenis_verifikator_' + newCounter).select2({
                    placeholder: 'Pilih Jenis Verifikator',
                    theme: 'bootstrap-5',
                    width: '100%'
                });
                $('#jenis_verifikator_' + newCounter).val(jenis_verifikator);
            }
        }

        function add() {
            var nama_verifikator = $('#verifikator_data option:selected').text();
            var id_verifikator = $('#verifikator_data').val();
            var jenis_verifikator = $('#verifikator_data').select2('data')[0].jenis_verifikator;
            tambahAlurVerifikator(nama_verifikator, id_verifikator, jenis_verifikator);
            $('#verifikator_data').val(null).trigger('change');
        }

        // function consoleLogInpuAlur() {
        //     var data = [];
        //     $('#alur-verifikator-table tbody tr').each(function() {
        //         var nama = $(this).find('input[name^="alur_verifikator[][nama]"]').val();
        //         var id = $(this).find('input[name^="alur_verifikator[][id]"]').val();
        //         var jenis_verifikator = $(this).find('select[name^="alur_verifikator"]').val();
        //         data.push({
        //             nama: nama,
        //             jenis_verifikator: jenis_verifikator,
        //             id: id
        //         });
        //     });
        //     console.log(data);
        // }
    </script>
@endpush
