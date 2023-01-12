<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="index.html"
                        aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                            class="hide-menu">Dashboard</span></a></li>
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Applications</span></li>

                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('user.index') }}"
                    aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <span class="hide-menu">User</span></a></li>

                <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('category.index') }}"
                    aria-expanded="false">
                    <i class="fas fa-list"></i>
                    <span class="hide-menu">Category</span></a></li>

                <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('ticket.index') }}"
                        aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                            class="hide-menu">Ticket List
                        </span></a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>