<div id="chaircontainer" class="d-flex flex-wrap justify-content-center align-items-stretch mt-3 ms-3">

    {{-- @for ($i = 0; $i < 10; $i++) --}}
        @foreach ($items as $item)
            @include('components.chairitem')
        @endforeach
    {{-- @endfor --}}

</div>