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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="{{url('/assets/demo/chart-area-demo.js')}}"></script>
<script src="{{url('/assets/demo/chart-bar-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="{{url('/js/datatables-simple-demo.js')}}"></script>
<script>
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops! Ada kesalahan!',
            html: `
                <ul style="text-align: left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
        });
    @endif

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
        });
    @endif
</script>
<script>
    let formToDelete; 

    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                formToDelete = this.closest('.delete-form');
                deleteModal.show();
            });
        });

        confirmDeleteBtn.addEventListener('click', function () {
            if (formToDelete) {
                formToDelete.submit(); // Kirim form
            }
        });
    });
</script>
</body>
</html>
