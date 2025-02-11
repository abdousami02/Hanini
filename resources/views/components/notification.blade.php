
<div class="notification">
    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
        <i class="mdi mdi-bell-outline"></i>
        @if(isset($count_unseen) && $count_unseen > 0)
        <span class="count count-varient2">{{ $count_unseen }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-right navbar-dropdown navbar-dropdown-large-left preview-list" aria-labelledby="notificationDropdown">
        <div class="notif-header">
            <h6 class="mb-0">Notifications</h6>
            <a href="{{ route('notification.all.seen') }}" class="seen-all">{{ __("Mark All as Read") }}</a>
        </div>
        <div class="notif-content">
            @foreach($notification ?? [] as $elem)
            <a class="dropdown-item preview-item notif-item {{ $elem->is_seen == 0 ? 'unseen' : '' }}" 
                        href="{{ $elem->url }}" data-id="{{ $elem->id }}">
                <div class="preview-thumbnail">
                    <img src="{{ static_asset('images/faces/default.png') }}" alt="" class="profile-pic" />
                </div>
                <div class="preview-item-content">
                    <p class="mb-0">{{ $elem->title }}</p>
                    <span class="text-small text-muted">{{ $elem->body }}</span>
                </div>
                <i class="mdi mdi-close-octagon-outline delete-btn"></i>
            </a>
            @endforeach
            {{-- <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="../../assets/images/faces/face3.jpg" alt="" class="profile-pic" />
                </div>
                <div class="preview-item-content">
                    <p class="mb-0"> James <span class="text-small text-muted">posted a photo on your wall</span>
                    </p>
                </div>
            </a> --}}
        </div>
        <div class="dropdown-divider"></div>
        <div class="p-3">
            <a href="{{ route('notification.all') }}">{{ __("View all notification") }}</a>
        </div>
    </div>
    <audio id="nofificaiton-sound" src="{{ static_asset('task_sound.wav') }}" preload="auto"></audio>
</div>


@push('script')
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-database-compat.js"></script>

{{-- <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-analytics-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-auth-compat.js"></script> --}}

<script src="{{ static_asset('js/google-notif.js') }}"></script>
<script>
// handel notification to DOM
function placeNotification(data){
    var $ = jQuery;
    var sound = document.querySelector('#nofificaiton-sound')
    if(sound){sound.play();}

    let notif_html = `<a class="dropdown-item preview-item notif-item unseen" href="${data.url}" data-id="${data.notification_id}">
            <div class="preview-thumbnail">
                <img src="${data.image}" alt="" class="profile-pic" />
            </div>
            <div class="preview-item-content">
                <p class="mb-0">${data.title}</p>
                <span class="text-small text-muted">${data.body}</span>
            </div>
            <i class="mdi mdi-close-octagon-outline delete-btn"></i>
        </a>`;
    $('.notif-content').prepend(notif_html);

    let count_html = `<span class="count count-varient1">${data.count_unseen}</span>`
    $('.count-indicator .count').remove();
    $('.count-indicator').append(count_html);
}
(function($){
    $('.notification .notif-content').on('click', '.delete-btn', function(e){deleteItem(e, this)});

    function deleteItem(e, self){
        e.preventDefault();
        e.stopPropagation();
        let parent = $(e.target).parents('.notif-item')
        let id = parent.data('id');

        $.post("{{ route('notification.destroy') }}",{id}).done(function(resp){
            if(resp.status == 'success'){
                parent.remove();  
                toastr.success(resp.message)
            }
        }).fail(function(e){
            toastr.error(e.responseJSON.message);
        })
    }
})(jQuery)
</script>
<script type="module">
    // User ID (replace with your logic)
    {{-- let user = '{!! json_encode(userInfo()) !!}';
    user = JSON.parse(user);
    const userStatusRef = db.ref(`/users/${user.id}`); --}}

    getLocation(function(position){
        if(position){
            let pos = position.coords;
            let userPosition = {latitude: pos.latitude, longitude: pos.longitude, accuracy: pos.accuracy};
            sendToDB(userPosition)
        }
    },function(error){
        console.warn(error.message);
        sendToDB('')
    });

    function sendToDB(position){
        if(position){
            userStatusRef.set({name: user.name, state: "online", lastChanged: Date.now(), location: position });

            // userStatusRef.once('value').then(function(snapshot){
            //     console.log(snapshot.val());
            // })
            
        }else{
            userStatusRef.update({ state: "online", lastChanged: Date.now()});
        }

        // Handle disconnection
        userStatusRef.onDisconnect().update({ state: "offline", lastChanged: Date.now() });
    }
    // Reference to the user's presence status
    


</script>
@endpush

