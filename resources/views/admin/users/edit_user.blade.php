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
        <form method="POST" action="/admin/users/{{$user->id}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-12">
                <div class="row">
                <div class="card-body col-md-3"></div>
                    <div class="card-body col-md-6">
                        <div class="form-group">
                            <label for="name">User name</label>
                            <input type="text"class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required pattern="[+88]{3}[0-9]{5}-[0-9]{6}" placeholder="+880xxxx-xxxxxx" autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div> 
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="" >--Select--</option>
                                <option value="pending" {{ $user->status=='pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $user->status=='approved' ? 'selected' : '' }} >Approved To Exam</option>
                                <option value="qualified" {{ $user->status=='qualified' ? 'selected' : '' }} >Qualified To Test</option>
                                <option value="rejected" {{ $user->status=='rejected' ? 'selected' : '' }} >Rejected To Test</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cv_link">CV</label>
                            <input id="cv_link" type="file" class="form-control" name="cv_link">
                            @error('cv_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-body col-md-3"></div>
                </div>
            </div>
            
          <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" class="btn btn-primary float-right" >Update</button>
          </div>
        </form>
      </div>
     
</x-layout>