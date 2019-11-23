<div class="card pub_image">
    <div class="card-header">

        <div class="container-avatar">
            <img src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" class="avatar-img" />
        </div>      

        <div class="data-user">
            <a href="{{ route('profile', ['id' => $image->user->id])}}">
                {{ $image->user->name.' '.$image->user->surname }}
            </a>
        </div>

        @if(Auth::user()->id == $image->user->id)
        <a data-toggle="modal" data-target="#myModal">
            <img src="{{ asset('assets/delete.png') }}" class="delete-image"/>
        </a>

        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">¿Estas seguro?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        Si borras esta imagen no la podras recuperar, ¿Seguro de que lo queres hacer?
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                        <a href="{{ route('image.delete', ['image_id' => $image->id]) }}" class="btn btn-danger">Eliminar Imagen</a>


                    </div>

                </div>
            </div>
        </div>
        @endif
    </div>


    <div class="card-body">
        <div class="image-container">
            <img src="{{ route('image.file', [ 'filename' => $image->image_path]) }}" id="img-wall"/>   
        </div>
        <div class="img-functions">

            <?php $user_like = false; ?>
            @foreach($image->likes as $like)
            @if($like->user->id == Auth::user()->id)
            <?php $user_like = true; ?>
            @endif
            @endforeach

            @if($user_like)
            <img src="{{ asset('assets/like.png') }}" data-id="{{ $image->id }}" class="like btn-dislike"/>
            @else     
            <img src="{{ asset('assets/dislike.png') }}" data-id="{{ $image->id }}" class="like btn-like"/>
            @endif  

            <a href="{{ route('image.detail', ['id' =>$image->id]) }}" class="comments">
                <img src="{{ asset('assets/comentario.png') }}" />
            </a>    

            <span class="format-time">
                {{ \FormatTime::LongTimeFilter($image->created_at) }}
            </span>
            <div class="count-likes">
                @if(count($image->likes) != 1)
                {{ count($image->likes) }}likes
                @else
                {{ count($image->likes) }}like
                @endif
            </div>
        </div>
        <div class="description">
            @if($image->description)
            <span class="nick_and_description"><strong>{{ '@'.$image->user->nick.': ' }}</strong> {{ $image->description }}</span>        
            @endif
        </div>

        <div class="all-comments">
            <a href="{{ route('image.detail', ['id' =>$image->id]) }}">Acceder a los comentarios -> ({{ count($image->comments) }} comentarios)</a>
        </div>
    </div>
</div>