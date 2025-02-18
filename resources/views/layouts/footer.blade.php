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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    
    const currentPath = window.location.pathname;
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        const cleanHref = href.replace(/^https?:\/\/[^\/]+/, '');
        
        if (currentPath === cleanHref || currentPath.startsWith(cleanHref)) {
            link.classList.add('active');
        }
        
        link.addEventListener('click', function(e) {
            navLinks.forEach(l => l.classList.remove('active'));
            
            this.classList.add('active');
            
            localStorage.setItem('activeNavLink', this.getAttribute('href'));
        });
    });
    
    // Check localStorage on page load
    const storedActiveLink = localStorage.getItem('activeNavLink');
    if (storedActiveLink) {
        const matchingLink = Array.from(navLinks).find(link => 
            link.getAttribute('href') === storedActiveLink
        );
        if (matchingLink) {
            matchingLink.classList.add('active');
        }
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get current URL path
    const currentPath = window.location.pathname;
    
    // Get all nav links
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Loop through each link
    navLinks.forEach(link => {
        // If the link's href matches the current path
        if (link.getAttribute('href').includes(currentPath)) {
            link.classList.add('active');
        }
        
        // Add click handler
        link.addEventListener('click', function() {
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
        });
    });
});
</script>
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

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Gagal!",
                    text: "{{ session('error') }}",
                    icon: "error"
                });
            });
        </script>
    @endif
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                form.submit();
            }
        });
    });
});
</script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
</body>
</html>
