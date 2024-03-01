<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 10 Custom Login and Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<style>
#outer
{
    width:auto;
    text-align:center;
}
.inner
{
    display:inline-block;
}
</style>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
          <!-- <a class="navbar-brand" href="#">Navbar</a> -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('todos.create') }}">Todos App</a>
              </li>
            </ul>
            <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Logout</button>
            </form>
          </div>
        </div>
    </nav>
    <br>
 
    <div class="container">

    @if(Session::has('alert-success'))
    <div class="alert alert-success" role="alert">
    {{ Session::get('alert-success') }}
    </div>
    @endif

    @if(Session::has('alert-info'))
    <div class="alert alert-info" role="alert">
    {{ Session::get('alert-info') }}
    </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
        </div>
    @endif

    <a class="btn btn-sm btn-info" href="{{ route('todos.create') }}">Create Todo</a>

    @if (count($todos) > 0)
    <table class="table">
  <thead>
    <tr>
      <th>@sortablelink('title')</th>
      <th>@sortablelink('description')</th>
      <th>Image</th>
      <th>@sortablelink('is_completed')</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($todos as $todo)
    <tr>
      <td>{{ $todo->title }}</td>
      <td>{{ $todo->description }}</td>
      <td>
        <img src="{{ asset($todo->image) }}" style="width: 70px; height: 70px;" alt="Img" />
      </td>
      <td>
        @if ($todo->is_completed == 1)
            <a class="btn btn-success" href="">completed</a>
        @else
        <a class="btn btn-sm btn-danger" href="">in progress</a>
      @endif
    </td>
      <td id="outer">
        <a class="inner btn btn-sm btn-success" href="{{ route('todos.show', $todo->id) }}">View</a>
        <a class="inner btn btn-sm btn-info" href="{{ route('todos.edit', $todo->id) }}">Edit</a>
        <form method="post" action="{{ route('todos.destroy',$todo->id) }}" class="inner">
            @csrf
            @method('DELETE')
            <input type="hidden" name="todo_id" value="{{ $todo->id }}">
            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
        </form>
    </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $todos->links() }}
@else
<h4>No todos are created yet</h4>
@endif
    </div>
</body>
</html>