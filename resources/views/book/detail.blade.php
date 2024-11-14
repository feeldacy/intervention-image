@extends('auth.layouts')
@section('content')


<div class="row justify-content-center mt-5">
    <div class="card" style="padding: 20px; width: 18rem;">
        <img src="{{asset('storage/cover_book_images/'. $books_data->photo)}}" alt="">
        <div class="card-body">
          <p class="card-text" style="font-size: 28px;">{{$books_data->judul}}</p>
          <p class="card-text" style="font-size: 20px;">{{$books_data->penulis}}</p>
        </div>
        <a href="{{'/books'}}" class="btn btn-secondary" style="margin-top: 30px; margin-bottom:30px;">Kembali</a>
    </div>
</div>


@endsection
