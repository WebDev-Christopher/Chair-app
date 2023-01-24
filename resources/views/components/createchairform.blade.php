<form class="d-flex flex-column w-50 m-auto mt-5" action="{{ route("createChair") }}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="hidden" name="user_id" value="{{$user->id}}" >
    <input type="text" name="name" placeholder="Title" class="mb-3 py-2 px-2">
    <input type="number" name="amount" placeholder="Price" min="1" step="any" class="mb-3 py-2 px-2">
    <input type="text" name="body" placeholder="Body" class="mb-3 py-2 px-2">
    <input type="file" name="image" class="mb-3">
    <input type="submit" name="" id="" class="py-2 px-2">
</form>