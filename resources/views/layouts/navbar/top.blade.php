<style>
    a {
        text-decoration: none;
        color: inherit;
    }

    a:hover,
    a:active,
    a:focus {
        color: white;
    }

    .active {
        color: white;
        background-color: #0d6efd;
        /* Bootstrap primary color */
    }
</style>
<nav class="navbar bg-body-tertiary" id="navigation-bar">
    <div class="container-fluid ">
        <a class="navbar-brand" href="#">
            <h3>{{ isset(Auth::user()->Usertype) && Auth::user()->Usertype == 'G' ? 'Welcome '.Auth::user()->Username.'!':  'ADMIN' }} </h3>
        </a>
        <ul class="nav nav-pills  justify-content-end pe-5" id="pills-tab" role="tablist">
            @if( isset(Auth::user()->Usertype) && in_array( Auth::user()->Usertype,['S','G']))

            @else
                <li class="nav-item" role="presentation">
                    <a href="{{ url('admin/crew') }}">
                        <button class="nav-link" :class="{ active: isActive('/admin/crew') }" id="pills-profile-tab"
                            type="button" aria-selected="false">Crew
                            List</button></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ url('admin/configurations') }}">
                        <button class="nav-link" :class="{ active: isActive('/admin/configurations') }"
                            id="pills-profile-tab" type="button" aria-selected="false">Configurations</button></a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="{{ url('admin/accounts') }}">
                        <button class="nav-link" :class="{ active: isActive('/admin/accounts') }" id="pills-contact-tab"
                            data-bs-target="#pills-contact" type="button" aria-controls="pills-contact"
                            aria-selected="false">User
                            Accounts</button>
                    </a>
                </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                    aria-expanded="false">{{ Auth::user()->Username ?? "" }}</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" @click.prevent="logout">Logout</a></li>
                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>

    </div>
</nav>
