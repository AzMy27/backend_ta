
@include('layouts.header')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">{{$title ?? 'Unset Yet'}}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{$description ?? 'Unset Yet'}}</li>
        </ol>
    @yield('content')
</main>

@include('layouts.footer')