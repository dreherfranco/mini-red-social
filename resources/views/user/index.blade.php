@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.index') }}" method="GET" id="buscador">
                        <div class="row">
                        <div class="form-group col">
                            <input type="text" id="search" class="form-control"/>
                        </div>
                            <div class="form-group col">
                                <input type="submit" value="Buscar" class="form-control btn btn-primary btn-search"/>
                            </div>
                        </div>
                    </form>
                    <hr>
                        @foreach($users as $user)
                        <img src="{{ route('user.avatar', ['filename'=>$user->image]) }}" class="profile-avatar" />
                        <div class="data-user-profile">
                            <a href="{{ route('profile', ['id' => $user->id])}}" class="user-name">
                                {{ $user->name.' '.$user->surname }}
                            </a>
                            <p class="user-name">
                                {{ '@'.$user->nick }}
                            </p>
                            <p>Se unio {{ strtolower(\FormatTime::LongTimeFilter($user->created_at)) }}</p>
                        </div>
                     
                    <div class="clearfix"></div>
                    <hr>
                    @endforeach
                    <span>{{ $users->links() }}</span>
                </div>      


            </div>
        </div>
    </div>
</div>
@endsection


