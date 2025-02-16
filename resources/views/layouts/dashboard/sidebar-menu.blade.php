<div class="sidebar-menu">
    <ul class="menu">

        <!-- Sidebar Item: Bio -->
        <li class="sidebar-item {{ request()->is('dashboard/appointment*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.appointment.index') }}" class="sidebar-link">
                <i class="bi bi-info-circle-fill"></i>
                <span>Appointments</span>
            </a>
        </li>

    </ul>
</div>
