@extends('layouts.dashboard.app')

@section('container')
    <section class="section">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title">
                    {{ $title }}
                    <span>
                        <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#modal-form"
                            onclick="openFormDialog('modal-form', 'add')"><i class="bi bi-plus-lg"></i></button>
                    </span> 
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Penerima</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $appointment->title }}</td>
                                    <td>{{ $appointment->receiver->name }}</td>
                                    <td>{{ $appointment->start }}</td>
                                    <td>{{ $appointment->end }}</td>
                                    <td>
                                        @if ($appointment->creator_id == auth()->id())
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal"
                                                    data-bs-target="#modal-form"
                                                    onclick="openFormDialog('modal-form', 'edit', '{{ $appointment->id }}', '{{ $appointment->title }}', '{{ $appointment->receiver->name }}', '{{ $appointment->start }}', '{{ $appointment->end }}')">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteDialog('{{ route('dashboard.appointment.destroy', $appointment->id) }}')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade text-left" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content rounded shadow">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="form-modal" action="{{ route('dashboard.appointment.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label>title<span class="text-danger fw-bold">*</span></label>
                                    <input type="hidden" class="form-control clear-after" name="id">
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label>Penerima<span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control" name="receiver_id" required>
                                        <option value="" disabled selected hidden>Pilih penerima</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label>Waktu Mulai<span class="text-danger fw-bold">*</span></label>
                                    <input type="datetime-local" class="form-control" name="start" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label>Waktu Selesai<span class="text-danger fw-bold">*</span></label>
                                    <input type="datetime-local" class="form-control" name="end" required>
                                </div>
                            </div>
                            <span class="text-danger fw-bold">* Wajib diisi</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1" onclick="saveForm()">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function saveForm() {
            const requiredInputs = [
                { name: 'title', label: 'Judul' },
                { name: 'receiver_id', label: 'Penerima' },
                { name: 'start', label: 'Waktu Mulai' },
                { name: 'end', label: 'Waktu Selesai' }
            ];

            let hasErrors = false;

            requiredInputs.forEach(input => {
                const inputField = document.querySelector(`input[name="${input.name}"], select[name="${input.name}"]`);
                if (inputField && inputField.value.trim() === '') {
                    alertDialog(input.name, input.label);
                    hasErrors = true;
                }
            });

            if (!hasErrors) {
                document.getElementById('form-modal').submit();
            }
        }


        function confirmDelete(deleteUrl) {
            const confirmed = window.confirm("Apakah Anda yakin ingin menghapus ini?");
            
            if (confirmed) {
                window.location.href = deleteUrl;
            }
        }
    </script>
    
    <script>
        function openFormDialog(target, type, id, title, receiver_id, start, end) {
            if (type === 'add') {
                $('#' + target + ' form').attr('action', '{{ route('dashboard.appointment.store') }}');
                $('#' + target + ' .form-control').val('');
                $('#' + target + ' input[name="title"]').attr('required', 'required');
                $('#' + target + ' select[name="receiver_id"]').attr('required', 'required');
                $('#' + target + ' input[name="start"]').attr('required', 'required');
                $('#' + target + ' input[name="end"]').attr('required', 'required');
            } else if (type === 'edit') {
                $('#' + target + ' .clear-after').val('');
                $('#' + target + ' form').attr('action', '{{ route('dashboard.appointment.update') }}');
                $('#' + target + ' .clear-after[name="id"]').val(id);
                $('#' + target + ' input[name="title"]').val(title);
                $('#' + target + ' select[name="receiver_id"]').val(receiver_id);
                $('#' + target + ' input[name="start"]').val(start);
                $('#' + target + ' input[name="end"]').val(end);
            }
            $('#' + target).modal('toggle');
            $('#' + target).attr('data-operation-type', type);
        }
    </script>

@endsection