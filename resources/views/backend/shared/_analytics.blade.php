<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Visitors Analytics</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body p-0 pt-4">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Most Download Files</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body p-0">
                <ul class="list-group list-group-flush small">
                    @forelse($mostDownloadFiles as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $file->name }}
                            <span class="badge badge-primary badge-pill">Download {{ $file->clicked }}</span>
                        </li>
                    @empty
                        <li class="list-group-item d-flex justify-content-between align-items-center">Oops No found data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
