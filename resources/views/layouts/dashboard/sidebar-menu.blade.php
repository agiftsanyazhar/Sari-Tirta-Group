<div class="sidebar-menu">
    <ul class="menu">

        <!-- Sidebar Item: Bio -->
        <li class="sidebar-item">
            <a href="{{ route('dashboard.appointment.index', ['creator' => 'true']) }}" class="sidebar-link">
                <i class="bi bi-info-circle-fill"></i>
                <span>My Appointments</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('dashboard.appointment.index', ['receiver' => 'true']) }}" class="sidebar-link">
                <i class="bi bi-info-circle-fill"></i>
                <span>My Invitations</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('dashboard.appointment.upcoming') }}" class="sidebar-link">
                <i class="bi bi-info-circle-fill"></i>
                <span>Upcoming Appointments</span>
            </a>
        </li>

    </ul>
</div>
