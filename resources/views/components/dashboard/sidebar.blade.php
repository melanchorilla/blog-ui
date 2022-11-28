<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column mt-5">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'active' : ''}}" href="{{ route("dashboard") }}">
                <span data-feather="home"></span>
                Dashboard <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/categories') ? 'active' : ''}} " href="{{ route("categories.index") }}">
                <span data-feather="list"></span>
                Categories
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/tags') ? 'active' : ''}}" href="{{ route("tags.index") }}">
                <span data-feather="tag"></span>
                Tags
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/posts') || request()->is('admin/posts/create') || request()->is('admin/posts/*/edit') ? 'active' : ''}}" href="{{ route("posts.index") }}">
                <span data-feather="file"></span>
                Posts
                </a>
            </li>
        </ul>
    </div>
</nav>