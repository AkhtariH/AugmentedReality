@extends('layout.app')

@section('title', 'Create bridge')

@section('content')
<div class="mt-1 mb-5 button-container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-2">Add bridge</h3>
            <small class="">Add a new bridge</small>
            @if($errors->any())
                <div class="alert alert-danger">{{$errors->first()}}</div>
            @endif
            <form action="{{ route('admin.bridge.store') }}" method="POST" class="mt-2">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Bridge 1">
                </div>

                <div class="form-group">
                    <label for="name">Address</label>
                    <input type="adress" class="form-control" id="adress" name="adress" placeholder="e.g. Grote Markt, Groningen" data-toggle="dropdown">
                    <div class="dropdown" id="drop-custom">
                        <div class="dropdown-menu" id="autodrop">
                          </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name">Supervisor</label>
                    <input type="text" class="form-control" id="supervisor" name="supervisor" placeholder="Supervisor">
                </div>

                <div class="form-group">
                    <label for="name">Bridge Hash</label>
                    <input type="text" class="form-control" id="bridgeHash" name="bridgeHash" placeholder="e.g. 100">
                </div>
        
                <div class="form-group">
                    <button class="btn btn-light btn-block p-2 mb-1" type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('inclusions')
    @parent

    <script>
        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                callback.apply(context, args);
                }, ms || 0);
            };
        }
        $('#adress').on('keyup', delay(function (e) {
            //alert($(this).val());
            $('.dropdown > .dropdown-menu').html('');
            $.ajax({
                    type: "GET",
                    url: 'http://www.mapquestapi.com/search/v3/prediction?key=HSpGQTU57l0axHugD5o7BjhWZbGnM7Ru&limit=5&collection=adminArea,poi,address,category,franchise,airport&q=' + $(this).val() + '&location=52.21,5.27&countryCode=NL',
                    success: function(data) {
                        
                        for (var i = 0; i < data.results.length; i++) {
                            $('.dropdown > .dropdown-menu').append('<a class="dropdown-item small-font auto-item">' + data.results[i].displayString + '</a>');
                        }
                        $('#drop-custom').show();
                        $('#autodrop').show();
                        // $('.auto-item').on('click', function () {
                        //     $('#adress').val($(this).html());
                        // });
                    }
            });

        }, 500));

        $('.dropdown-menu').on('click', '.auto-item', function() {
            $('#adress').val($(this).html());
            $('.dropdown > .dropdown-menu').html('');
            $('#drop-custom').hide();
            $('#autodrop').hide();
        });

    
    </script>
@endsection