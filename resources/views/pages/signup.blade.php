  @extends('landing')

@section('content')

  <strong class="Title">{{ $app_name }}</strong> is still in Beta mode. <br/>
  Use the form below to apply for a creator account.<br/>

  <form action="/form/apply" method="post" class="py-2 ">
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" class="form-control" placeholder="Email"/>
    </div>
    <div class="form-group pt-1">
      <label>Comments</label>
      <textarea class="form-control" placeholder="Where are you from? What are you using it for?" name="comments" rows=5></textarea>
    </div>
    <div class="form-group py-2">
        <input type="submit" class="btn btn-primary" value=" APPLY " />
    </div>
  </form>
@endsection
