<h1>dashboard</h1>
test
<form action="{{route('merchant.auth.logout')}}" method="POST">
    @csrf
    <input type="submit" value="logout">
</form>

<a href="{{route('merchant.website.create')}}">create Website</a>
<br>
<a href="{{route('merchant.website.edit', ['id' => '1'])}}">edit Website</a>
<br>
<a href="{{route('merchant.auth.register')}}">register</a>


@foreach ($websites as $website)
    <h1>
        <a href="{{route('merchant.gotoWebisteDashboard', ['website' => $website->domain])}}"
            style="color: red;">{{$website->name}}</a>
    </h1>
@endforeach