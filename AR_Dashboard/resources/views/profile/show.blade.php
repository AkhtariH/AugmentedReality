@extends('layout.app')

@section('title', $user->first_name . ' ' . $user->last_name)

@section('content')

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <!--Content types-->
    <div class="custom-header">
        <h3>User Profil</h3>
    </div>
    <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Profil <i class="fa fa-angle-right"></i> {{ $user->first_name }} {{ $user->last_name }}</span>

    <div class="row mt-3">
        <div class="col-sm-12">
            <!--User profile header-->
            <div class="mt-1 mb-3 button-container bg-white border shadow-sm">
                <div class="profile-bg p-5">
                    <img src="{{ asset('/img/uploads') . '/' . $user->profile_image }}" height="125px" width="125px" class="rounded-circle shadow profile-img">
                </div>
                <div class="profile-bio-main container-fluid">
                    <div class="row">
                        <div class="col-md-5 offset-md-3 col-sm-12 offset-sm-0 col-12 bio-header">
                            <h3 class="mt-4">{{ $user->first_name }} {{ $user->last_name }}</h3>
                            <span class="text-muted mt-0 bio-request">{{ ucfirst($user->type) }}</span>
                        </div>
                        {{-- <div class="col-md-4 col-sm-12 col-12 px-5 text-right pt-4 bio-comment">
                            <button type="button" class="btn btn-default">
                                <i class="far fa-comment"></i>
                            </button>
                            <button type="button" class="btn btn-theme">Request</button>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!--/User profile header-->

        </div>
    </div>
<div class="row mt-3">
        <!--User profile sidebar-->
        <div class="col-sm-12 col-md-4">
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                
                <div class="mb-3">
                    <div class="row user-about">
                        <div class="col-sm-6 col-6 border-right text-center">
                            <h4>{{ $entriesLength }}</h4>
                            <p>Einträge</p>
                        </div>
                        <div class="col-sm-6 col-6 text-center">
                            <h4>{{ round($overtime / 60) }}</h4>
                            <p>Überstunden</p>
                        </div>
                    </div>
                </div>
                
                @if ($supervisor !== null)
                    <div class="dropdown-divider"></div>
                    <div class="mb-3">
                        <h6>Vorgesetzte</h6>
                        <p class="p-typo">{{ $supervisor->first_name }} {{ $supervisor->last_name }} (<a href="{{ route('profile.show', $supervisor->id) }}">{{ $supervisor->username }}</a>)</p>
                        {{-- <div class="text-right">
                            <button type="button" class="btn btn-theme">
                                <i class="fa fa-user-plus"></i> Follow
                            </button>
                        </div> --}}
                    </div>
                @endif

            </div>
        </div>
        <!--/User profile sidebar-->

        <!--User profile content-->
        <div class="col-sm-12 col-md-8">
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm custom-tabs">
                
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-customContent" role="tablist">
                        <a class="nav-item nav-link active show" id="nav-profile" data-toggle="tab" href="#custom-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                            <i class="fa fa-file-text-o active show"></i> Persönliche Informationen
                        </a>
                        <a class="nav-item nav-link" id="nav-profile" data-toggle="tab" href="#custom-contact" role="tab" aria-controls="nav-profile" aria-selected="false">
                            <i class="far fa-calendar-alt"></i> Letzte Einträge
                        </a>
                    </div>
                </nav>

                <div class="tab-content py-3 px-3 px-sm-0" id="nav-customContent">

                    <!--Personal info tab-->
                    <div class="tab-pane fade p-4 show active" id="custom-profile" role="tabpanel" aria-labelledby="nav-profile">
                        <div class="table-responsive mb-4">
                            <table class="table table-borderless table-striped m-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Username</th>
                                        <td>{{ $user->username }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">E-Mail Adresse</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Account Typ</th>
                                        <td>{{ ucfirst($user->type) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--/Personal info tab-->

                    <div class="tab-pane fade p-4" id="custom-contact" role="tabpanel" aria-labelledby="nav-contact">
                                    
                        <div class="mb-4">
                            <div class="table-responsive product-list">
                
                                <table class="table table-striped table-bordered dataTable" id="productList" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th>Eintrag #</th>
                                            <th>Von</th>
                                            <th>Bis</th>
                                            <th>Uhrzeit</th>
                                            <th>Arbeitszeit</th>
                                            <th>Pause</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($entries as $entry)
                                            <tr>
                                                <td>{{ $entry->id }}</td>
                                                <td>{{ $entry->date_from->format('d.m.Y') }}</td>
                                                <td>{{ $entry->date_to->format('d.m.Y') }}</td>
                                                {{-- um {{ $entry->time_to->format('H:i') }} --}}
                                                <td>{{ $entry->time_from->format('H:i') }} bis {{ $entry->time_to->format('H:i') }} Uhr</td>
                                                <td>{{ $entry->hours }}</td>
                                                <td>{{ $entry->break_in_minutes }} Minuten</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!--/User profile content-->
    </div>

<!--/Content types-->
@endsection