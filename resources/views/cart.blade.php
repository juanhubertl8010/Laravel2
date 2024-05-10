@extends('template.main')
@section('title', 'Cart')
@section('body')
<!-- cart + summary -->
<section class="bg-light my-5">
  <div class="container">
    <div class="row">
      <!-- cart -->
      <div class="col-lg-9">
        <div class="card border shadow-0">
          <div class="m-4">
            <h4 class="card-title mb-4">Your shopping cart</h4>
            @php
              $totalPrice = 0; // Inisialisasi total harga
            @endphp
            @foreach ($data as $d)
            <div class="row gy-3 mb-4">
                <div class="col-lg-5">
                  <div class="me-lg-5">
                    <div class="d-flex">
                      <img src="{{ $d['item']->image }}" class="border rounded me-3" style="width: 96px; height: 96px;" />
                      <div class="">
                        <a href="#" class="nav-link">{{ $d['item']->name }}</a>
                        <p class="text-muted">{{ $d['id'] }}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                  <div class="">
                    <input type="number" name='total[]' value="{{ $d['total'] }}">
                  </div>
                  <div class="">
                    <text class="h6">${{ $d['item']->price * $d['total'] }}</text> <br />
                    <small class="text-muted text-nowrap"> ${{ $d['item']->price }} / per item </small>
                  </div>
                </div>
                <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                  <div class="float-md-end">
                    <a href="#!" class="btn btn-light border px-2 icon-hover-primary"><i class="fas fa-heart fa-lg px-1 text-secondary"></i></a>
                    <a href="{{ route('cart.remove', ['id' => $d['id']]) }}" class="btn btn-light border text-danger icon-hover-danger">Remove</a>
                  </div>
                </div>
              </div>
              @php
                $totalPrice += $d['item']->price * $d['total']; // Menambahkan harga tiap item ke total harga
              @endphp
            @endforeach
          </div>

          <div class="border-top pt-4 mx-4 mb-4">
            <p><i class="fas fa-truck text-muted fa-lg"></i> Free Delivery within 1-2 weeks</p>
            <p class="text-muted">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
              aliquip
            </p>
          </div>
        </div>
      </div>
      <!-- cart -->
      <!-- summary -->
      <div class="col-lg-3">
        <div class="card mb-3 border shadow-0">
          <div class="card-body">
            <form>
              <div class="form-group">
                <label class="form-label">Have coupon?</label>
                <div class="input-group">
                  <input type="text" class="form-control border" name="" placeholder="Coupon code" />
                  <button class="btn btn-light border">Apply</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card shadow-0 border">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <p class="mb-2">Total price:</p>
              <p class="mb-2">${{ $totalPrice }}</p> <!-- Menampilkan total harga -->
            </div>

            <div class="mt-3">
              <a href="#" class="btn btn-success w-100 shadow-0 mb-2"> Make Purchase </a>
              <a href="#" class="btn btn-light w-100 border mt-2"> Back to shop </a>
            </div>
          </div>
        </div>
      </div>
      <!-- summary -->
    </div>
  </div>
</section>
<!-- cart + summary -->
@endsection
