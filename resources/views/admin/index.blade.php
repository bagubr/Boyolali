@extends('admin_templates.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Admin</h6>
                <a href="{{ route('admin-create') }}" class="btn btn-success float-right">Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Avatar</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>  
                            @foreach ($admin as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->jabatan }}</td>
                                    <td>{{ ($item->is_active)?'active':'non-active' }}</td>
                                    <td><img src="{{ asset('storage/'.$item->avatar) }}" alt="" srcset="" class="img-thumbnail" width="200px"></td>
                                    <td>{{ array_search($item->role, \App\Models\Administrator::role()) }}</td>
                                    <td>
                                        <a class="btn btn-sm badge bg-primary text-white" href="{{ route('admin-detail', $item->id) }}">Edit {{ $item->id }}</a>
                                        <form action="{{ route('admin-delete', $item->id) }}" method="post" id="formDelete{{ $item->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm badge bg-danger text-white" onclick="deleteAdmin({{ $item->id }})">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
@push('js')
    <script>
        function deleteAdmin(id) {
            swal({
                    title: "Hapus ?",
                    text: "Data Akan Terhapus Permanen",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var formDelete = $('#formDelete'+id);
                        formDelete.submit();
                        // swal("Berhasil!", {
                        //     icon: "success",
                        // });
                        // location.replace(`{{ route('admin') }}`)
                    } else {
                        swal("Cancel");
                    }
                });
        }
    </script>
@endpush