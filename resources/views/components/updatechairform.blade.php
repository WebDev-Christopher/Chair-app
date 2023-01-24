<form class="d-flex flex-column w-50 m-auto mt-5" action="{{ route("updateChair") }}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$item->id}}">
    <input type="hidden" name="user_id" value="{{$item->user_id}}">
    <input type="hidden" name="image" value="{{$item->image}}">
    <input type="text" name="name" id="" value="{{$item->name}}" class="mb-3 py-2 px-2">
    <input type="number" name="amount" id="" value="{{$item->amount}}" min="1" step="any" class="mb-3 py-2 px-2">
    <input type="text" name="body" id="" value="{{$item->body}}" class="mb-3 py-2 px-2">
    <input type="file" name="new_image" class="mb-3">
    <input type="submit" value="Update" class="py-2 px-2">
</form>