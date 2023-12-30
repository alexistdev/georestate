<div>
    <ul class="navbar-nav" id="navbar-nav">
        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
        <li class="nav-item">
            <a class="nav-link menu-link" href="{{route('agn.dashboard')}}"  role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                <i class="bx bxs-dashboard"></i> <span data-key="t-dashboards">Dashboards</span>
            </a>
        </li> <!-- end Dashboard Menu -->
        <li class="nav-item">
            <a class="nav-link menu-link  @if($menuUtama == "dataku") active @endif collapse" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                <i class="bx bx-layer"></i> <span data-key="t-apps">Dataku</span>
            </a>
            <div class="menu-dropdown navbar-expand @if($menuKedua != "listing") collapse @endif" id="sidebarApps">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                        <a href="{{route('agn.lists')}}" class="nav-link @if($menuKedua == "listing") active @endif" data-key="t-calendar"> Listing </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Promosi</span></li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                <i class="bx bx-user-circle"></i> <span data-key="t-authentication">Properties</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarAuth">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                        <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSignIn" data-key="t-signin"> Listing
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarSignIn">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-key="t-basic"> Basic </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-key="t-cover"> Cover </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</div>
