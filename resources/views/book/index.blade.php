<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />


    <style>
        body{
        padding: 30px;
        }

        h1{
            text-align: center;
        }

        .tablesview{
            padding: 20px;
            border-radius: 20px;
        }
    </style>
</head>
<body class="background-color">

    <nav id="navbar-example2" class="navbar bg-primary px-3 mb-3">
        <a class="navbar-brand text-light" href="#">Books Data</a>
        <ul class="nav nav-pills">
          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link text-light">Logout</button>
            </form>
          </li>
        </ul>
    </nav>

    @if(Session::has('pesan'))
        <div class="alert alert-success">{{Session::get('pesan')}}</div>
    @endif

    <div class="tablesview">
        @if(Auth::user()->level == 'admin')
        <a href="{{ route('books.create')}}" class="btn btn-primary float-end" style="margin-bottom: 30px;">Tambah Buku</a>
        @endif
        <table class="table table-bordered border-black border-3" id="datatable">
            <thead class="table-primary border-black">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Tanggal Terbit</th>
                    @if(Auth::user()->level == 'admin')
                    <th>Hapus</th>
                    <th>Edit</th>
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach ($books_data as $index => $books)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$books->judul}}</td>
                        <td>{{$books->penulis}}</td>
                        <td>{{"Rp. ".number_format($books->harga, 2, '.', '.')}}</td>
                        <td>{{\Carbon\Carbon::parse($books->tgl_terbit)->format('d-m-Y')}}</td>
                        @if(Auth::user()->level == 'admin')
                        <td class="text-center">
                            <form action="{{ route('books.destroy', $books->id)}}" method="POST">

                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin mau di hapus?')" type="submit" class="btn btn-danger">
                                    Hapus
                                </button>

                            </form>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('books.edit', $books->id)}}" class="btn btn-primary float-end">Edit Buku</a>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

    <script>
        $(document).ready( function () {
            $('#datatable').DataTable();
        });
    </script>

</body>
</html>
