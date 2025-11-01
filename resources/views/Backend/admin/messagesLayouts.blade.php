<div class="card-header text-center">
    @if (Session::has('success'))

    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>

    @endif
    @if (session::has('errors'))

    <div class="alert alert-danger">
        {{session::get('errors')}}
    </div>

    @endif
</div>
