@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.message')
            
            @foreach($images as $image)
            
                @include('includes.image')
       
            @endforeach
            <!--PAGINACION-->
            <div class="clearfix"></div>

            <div class="pagination">
                <p>{{ $images->links() }}</p>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
