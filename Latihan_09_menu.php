<aside class="col-md-2 p-0">
    <nav class="nav flex-column bg-light p-3 m-0">
        <a class="nav-link <?php echo (isset($_GET['menu']) && $_GET['menu'] == 'home') ? 'active' : ''; ?>" href="?menu=home">Home</a>
        <a class="nav-link <?php echo (isset($_GET['menu']) && $_GET['menu'] == 'alumni') ? 'active' : ''; ?>" href="?menu=alumni">Alumni</a>
        <a class="nav-link <?php echo (isset($_GET['menu']) && $_GET['menu'] == 'Buku_tamu') ? 'active' : ''; ?>" href="?menu=Buku_tamu">Buku Tamu</a>
        <a class="nav-link <?php echo (isset($_GET['menu']) && $_GET['menu'] == 'bursa_kerja') ? 'active' : ''; ?>" href="?menu=bursa_kerja">Bursa Kerja</a>
        <a class="nav-link <?php echo (isset($_GET['menu']) && $_GET['menu'] == 'penelusuran_alumni') ? 'active' : ''; ?>" href="?menu=penelusuran_alumni">Penelusuran Alumni</a>
    </nav>
</aside>
