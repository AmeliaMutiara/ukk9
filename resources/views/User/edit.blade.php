@extends('base')

@section('title', 'Pelanggan')

@section('content_header')
    <h1>Edit Pelanggan</h1>
@stop

@section('content')
    @if (session('msg'))
        <div class="alert alert-{{ session('type') ?? 'info' }}" role="alert">
            {{ session('msg') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $e)
                {{ $e }}
            @endforeach
        </div>
    @endif
    <div class="card border border-dark">
        <div class="card-header bg-dark clearfix">
            <h5 class="mb-0 float-left">
                Edit
            </h5>
            <div class="form-actions float-right">
                <a href="{{ route('user.index') }}" name="Find" class="btn btn-sm btn-primary" title="Back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <form action="{{ route('user.edit-process') }}" method="post">
            <div class="card-body">
                @csrf
                <div class="row">
                    <input name="id" type="hidden" value="{{ $data->id }}" />
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="name" value="{{ $data->name }}" class="form-control" rows="6" placeholder="Masukkan Nama User">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" value="{{ $data->username }}" class="form-control" rows="6" placeholder="Masukkan Username">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control" rows="6" placeholder="Masukkan Password Baru(opsional)">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Level</label>
                            <select name="level" class="form-control select2bs4" style="width: 100%;" data-placeholder="Pilih Level...">
                                <option value="" disabled selected>Pilih Level...</option>
                                @foreach ($level as $key => $value)
                                    <option value="{{ $key }}" @selected($key==$data->level)>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="form-actions float-right">
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <button type="submit" class="btn btn-success" onclick="$(this).addClass('disabled');$('form').submit();">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop

@section('footer')
<strong>Copyright &copy; 2024 <a href="https://www.instagram.com/onlyra_ia/">AmeliaMutiara</a>.</strong>
All rights reserved.
@stop