<x-layout>
    @section('title', $title)
     <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('css_js/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css_js/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css_js/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

    {{-- Success or Fail Message --}}
    @if(session()->has('success'))                
        <script>
            $(function() {
                var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
                });
                var msg = {{ Js::from(session()->get('success')) }};
                toastr.success(msg);
            });
        </script>
    @elseif(session()->has('error'))
        <script>
            $(function() {
                var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
                });
                var msg = {{ Js::from(session()->get('error')) }};
                toastr.error(msg);
            });
        </script>
    @endif

    {{-- End Success or Fail Message --}}
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{$title}}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Sl.</th>
              <th>Examinee Name</th>
              <th>Email</th>
              <th>phone</th>
              <th>CV</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                
                @unless ($users->isEmpty())
                @php($counter=1)
                    @foreach ($users as $user)               
                        <tr>
                            <td>{{$counter++}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td><a target="_blank" href="{{ url('/show-cv-link',$user->cv_link) }}">View PDF</a><br></td>
                            <td>{{$user->status}}</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a href="users/{{$user->id}}/edit" target="_blank" class="btn btn-primary btn-xs">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <a href="users/{{$user->id}}" target="_blank" class="btn btn-secondary btn-xs">
                                                <i class="fa fa-external-link"></i>Quiz Details
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <form action="users/{{$user->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                <p>No listings found</p>
                @endunless
                
            
            </tbody>
            <tfoot>
                <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>phone</th>
                    <th>CV</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- DataTables  & Plugins -->
    <script src="{{asset('css_js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('css_js/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('css_js/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script>
        $(function () {
          $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
          $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });
      </script>
</x-layout>