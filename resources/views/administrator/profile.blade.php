@extends('admin_templates.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                Profile
            </div>
            <div class="card-body">
                <form action="{{ route('admin-profile-post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('administrator')->user()->name }}" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('administrator')->user()->jabatan }}" id="jabatan" name="jabatan">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telp</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('administrator')->user()->phone }}" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('administrator')->user()->username }}" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small style="color: red">* Kosongi jika tidak ingin di ubah</small>
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
                        <img src="{{ asset('storage/'. Auth::guard('administrator')->user()->avatar) }}" alt="" width="200px" class="img-thumbnail">
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="float-right btn btn-primary">Update</button>
                        </form>
                    </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
