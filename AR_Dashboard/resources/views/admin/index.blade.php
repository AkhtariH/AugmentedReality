@extends('layout.app')

@section('title', 'Admin Panel')

@section('content')
    @if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    <div class="custom-header">
        <h3>Administrator Panel</h3>
    </div>
    <span class="text-secondary">Administrator Panel</span>
    

    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-theme border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-white">
                        <i class="fas fa-user-friends text-theme"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{ $userCount }}</strong></h3>
                        <p><small class="bc-description text-white">Anzahl an User</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-theme border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-white">
                        <i class="fas fa-stopwatch text-theme"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong></strong></h3>
                        <p><small class="bc-description text-white">Platzhalter</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-theme border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-white">
                        <i class="fas fa-calendar-alt text-theme"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong></strong></h3>
                        <p><small class="bc-description text-white">Platzhalter</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Skill bars-->
    {{-- <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
        <h6 class="mb-2">Bridges assigned {{ $data['assigned_bridges_count'] . '/' . $data['bridge_count']}}</h6>
        
        <p class="mb-2 mt-3">0% <span class="pull-right">100%</span></p>
        <div class="progress mb-4" style="height: 7px;">
            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{ $data['assigned_bridges_percentage'] }}" style="width: {{ $data['assigned_bridges_percentage'] }}%; "  aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div> --}}
    <!--/Skill bars -->



@endsection

@section('inclusions')
    @parent

    <script>

    </script>
@endsection