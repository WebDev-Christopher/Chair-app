<div id="chaircontainer" class="d-flex flex-wrap justify-content-start align-items-stretch mt-2 ms-4">

    @foreach ($items as $item)
        @include('components.chairitem')
    @endforeach

</div>