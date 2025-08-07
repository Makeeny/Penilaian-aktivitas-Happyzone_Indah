@extends('layouts.guru')
@section('title', 'Halaman Notifikasi')

@section('styles')
<style>
    .header-laporan { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .header-laporan h1 { font-size: 24px; font-weight: 700; margin: 0; }
    .notification-list { list-style: none; padding: 0; }
    .notification-item {
        background-color: #fff;
        border-left: 5px solid #e9ecef; /* Abu-abu untuk yang sudah dibaca */
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: box-shadow 0.2s, border-color 0.2s;
        cursor: pointer;
    }
    .notification-item.unread {
        border-left-color: #6a5ae0; /* Ungu untuk yang belum dibaca */
    }
    .notification-item:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .notification-icon {
        font-size: 20px;
        color: #6a5ae0;
        width: 40px;
        text-align: center;
    }
    .notification-content p { margin: 0; font-weight: 500; color: #333; }
    .notification-content .time { font-size: 13px; color: #777; }

    /* CSS untuk Modal/Pop-up */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.6); display: flex; justify-content: center; align-items: center; z-index: 1000; opacity: 0; visibility: hidden; transition: opacity 0.3s, visibility 0.3s; }
    .modal-overlay.show { opacity: 1; visibility: visible; }
    .modal-content { background-color: white; padding: 30px; border-radius: 15px; width: 90%; max-width: 400px; text-align: center; transform: scale(0.9); transition: transform 0.3s; }
    .modal-overlay.show .modal-content { transform: scale(1); }
    .modal-icon { width: 40px; height: 40px; line-height: 40px; background-color: #fefce8; color: #facc15; border-radius: 50%; margin: 0 auto 15px auto; font-size: 20px; }
    .modal-title { background-color: #fefce8; color: #a16207; padding: 5px 15px; border-radius: 20px; font-weight: 700; display: inline-block; margin-bottom: 15px; }
    .modal-body p { color: #555; line-height: 1.6; margin-bottom: 25px; }
    .modal-buttons { display: flex; gap: 15px; justify-content: center; }
    .modal-button { border: none; padding: 10px 30px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 15px; }
    .btn-danger { background-color: #ff4d4f; color: white; }
    .btn-primary { background-color: #6a5ae0; color: white; }
</style>
@endsection

@section('content')
<div class="header-laporan">
    <h1>Halaman Notifikasi</h1>
</div>

<div class="notification-list">
    @forelse($notifications as $notification)
        {{-- Hanya notifikasi yang belum dibaca yang bisa diklik --}}
        @if(!$notification->read_at)
            <div class="notification-item unread" 
                 onclick="bukaKonfirmasiGuru('{{ $notification->id }}', '{{ addslashes($notification->message) }}')">
                <i class="notification-icon fas fa-bell"></i>
                <div class="notification-content">
                    <p>{{ $notification->message }}</p>
                    <span class="time">{{ $notification->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @else
            <div class="notification-item">
                <i class="notification-icon fas fa-check-circle" style="color: #52c41a;"></i>
                <div class="notification-content">
                    <p><s>{{ $notification->message }}</s></p>
                    <span class="time">Telah direspon {{ $notification->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        @endif
    @empty
        <div class="notification-item">
            <p>Tidak ada notifikasi untuk saat ini.</p>
        </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $notifications->links() }}
</div>

{{-- Pop-up Konfirmasi untuk Guru --}}
<div id="konfirmasiGuruModal" class="modal-overlay" onclick="tutupModal('konfirmasiGuruModal')">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-icon"><i class="fas fa-info"></i></div>
        <h3 class="modal-title">KONFIRMASI TUKAR POIN</h3>
        <div class="modal-body">
            <p id="modalMessage">Konfirmasi Penukaran Poin siswa? Jika memilih "Terima" maka siswa akan mendapatkan reward, dan jika memilih "Tolak" maka poin siswa akan kembali tersimpan.</p>
        </div>
        <div class="modal-buttons">
            <form id="formTolak" method="POST">
                @csrf
                @method('POST')
                <button type="submit" class="modal-button btn-primary">Tolak</button>
            </form>
            <form id="formTerima" method="POST">
                @csrf
                @method('POST')
                <button type="submit" class="modal-button btn-danger">Terima</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function bukaKonfirmasiGuru(notificationId, message) {
        // Atur pesan di dalam modal
        document.getElementById('modalMessage').innerText = message + '\n\nKonfirmasi permintaan ini?';

        // Atur action untuk form "Terima"
        document.getElementById('formTerima').action = `/guru/notifications/${notificationId}/approve`;
        
        // Atur action untuk form "Tolak"
        document.getElementById('formTolak').action = `/guru/notifications/${notificationId}/reject`;

        // Tampilkan modal
        document.getElementById('konfirmasiGuruModal').classList.add('show');
    }

    function tutupModal(idModal) {
        document.getElementById(idModal).classList.remove('show');
    }
</script>
@endpush