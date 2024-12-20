<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - Admin</title>
        <link href="{{url('css/styles.css')}}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Register</h3></div>
                                    <div class="card-body"> 
                                        <form action="{{ route('register.store') }}" method="POST">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputName" type="text" placeholder="Masukkan Nama" name="name" />
                                                <label for="inputName">Nama</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputkecamatan" type="text" placeholder="Masukkan Nama Kecamatan" name="nama_kecamatan" />
                                                <label for="inputKecamatan">Nama Kecamatan</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputTelepon" type="text" placeholder="Masukkan No. Telepon" name="telepon" />
                                                <label for="inputTelepon">No. Telepon</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" placeholder="email" name="email" />
                                                <label for="inputEmail">Email</label>
                                            </div>
                                     
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="password" name="password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="ulangi_password" name="password_confirmation" required/>
                                                <label for="inputPassword">Ulangi Password</label>
                                            </div>
                                            @error('password_confirmation')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-block" type="submit">Daftar</button>
                                            </div>
                                        </form>                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{url('js/scripts.js')}}"></script>
    </body>
</html>
