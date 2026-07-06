@if(session('success'))
<div class="alert alert-success">{{session('success')}} </div>
@endif


@if(count($errors))
<div class="alert alert-danger">
<strong>Validation error: Please fix the following issue</strong>
<ul>
    @foreach($errors->all() as $error)
    <li> {{$error}} </li>
    @endforeach
</ul>
</div>   
@endif