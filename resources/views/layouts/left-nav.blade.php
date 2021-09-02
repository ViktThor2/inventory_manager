<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-text mx-3"><img src="{{ asset('img/perinvest_logo2.svg') }}" width="100%"></div>
    </a>

    <!-- Felhasználók -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Adminisztráció
    </div>

    <!-- Nav Item - Cégek -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompany"
           aria-expanded="true" aria-controls="collapseCompany">
            <i class="far fa-building"></i>
            <span>Cégek</span>
        </a>
        <div id="collapseCompany" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('company.index') }}">Saját cégek</a>
                <a class="collapse-item" href="{{ route('partner.index') }}">Partnerek</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Felhasználók -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
           aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-fw fa-user"></i>
            <span>Felhasználók</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('user.index') }}">Felhasználók</a>
                <a class="collapse-item" href="{{ route('role.index') }}">Szerepek</a>
                <a class="collapse-item" href="{{ route('permission.index') }}">Jogosultságok</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Számlák
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('invoicing') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Számlák jóváhagyása</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('revenue') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Bevételezés</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('textura.index') }}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Textúra számlák</span></a>
    </li>

    <!-- Nav Item - Számlák -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoice"
           aria-expanded="true" aria-controls="collapseInvoice">
                <i class="fas fa-fw fa-folder"></i>
            <span>Összes számla</span>
        </a>
        <div id="collapseInvoice" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('invoice.index') }}">Bejövő</a>
                <a class="collapse-item" href="{{ route('invoiceout.index') }}">Kimenő</a>
            </div>
        </div>
    </li>


</ul>
<!-- End of Sidebar -->
