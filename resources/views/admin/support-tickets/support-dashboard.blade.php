        <!-- Total Counts Clients, IB Clients, MT5 Groups, Transactions -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @foreach ($ticketStatus as $status)
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <!-- small box -->
                            <a href="{{ route('admin.support-tickets.index') }}?status={{ $status->id }}">
                                <div class="small-box card card-outline">
                                    <div class="inner">
                                        <h3 class="text-theme">{{ getTotalSupportTicketByStatus($status->id) }}</h3>
                                        <p>{{ $status->name }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- ./col -->
                    @endforeach
                </div>
            </div>
        </section>
        <!-- /.content -->
