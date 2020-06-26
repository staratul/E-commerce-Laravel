@if($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <li>{{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </li>
        </div>
    @endforeach
@endif

@if (session('success'))
    <div class="alert alert-success">
        <span>
            <strong>{{ session('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">x</span>
            </button>
        </span>
    </div>
@endif
