@extends('app')

@section('content')
    <livewire:developer></livewire:developer>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#birthday", {
            dateFormat: "Y-m-d",
            allowInput: true

        });

        function loadMultiJs() {
            /*
            console.log("aa");
            var multiSelectBasic = document.getElementById("skills");
            if (multiSelectBasic) {
                multi(multiSelectBasic, {
                    non_selected_header: "Not selected",
                    selected_header: "Selected"
                });
            }*/
        }

        loadMultiJs();


    </script>
@endsection
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endsection
