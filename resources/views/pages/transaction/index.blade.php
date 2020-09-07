@extends('templates.default')
@section('content')

<section class="section">
    <div class="section-body">

        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    @foreach ($foods as $food)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card card-primary" style="cursor: pointer;" id="card-food">
                        <div class="card-header justify-content-center">
                            <h4 id="food-name">{{ $food->name }}</h4>
                            <p id="food-id" hidden>{{ $food->id }}</p>
                        </div>
                        <div class="card-body">
                            <img class="card-img-top" src="{{ $food->image }}" height="80" width="auto">
                            <p id="food-price" class="text-center" data-price="{{ $food->price }}">Harga : Rp. {{ number_format($food->price) }}</p>
                        </div>
                        </div>
                    </div>
                    @endforeach
                 </div>          
            </div>
    
            <div class="col-md-4">
                <div class="card" id="sample-login">
                    <div class="card-header justify-content-center bg-primary">
                        <h4 class="text-white">New Customer</h4>
                    </div>
                    <div class="card-body pt-">
                        <p class="text-muted text-center">Dine In <i class="fas fa-arrow-down"></i></p>
                        <h1 class="divider"></h1>
                        <div class="row" id="row-food-bill"></div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger btn-block" id="clear">clear</button>
                </div>
    
                <div class="btn-group btn-group-md btn-block" role="group">
                    <button type="button" class="btn btn-sm btn-info" id="save-bill">Save Bill</button>
                    <a type="button" class="btn btn-sm btn-info text-white" target="_blank" id="print-bill">Print Bill</a>
                </div>
    
                <button type="button" class="btn btn-primary btn-lg btn-block" id="charge"><i class="fas fa-file-invoice"></i> Charge</button>
                
            </div>
        </div>

    </div>
</section>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="detail">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Transaksi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Makanan</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Harga</th>
                          </tr>
                        </thead>
                        <tbody id="modal-body"></tbody>
                    </table>
                </div>
                <div class="col-md-4 border-left">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 id="total-charge"></h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Masukkan Uang Pembeli</label>
                                <input type="tel" id="pay" class="form-control form-control-sm"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6 id="refund"></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="save" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
</div>


@endsection

@section('script')
    <script>
        const cardFoods = document.querySelectorAll('#card-food');
        const cardNameFoods = document.querySelectorAll('#food-name');
        const cardPriceFoods = document.querySelectorAll('#food-price');
        const cardIdFoods = document.querySelectorAll('#food-id');
        const foodBill = document.querySelector('#row-food-bill');
        const save = document.querySelector('#save-bill');
        const print = document.querySelector('#print-bill');
        const charge = document.querySelector('#charge');
        const modalBody = document.querySelector('#modal-body');
        const totalCharge = document.querySelector('#total-charge');
        const refund = document.querySelector('#refund');
        const pay = document.querySelector('#pay');
        const modal = document.querySelector('#detail');
        const saveModal = document.querySelector('#save');
        const clear = document.querySelector('#clear');
        
        let foods = [];
        let total = 0;

        const token = "{{ csrf_token() }}";
        const url = '{{ config('app.url') }}';

        cardFoods.forEach((cardFood, index) => {
            cardFood.addEventListener('click', function(){        
                let foodHtml = ``;
                const id = cardIdFoods[index].textContent;
                const name = cardNameFoods[index].textContent;
                const price = cardPriceFoods[index].dataset.price;
                const qty = 1;
                const filterFoodSelected = foods.some(f => f.id === id);
                if(!filterFoodSelected){
                    total += parseInt(price);
                    foods.push({id, name, qty, price});
                }else{
                    sameFood(foods, id, price);
                }
                foods.map((f, i) => foodHtml += showFood(f));   
                charge.innerText = 'Rp. '+rupiah(total);
                foodBill.innerHTML = foodHtml;
            });
        });

        clear.addEventListener('click', function(){
            if(foods.length < 1){
                const text = "harus memilih makanan dahulu";
                alertFailed(text);
            }else{
                alertQuestion();
            }
        })

        save.addEventListener('click', function(){
            const text = "anda berhasil menyimpan";
            alertSuccess(text);
        });

        function showFood(food){
            return `
            <div class="col-md-5">${food.name}</div>
            <div class="col-md-3">${food.qty}x</div>
            <div class="col-md-4">${rupiah(food.price)}</div> `
        }

        function sameFood(foods, id, price){
            foods.map(f => {
                if(f.id === id) {
                    f.qty++
                    total += parseInt(price);
                    f.price = price * f.qty;
                }
            });
        }

        function rupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
                ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }


        function alertQuestion(){
            Swal.fire({
                title: 'Are you sure?',
                text: "anda akan menghapus makanan yang di pilih",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
                }).then((result) => {
                if (result.isConfirmed) {
                    foods = [];
                    foodBill.innerHTML = ``;
                    const text = "makanan yang di pilih telah dihapus";
                    alertDelete(text);
                }
            })
        }

        function alertDelete(text){
            Swal.fire(
                'Deleted!',
                text,
                'success'
            )
        }

        function alertSuccess(text){
            Swal.fire(
                'Saved!',
                text,
                'success'
            );
        }

        function alertFailed(text){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: text
            })
        }

        charge.addEventListener('click', function(){
            if(foods.length < 1){
                const text = "harus memilih makanan, minimal 1";
                alertFailed(text);
            }else{
                $('#detail').modal();
                let modalDetail = ``;
                let no = 1;
                totalCharge.innerText = 'Total Charge : Rp. '+rupiah(total);
                foods.map(f => {
                    modalDetail += showModalDetail(f, no);
                    no++;
                });
                modalBody.innerHTML = modalDetail;
            }
        })

        function showModalDetail(food, no){
            return `<tr>
            <th scope="row">${no}</th>
            <td>${food.name}</td>
            <td>${food.qty}</td>
            <td>${rupiah(food.price)}</td>
            </tr>`
        }

        pay.addEventListener('input', function() {
            if(pay.value < total){
                refund.innerText = "Kembali - "
            }else{
                const rfnd = this.value - total;
                refund.innerText = "Kembali : Rp. "+ rupiah(rfnd);
            }
        })

        saveModal.addEventListener('click', function(){
            if(pay.value == '' || pay.value < total){
                const text = "uang yang di bayarkan harus lebih dari total";
                alertFailed(text);
            }else{
                const text = "terima kasih sudah belanja di toko kami";
                alertSuccess(text);
            }
        })

        print.addEventListener('click', function(){
            if(foods.length < 1){
                const text = "harus memilih makanan, minimal 1";
                alertFailed(text);
            }else{

                printPdf();
            }
        })

        function printPdf(){

            fetch(url+"transaction/print", {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    //"X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify(foods)
            })
            .then((data) => {
                window.location.href = redirect;
                alertSuccess("berhasil print");
            })
            .catch(function(error) {
                console.log(error);
            });
        }
    </script>
@endsection