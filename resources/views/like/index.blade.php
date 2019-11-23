@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(count($likes)>=1)
            <div class="images-favs">
                <h2>Imagenes Favoritas</h2>
            </div>
            @foreach($likes as $like)
            
                @include('includes.image', (['image' => $like->image]))
          
            @endforeach
            @else
            <div class="images-favs">
                <h2>No tienes imagenes favoritas</h2>
            </div>
            @endif
            <!--PAGINACION-->
            <div class="clearfix"></div>

            <div class="pagination">
                <p>{{ $likes->links() }}</p>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
