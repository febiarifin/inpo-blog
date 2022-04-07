@extends('layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        @if (Auth::user()->role ===2)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Perhatian ! </strong> Akun anda dibanned oleh admin karena pelanggaran ketentuan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <h1 class="h3 mb-3">{{$pages}}</h1>

        <div class="row">
            <div class="col-xl-12 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Artikel</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="folder"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <h1 class="mt-1 mb-3">{{$postCount}}</h1>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Posting</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="upload"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <h1 class="mt-1 mb-3">{{$postPostingCount}}</h1>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Draft</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="bookmark"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <h1 class="mt-1 mb-3">{{$postDraftCount}}</h1>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Status</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="check-circle"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <h2 class="mt-1 mb-3">
                                        @if ($status === 0)
                                        <span class="badge bg-success">Active</span>
                                        @elseif($status === 1)
                                        <span class="badge bg-primary">Admin</span>
                                        @elseif($status === 2)
                                        <span class="badge bg-danger">Banned</span>
                                        @endif
                                        </h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Artikel Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @if ($message !== '')
                        <div class="text-secondary text-center fs-4 text-uppercase">
                            {{$message}}
                        </div>
                        @endif

                        @foreach ($latestPost as $post)
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset($post->image) }}" class="img-fluid rounded-start"
                                        alt="Image post">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ url('post/'.Auth::user()->name.'/'.$post->id.'/'.$post->slug) }}"
                                                class="link-secondary">
                                                {{Str::substr($post->title,0,30) }}...
                                            </a>
                                        </h5>
                                        <p class="card-text">
                                            {{ Str::substr($post->content,5,35) }}...
                                            <br>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-clock"></i> {{ $post->published_at }},
                                                <i class="fa-solid fa-eye"></i> {{ views($post)->count() }}
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
                <div class="card flex-fill w-100">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Views</h5>
                    </div>
                    <div class="card-body px-4">
                        <div id="world_map" style="height:350px;">
                            <div class="chart">
                                <canvas id="chart-views"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Kalender</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="align-self-center w-100">
                            <div class="chart">
                                <div id="datetimepicker-dashboard"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
        var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
        document.getElementById("datetimepicker-dashboard").flatpickr({
            inline: true,
            prevArrow: "<span title=\"Previous month\">&laquo;</span>",
            nextArrow: "<span title=\"Next month\">&raquo;</span>",
            defaultDate: defaultDate
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
            // Bar chart
            var today = new Date();
            new Chart(document.getElementById("chart-views"), {
                type: "bar",
                data: {
                    labels: [
                        today
                    ],
                    datasets: [{
                        label: "Views",
                        backgroundColor: window.theme.primary,
                        borderColor: window.theme.primary,
                        hoverBackgroundColor: window.theme.primary,
                        hoverBorderColor: window.theme.primary,
                        data: [
                            {{$postViews}}
                        ],
                        barPercentage: .75,
                        categoryPercentage: .5
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false
                            },
                            stacked: false,
                            ticks: {
                                stepSize: 20
                            }
                        }],
                        xAxes: [{
                            stacked: false,
                            gridLines: {
                                color: "transparent"
                            }
                        }]
                    }
                }
            });
        });
</script>

@endsection