@extends('admin_templates.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                Profile
            </div>
            <div class="card-body">
                <form action="{{ route('admin-update', $administrator->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $administrator->name }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telp</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $administrator->phone }}">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $administrator->username }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" class="form-control" id="avatar" name="avatar">
                        <small style="color: red">* Kosongi jika tidak ingin di ubah</small><br>
                        <small style="color: red">* Max 2 mb</small> <br>
                        <img src="{{ asset('storage/'. $administrator->avatar) }}" alt="" width="200px" class="img-thumbnail">
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="" class="form-control" required>
                            <option value="">PILIH</option>
                            @foreach (\App\Models\Administrator::role() as $key => $item)
                                <option value="{{ $key }}" {{ ($key == $administrator->role)?'selected':'' }}>{{ $item }}</option>
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
