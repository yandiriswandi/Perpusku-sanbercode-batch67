<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-user" aria-expanded="false" aria-controls="ui-user">
                    <i class="typcn typcn-user-add-outline menu-icon"></i>
                    <span class="menu-title">Users</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-user">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('user.index')}}">user</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('user.create')}}">Create User</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-category" aria-expanded="false"
                aria-controls="ui-category">
                <i class="typcn typcn-film menu-icon"></i>
                <span class="menu-title">Categories</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-category">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('category.index')}}">Category</a></li>
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item"> <a class="nav-link" href="{{route('category.create')}}">Create Category</a>
                    @endif
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-shelf" aria-expanded="false" aria-controls="ui-shelf">
                <i class="typcn typcn-th-small-outline menu-icon"></i>
                <span class="menu-title">Shelfs</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-shelf">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('shelf.index')}}">Shelf</a></li>
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item"> <a class="nav-link" href="{{route('shelf.create')}}">Create Shelf</a>
                    @endif
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-book" aria-expanded="false" aria-controls="ui-book">
                <i class="typcn typcn-document-text menu-icon"></i>
                <span class="menu-title">Books</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-book">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('book.index')}}">Book</a></li>
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item"> <a class="nav-link" href="{{route('book.create')}}">Create Book</a>
                    @endif
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-loan" aria-expanded="false" aria-controls="ui-loan">
                <i class="typcn typcn-mortar-board menu-icon"></i>
                <span class="menu-title">Loans</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-loan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('loan.index')}}">Loan</a></li>
                    @if (Auth::user()->role == 'admin')
                        <li class="nav-item"> <a class="nav-link" href="{{route('loan.create')}}">Create Loan</a>
                    @endif
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>