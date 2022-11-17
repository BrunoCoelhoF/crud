@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Usuário</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if( Request::is('*edit/*'))
                    <form action="{{ url('users/update') }}/{{$user->id}}" method="post">
                    @csrf
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="inputName" name="inputName" aria-describedby="nameHelp" value="{{$user->name}}">
                            <div id="nameHelp" class="form-text">Digite o nome do usuário</div>
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="emailHelp" value="{{$user->email}}" >
                            <div id="emailHelp" class="form-text">Digite o email</div>
                        </div>
                        <div class="mb-3">
                            <label for="inputCpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="inputCpf" name="inputCpf" aria-describedby="cpfHelp" value="{{$user->cpf}}" >
                            <div id="cpfHelp" class="form-text">Digite o CPF</div>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="inputPassword" name="inputPassword" value="{{$user->password}}">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="inputAddress" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="inputAddress" name="inputAddress" aria-describedby="addressHelp" value="{{$user->address}}">
                            <div id="addressHelp" class="form-text">Digite o endereço completo</div>
                        </div> -->
                        <div class="mb-3">
                            <label for="idProfile" class="form-label">Perfil</label>
                            <select class="form-select" id="idProfile" name="idProfile">
                            @foreach($profiles as $p)
                                <option  
                                @if($p->id == $user->id_profiles) selected @endif 
                                value="{{$p->id}}">{{$p->description}}</option>
                            @endforeach
                            </select>
                            <div id="profileHelp" class="form-text">Escolha um perfil</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                        </form>
                    @else
                    <form action="{{ url('users/add')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="inputName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="inputName" name="inputName" aria-describedby="nameHelp" value="asdas">
                            <div id="nameHelp" class="form-text">Digite o nome do usuário</div>
                        </div>
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="emailHelp" >
                            <div id="emailHelp" class="form-text">Digite o email</div>
                        </div>
                        <div class="mb-3">
                            <label for="inputCpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="inputCpf" name="inputCpf" aria-describedby="cpfHelp" >
                            <div id="cpfHelp" class="form-text">Digite o CPF</div>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="inputPassword" name="inputPassword" >
                        </div>
                        <!-- <div class="mb-3">
                            <label for="inputAddress" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="inputAddress" name="inputAddress" aria-describedby="addressHelp" >
                            <div id="addressHelp" class="form-text">Digite o endereço completo</div>
                        </div> -->
                        <div class="mb-3">
                            <label for="idProfile" class="form-label">Perfil</label>
                            <select class="form-select" id="idProfile" name="idProfile">
                                @foreach($profiles as $p)
                                    <option value="{{$p->id}}">{{$p->description}}</option>
                                @endforeach
                            </select>
                            <div id="profileHelp" class="form-text">Escolha um perfil</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @if(!empty($user->id) )
        <div class="col-md-6">
        <div class="card">
            <div class="card-header">Endereços</div>
            <div class="card-body">
            <form action="{{ url('users/addr') }}/{{$user->id}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="inputCep" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="inputCep" name="inputCep">
                    
                </div>
                <div class="mb-3">
                    <label for="inputLogradouro" class="form-label">Logradouro</label>
                    <input type="text" class="form-control" id="inputLogradouro" name="inputLogradouro" >
                </div>
                <button type="submit" class="btn btn-primary">Adicionar</button>
            </form>
            <br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Logradouro</th>
                    <th scope="col">CEP</th>
                    <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($address as $ad)
                    <tr>
                        <th scope="row">{{$ad->id}}</th>
                        <th scope="row">{{$ad->description}}</th>
                        <th scope="row">{{$ad->cep}}</th>
                        <th>
                            <!-- <form id="formaddr" name="formaddr" action="users/deladdr/{{$ad->id}}/{{$user->id}}" method="post"> -->
                            <form action="/users/deladdr/{{$ad->id}}/{{$user->id}}" method="post">
                                    @csrf
                                    @method('delete')
                            <button class="btn btn-danger">Deletar</button>
                            </form>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        </div>
        @endif
    </div>
</div>
@endsection 

<!-- <script type="text/javascript">  
function submitFormAdd(){
    $("#formaddr").submit();
}
</script> -->