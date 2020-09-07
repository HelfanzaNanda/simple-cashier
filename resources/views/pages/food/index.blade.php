@extends('templates.default')
@section('content')

<section class="section">
  <div class="section-body">
    <h2 class="section-title">Food</h2>
    <p class="section-lead">Semua tentang makanan</p>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Food</h4>
            <a href="{{ route('food.create') }}" class="btn btn-sm btn-info pull-right">tambah</a>
            
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Harga</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($foods as $food)
                      <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $food->name }}</td>
                        <td><img src="{{ $food->image }}" width="100" height="auto"></td>
                        <td>Rp. {{ number_format($food->price) }}</td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection