<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Status</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            @foreach ($ticketStatus as $status)
                <li class="nav-item">
                    <a href="{{ route('admin.support-tickets.index') }}?status={{ $status->id }}" class="nav-link">
                        <i class="fa-solid fa-ticket"></i>
                        {{ $status->name }}
                        <span class="badge bg-primary bg-theme float-right">
                            {{ getTotalSupportTicketByStatus($status->id) }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Labels</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            @foreach ($ticketPriority as $priority)
                <li class="nav-item">
                    <a href="{{ route('admin.support-tickets.index') }}?status={{ request('status') }}&priority={{ $priority->id }}" class="nav-link">
                        <i class="fa-regular fa-square-check"></i>
                        {{ $priority->name }}
                        <span class="badge bg-primary bg-theme float-right">
                            {{ getTotalSupportTicketByPriority($priority->id) }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
