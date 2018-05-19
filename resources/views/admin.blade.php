@extends('layouts.adminlte')

@section('content')
<div class="row">
<div class='col-md-8 col-md-offset-2'>
    <table id="table" class="table table-hover table-striped table-bordered text-center">
        <thead>
            <th>Name</th>
            <th>Matricula</th>
            <th>E-mail</th>
            <th>Admin</th>
            <th>Professor</th>
            <th>Aluno</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <form action="{{ route('admin.assign') }}" method="post">
                        <td>{{$user->name}}</td>
                        <td>{{$user->matricula}}</td>
                        <td>{{$user->email}} <input type="hidden" name="email" value="{{$user->email}}"></td>
                        <td><input type="checkbox" {{$user->hasRole('Admin') ? 'checked' : ''}} name="role_admin"></td>
                        <td><input type="checkbox" {{$user->hasRole('Professor') ? 'checked' : ''}} name="role_professor"></td>
                        <td><input type="checkbox" {{$user->hasRole('Aluno') ? 'checked' : ''}} name="role_aluno"></td>
                        {{csrf_field()}}
                        <td><button type="submit">Assign Roles</button></td>
                    </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div><!-- end col-md-8 col-md-offset-2 -->
</div>
@endsection
