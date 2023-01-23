<form action="{{ route('createUser') }}" method="post" class="d-flex flex-column w-50 m-auto mt-5">
    @csrf

    <input type="email" name="email" placeholder="Email" class="rounded py-2 px-2"><br>

    <input type="text" name="username" placeholder="Username" class="rounded py-2 px-2"><br>

    <input type="password" name="password" placeholder="Password" class="rounded py-2 px-2"><br>

    <input type="submit" value="Register" class="rounded py-2"><br>
</form>