<x-layout>
    @section('title', $title)
    <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">{{$title}}</h3>
        </div>
        <!-- /.card-header -->
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
        <!-- form start -->
        <form action="/admin/quizzes" method="post">
            @csrf
            @method('POST')
            <div class="col-md-12">
                <div class="form-group">
                    <label for="question">Question</label>
                    <input type="text" name="question" class="form-control" required id="question" placeholder="Enter Question">
                </div>
                <div class="row">
                    <div class="card-body col-md-6">
                        
                        <div class="form-group">
                            <label for="option">Option 1</label>
                            <input type="text" name="option_1" class="form-control" required id="option_1" placeholder="Enter Option 1">
                        </div>
                        
                       
                        <div class="form-group">
                            <label for="option">Option 2</label>
                            <input type="text" name="option_2" class="form-control" required id="option_2" placeholder="Enter Option 2">
                        </div>
                        <div class="form-group">
                            <label for="options_type">Options Type</label>
                            <select name="options_type" id="options_type" class="form-control">
                                <option value="radio">Radio</option>
                                <option value="checkbox">Checkbox</option>
                            </select>
                        </div>                       
                        <div class="form-group">
                            <label for="mark">Mark</label>
                            <input type="number" name="mark" class="form-control"  required id="mark" placeholder="Enter Mark">
                        </div>
                    </div>
                    <div class="card-body col-md-6">
                        <div class="form-group">
                            <label for="option">Option 3</label>
                            <input type="text" name="option_3" class="form-control" required id="option_3" placeholder="Enter Option 3">
                        </div>
                        <div class="form-group">
                            <label for="option">Option 4</label>
                            <input type="text" name="option_4" class="form-control" required id="option_4" placeholder="Enter Option 4">
                        </div>
                        <div class="form-group">
                            <label for="correct_option">Correct Option</label>
                            <input type="text" name="correct_option" class="form-control"  required id="correct_option" placeholder="If Q.type radio enter single value Ex:1, else enter multiple value. Ex: 1,2">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="form-check">                                
                                <input type="radio" class="form-radio-input" value="1" checked id="active" name="status" >
                                <label class="form-radio-label" for="active">Active</label>
                                <input type="radio" class="form-radio-input" value="0" id="inactive" name="status" >
                                <label class="form-radio-label" for="inactive">Inactive</label>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
          <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" class="btn btn-primary float-right">Submit</button>
          </div>
        </form>
      </div>
     
</x-layout>