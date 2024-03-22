@extends('base')

@section('title', 'Penjualan')

@section('content_header')
    <h1>Tambah Penjualan</h1>
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
        <div class="card-body">
            <form action="{{ route('sales.add-item') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Produk</label>
                            <select name="id" class="form-control select2bs4" style="width: 100%;" data-placeholder="Pilih Produk...">
                                <option value="" disabled selected>Pilih Produk...</option>
                                @foreach ($produk as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Produk</label>
                            <input name="qty" type="number" value="1" class="form-control" placeholder="Masukkan Jumlah Produk">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="form-actions float-right">
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card border border-dark">
        <div class="card-header bg-dark clearfix">
            <h5 class="mb-0 float-left">
                Tambah
            </h5>
            <div class="form-actions float-right">
                <a href="{{ route('sales.index') }}" name="Find" class="btn btn-sm btn-primary" title="Add Data">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Harga Produk</th>
                        <th class="text-center">Jumlah Produk</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Aksi</th>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                            $total = 0;
                            $kembalian = 0;
                        @endphp
                        @if (empty($sessiondata))
                            <tr>
                                <td colspan="6" class="text-center">Data Kosong</td>
                            </tr>
                        @else
                            @foreach ($sessiondata as $k => $v)
                                <tr>
                                    <td class="text-center">{{ $no++; }}</td>
                                    <td>{{ $produk[$k] }}</td>
                                    <td class="text-right">{{ number_format($v[1],2) }}</td>
                                    <td class="text-center">{{ $v[0] }}</td>
                                    <td class="text-right">{{ number_format($v[0]*$v[1],2) }}</td>
                                    <td class="text-center">
                                        <button type="reset" class="btn btn-sm btn-danger" onclick="location.href='{{ route('sales.delete-item') }}';"><i class="fas fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                                @php
                                    $total += ($v[0]*$v[1])
                                @endphp
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center font-weight-bold">Total</td>
                            <td colspan="2" class="text-center">{{ number_format($total,2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="card border border-dark">
        <div class="card-body">
            <form action="{{ route('sales.add-process') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        @php
                            $bayar = isset($sessiondata['bayar']) ? $sessiondata['bayar'] : 0;
                        @endphp
                        <div class="form-group">
                            <label>Pelanggan</label>
                            <select name="pelanggan_id" class="form-control select2bs4" style="width: 100%;" data-placeholder="Pilih Pelanggan...">
                                <option value="" disabled selected>Pilih Pelanggan...</option>
                                @foreach ($pelanggan as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode Penjualan</label>
                            <input name="kodePenjualan" class="form-control" placeholder="Masukkan Kode Penjualan">
                        </div>
                        <div class="form-group">
                            <label>Total</label>
                            <input name="totalHarga" id="totalHarga" value="{{ $total }}" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Bayar</label>
                            <input name="bayar" id="bayar" value="{{ $bayar }}" type="number" class="form-control" placeholder="Masukkan Nominal Bayar">
                        </div>
                        <div class="form-group">
                            <label>Kembalian</label>
                            <input name="sisa" id="sisa" value="{{ $kembalian }}" readonly class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="form-actions float-right">
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        var totalHargaInput = document.getElementById('totalHarga');
        var bayarInput = document.getElementById('bayar');
        var sisaInput = document.getElementById('sisa');

        function hitungKembalian() {
            var totalHarga = parseFloat(totalHargaInput.value);
            var bayar = parseFloat(bayarInput.value);

            var kembalian = bayar - totalHarga;

            kembalian = kembalian < 0 ? 0 : kembalian;

            sisaInput.value = kembalian;
        }

        bayarInput.addEventListener('input', hitungKembalian);
    </script>
@stop

@section('footer')
<strong>Copyright &copy; 2024 <a href="https://www.instagram.com/onlyra_ia/">AmeliaMutiara</a>.</strong>
All rights reserved.
@stop