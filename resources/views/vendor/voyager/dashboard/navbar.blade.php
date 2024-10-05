<nav class="navbar navbar-default navbar-fixed-top navbar-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button class="hamburger btn-link">
                <span class="hamburger-inner"></span>
            </button>
            @section('breadcrumbs')
            <ol class="breadcrumb hidden-xs">
                @php
                $segments = array_filter(explode('/', str_replace(route('voyager.dashboard'), '', Request::url())));
                $url = route('voyager.dashboard');
                @endphp
                @if(count($segments) == 0)
                    <li class="active"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</li>
                @else
                    <li class="active">
                        <a href="{{ route('voyager.dashboard')}}"><i class="voyager-boat"></i> {{ __('voyager::generic.dashboard') }}</a>
                    </li>
                    @foreach ($segments as $segment)
                        @php
                        $url .= '/'.$segment;
                        @endphp
                        @if ($loop->last)
                            <li>{{ ucfirst(urldecode($segment)) }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}">{{ ucfirst(urldecode($segment)) }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ol>
            @show
        </div>
        <ul class="nav navbar-nav @if (__('voyager::generic.is_rtl') == 'true') navbar-left @else navbar-right @endif">
            <li class="dropdown profile">
                <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" role="button"
                   aria-expanded="false"><img src="{{ $user_avatar }}" class="profile-img"> <span
                            class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menu-animated">
                    <li class="profile-img">
                        <img src="{{ $user_avatar }}" class="profile-img">
                        <div class="profile-body">
                            <h5>{{ Auth::user()->name }}</h5>
                            <h6>{{ Auth::user()->email }}</h6>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <?php $nav_items = config('voyager.dashboard.navbar_items'); ?>
                    @if(is_array($nav_items) && !empty($nav_items))
                    @foreach($nav_items as $name => $item)
                    <li {!! isset($item['classes']) && !empty($item['classes']) ? 'class="'.$item['classes'].'"' : '' !!}>
                        @if(isset($item['route']) && $item['route'] == 'voyager.logout')
                        <form action="{{ route('voyager.logout') }}" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-block">
                                @if(isset($item['icon_class']) && !empty($item['icon_class']))
                                <i class="{!! $item['icon_class'] !!}"></i>
                                @endif
                                {{__($name)}}
                            </button>
                        </form>
                        @else
                        <a href="{{ isset($item['route']) && Route::has($item['route']) ? route($item['route']) : (isset($item['route']) ? $item['route'] : '#') }}" {!! isset($item['target_blank']) && $item['target_blank'] ? 'target="_blank"' : '' !!}>
                            @if(isset($item['icon_class']) && !empty($item['icon_class']))
                            <i class="{!! $item['icon_class'] !!}"></i>
                            @endif
                            {{__($name)}}
                        </a>
                        @endif
                    </li>
                    @endforeach
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!--<script>-->
<!--document.addEventListener('DOMContentLoaded', function() {-->
<!--    const notificationSound = new Audio('https://backend.fabtransport.com.au/notifications-sound-127856.mp3');-->
<!--    let isSoundInitialized = false;-->

    {{-- // Initialize sound on first user interaction --}}
<!--    document.addEventListener('click', function initializeSound() {-->
<!--        if (!isSoundInitialized) {-->
<!--            notificationSound.play().then(() => {-->
<!--                notificationSound.pause();-->
<!--                isSoundInitialized = true;-->
<!--            }).catch(err => console.error(err));-->
<!--            document.removeEventListener('click', initializeSound);-->
<!--        }-->
<!--    }, { once: true });-->

<!--    function checkForNotifications() {-->
<!--        fetch('/new-submissions')-->
<!--            .then(response => {-->
<!--                if (!response.ok) {-->
<!--                    throw new Error('Network response was not ok');-->
<!--                }-->
<!--                return response.json();-->
<!--            })-->
<!--            .then(data => {-->
<!--                console.log('aaaa',data)-->
                    {{-- // Show toast notification --}}
<!--                    showToastNotification(data + ' Notification');-->
                    {{-- // Play sound --}}
<!--                    if (isSoundInitialized) {-->
<!--                        notificationSound.play().catch(err => console.error('Error playing sound:', err));-->
<!--                    }-->
<!--            })-->
<!--            .catch(error => {-->
<!--                console.error('Fetch error:', error);-->
<!--            });-->
<!--    }-->

<!--    function showToastNotification(message) {-->
        {{-- // Create a toast notification element (modify as needed for styling) --}}
<!--        let toast = document.createElement('div');-->
<!--        toast.textContent = message;-->
<!--        toast.style.position = 'fixed';-->
<!--        toast.style.top = '10px';-->
<!--        toast.style.right = '10px';-->
<!--        toast.style.backgroundColor = 'black';-->
<!--        toast.style.color = 'white';-->
<!--        toast.style.padding = '10px';-->
<!--        toast.style.borderRadius = '5px';-->
<!--        toast.style.zIndex = '1000';-->
<!--        document.body.appendChild(toast);-->

        {{-- // Remove the toast after a few seconds --}}
<!--        setTimeout(() => {-->
<!--            document.body.removeChild(toast);-->
<!--        }, 5000);-->
<!--    }-->

    {{-- setInterval(checkForNotifications, 6000); // Poll every 10 seconds --}}
<!--});-->
<!--</script>-->


