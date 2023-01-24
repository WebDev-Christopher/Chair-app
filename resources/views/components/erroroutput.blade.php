@if ($errors->any() || session()->has('message'))
    <div class="text-danger text-center mt-2">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <li>{{ session()->get('message') }}</li>
        </ul>
    </div>
@endif