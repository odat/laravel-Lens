<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Broken Access Control
    </div>
    <div class="card-body">
        <table id="" class="table table-bordered">
            <thead>
            <tr>
                <th>HTTP Method</th>
                <th>Route</th>
                <th>Name</th>
{{--                <th>Corresponding Action</th>--}}
                <th>Role</th>
            </tr>
            </thead>
            <tbody>
            @foreach($routes as $route)
                <tr>
                    <td>{{$route['methods']}}</td>
                    <td>{{ $route['uri'] }}</td>
                    <td>{{ $route['name'] }}</td>
{{--                    <td>{{ $route->getActionName() }}</td>--}}
                    <td>
                        <ul>
                            @if(empty($route['middlewares']))
                                <li>Public</li>
                            @else
                                @foreach( $route['middlewares'] as $middleware)
                                    <li>{{$middleware}}</li>
                                @endforeach
                            @endif


                        </ul>
                    </td>
                </tr>

            @endforeach


            </tbody>
        </table>
    </div>
</div>
