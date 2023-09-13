@extends('admin_templates.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                Profile
            </div>
            <div class="card-body">
                <form action="{{ route('admin-post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telp</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" required>
                        <small style="color: red">* Max 2 mb</small> <br>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="" class="form-control" required>
                            <option value="">PILIH</option>
                            @foreach (\App\Models\Administrator::role() as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="float-right btn btn-primary">Submit</button>
                        </form>
                    </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
