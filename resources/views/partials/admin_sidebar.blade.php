<aside id="sidebar" class="sidebar">
  <ul>
    <li><a href="{{ route('admin.users.index') }}">Daftar Akun</a></li>
    <li><a href="{{ route('admin.profil_siswa.index') }}">Data Profil Siswa</a></li>
    <li><a href="{{ route('admin.mapel.index') }}">Data Mapel & Bobot SAW</a></li>
    <li class="submenu">
      <a href="#">Mata Pelajaran ▾</a>
      <ul>
        @foreach(\App\Models\Mapel::all() as $mapel)
          <li><a href="{{ route('admin.mapel.show', $mapel->id) }}">{{ $mapel->nama }}</a></li>
        @endforeach
      </ul>
    </li>
    <li><a href="{{ route('logout') }}">Log-out</a></li>
  </ul>
</aside>
