<!DOCTYPE html>
<html lang="en">
    <head>
        @include('font_end.head')
    </head>
    <body>
        {{-- Header top menu bar --}}
        @include('font_end.header.topSection')
        @yield('body')
        <!-- Footer -->
        @include('font_end.footer.footer')
        @include('font_end.scripts')

        {{-- font end scripts --}}
        @stack('fontEnd_script')
    </body>

</html>
