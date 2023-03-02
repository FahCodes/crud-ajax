<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Ajax Image Upload Example - ItSolutionStuff.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>


</head>
    
<body>
<div class="container">
        
    <div class="panel panel-primary">
    
    <div class="panel-heading">
        <h2>Laravel 9 Ajax Image Upload </h2>
    </div>

    <div class="panel-body">
        <div class="pb-3">
            <a href='' class="btn btn-primary tombol-tambah">+ Tambah Data</a>
        </div>
        <table class="table" id="myTable">
            
            <thead>
                <tr>
                    <th>Nis</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($siswa as $item)
                <tr>
                    <td>{{ $item->nis }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        <img src="{{ asset('images/'.$item->image) }}" width="100px">
                    </td>
                </tr>
                @endforeach
            </tbody> --}}
        </table>
        
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Form Crud</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger d-none"></div>
            <div class="alert alert-success d-none"></div>
            <img id="preview-image" width="300px">
            <form action="{{ route('image.store') }}" method="POST" id="image-upload" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="form-label" for="nis">Nis:</label>
                    <input 
                        type="text" 
                        name="nis" 
                        id="nis"
                        class="form-control">
                </div>
                <div>
                    <label class="form-label" for="Nama">Nama:</label>
                    <input 
                        type="text" 
                        name="nama" 
                        id="nama"
                        class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="inputImage">Image:</label>
                    <input 
                        type="file" 
                        name="image" 
                        id="inputImage"
                        class="form-control">
                    <span class="text-danger" id="image-input-error"></span>
                </div>
                {{-- <div class="mb-3">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary tombol-simpan">Simpan</button>
                </div>
            </form>
        </div>
        
        </div>
    </div>
    </div>
        
    </div>
    </div>
</div>
</body>

<script type="text/javascript">
    // $(document).ready( function () {
    //     $('#myTable').DataTable();
    // });


    $(document).ready( function () {
        $('#myTable').DataTable({
            prosessing:true,
            serverside:true,
            ajax: "{{ route('siswa.index') }}",
            columns:[{
            // Column yang ada pada database
            data: 'nis',
            // Column text yang akan ditampilkan
            name: 'Nis'
            },{
                // Column yang ada pada database
                data: 'nama',
                // Column text yang akan ditampilkan
                name: 'Nama'
            },{
                // Column yang ada pada database
                data: 'image',
                // Column text yang akan ditampilkan
                name: 'Image',
            },{
                data: 'aksi',
                name: 'Aksi'
            }]
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').on('click', '.tombol-tambah', function(e){
        e.preventDefault();
        $('#exampleModal').modal('show');
        $('#inputImage').change(function(){    
            let reader = new FileReader();
            reader.onload = (e) => { 
                $('#preview-image').attr('src', e.target.result); 
            }   
            reader.readAsDataURL(this.files[0]); 
        });

        // $('.tombol-simpan').submit(function(){
            $('#image-upload').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $('#image-input-error').text('');

                $.ajax({
                    type:'POST',
                    url: "{{ route('image.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if (response) {
                            this.reset();
                            // alert('Image has been uploaded successfully');
                            $('.alert-danger').addClass('d-none');
                            $('.alert-success').removeClass('d-none');
                            $('.alert-success').html('Data Berhasil DiTambahkan');
                        }
                        $('#myTable').DataTable().ajax.reload();
                    },
                    error: function(responseE){
                        $('.alert-success').addClass('d-none');
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').html("<ul>");
                        $.each(responseE.responseJSON.errors, function(key, value){
                            $('.alert-danger').find('ul').append("<li>" + value + "</li>");
                        });
                        $('.alert-danger').append("</ul>");
                        // console.log((response.responseJSON.errors));
                        // $('#image-input-error').text(responseE.responseJSON.message);
                    }
                });
            });
        // });
    });
    $('#exampleModal').on('hidden.bs.modal', function(){
        $('#nis').val('');
        $('#nama').val('');
        $('#photo').val('');

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
    
</script>
    
</html>