@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>
            {!! session()->get('success') !!}
        </strong>
    </div>
@endif
@if(isset($errors)&&count($errors) > 0)
    <div class="alert alert-dismissible alert-danger fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        @if(count($errors) == 1)
            <strong>{!! $errors->first() !!}</strong>
        @else
            @foreach ($errors->all() as $error)
                <li><strong>{!! $error !!}</strong></li>
            @endforeach
        @endif

    </div>
@endif
