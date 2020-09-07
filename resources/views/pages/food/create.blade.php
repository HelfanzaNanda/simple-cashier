@extends('templates.default')
@section('content')

<section class="section">

    <div class="section-body">
        <h2 class="section-title">Add Food</h2>
        <p class="section-lead">Semua tentang makanan.</p>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Food</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('food.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>Nama Makanan</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}">

                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" class="dropify @error('image') is-invalid @enderror" name="image"
                                    data-default-file="{{ old('image') }}" />
                                @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Harga Makanan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-primary">Rp. </span>
                                    </div>
                                    <input type="tel" class="form-control @error('price') is-invalid @enderror" name="price"
                                    value="{{ old('price') }}" id="rupiah">

                                    @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-action">
                                <button type="submit" class="btn btn-success btn-sm">simpan</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<section class="section">
@endsection

@section('script')
<script>
    const rupiah = document.querySelector('#rupiah')
    rupiah.addEventListener('keyup', function (e) {
        rupiah.value = formatRupiah(this.value)
    });

    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
        return rupiah;
    }
</script>
@endsection