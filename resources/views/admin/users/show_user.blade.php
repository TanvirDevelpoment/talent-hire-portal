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
        @if($user->quizTest)
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Name</th>
              <th>Quiz Qty</th>
              <th>Performed Qty</th>
              <th>Pass Qty</th>
              <th>Time Consumed</th>
              <th>Percentage</th>
              <th>Status</th>
            </tr>
            </thead>
            <tbody>   
                <tr>
                    
                    <td>{{$user->name}}</td>
                    <td>{{$user->quizTest->total_questions}}</td>
                    <td>{{$user->quizTest->quiz_perform_qty}}</td>
                    <td>{{$user->quizTest->quiz_pass_qty}}</td>
                    <td>{{$user->quizTest->time_consumed}}</td>
                    @php($percentage_of_mark = (($user->quizTest->quiz_pass_qty/$user->quizTest->total_questions)*100))
                    <td>{{$percentage_of_mark}} %</td>
                    <td><a href="/admin/users/{{$user->id}}/edit" target="_blank" >{{ucfirst($user->status)}} </a></td>
                </tr>
            </tbody>
            
          </table>
          @else
          Examinee not Performed in Quiz Test.
          @endif
        </div>
        <!-- /.card-body -->
    </div>
    <!-- DataTables  & Plugins -->
    
</x-layout>