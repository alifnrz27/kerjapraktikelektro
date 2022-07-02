<x-app-layout>
    {{-- Halaman buat Mahasiswa --}}
    {{-- jika belum pernah input sebelumnya di semester yang sama --}}
    @if($submissionStatus == Null || $submissionStatus == 5 || $submissionStatus == 7 || $submissionStatus == 8 || $submissionStatus == 9)
    <form action="/upload-submission" method="POST">
        @csrf
        <label for="">input transkrip</label>
        <input name="transcript" type="text">
        <label for="">sertif vaksin</label>
        <input name="vaccine" type="text">
        <label for="">form pengajuan</label>
        <input name="form" type="text">
        <label for="">start</label>
        <input name="start" type="date">
        <label for="">end</label>
        <input type="date" name="end">
        <label for="">place</label>
        <input type="text" name="place">
        <input type="checkbox" name="addTeam">
        <input type="text" name="teamMember">
        <button type="submit">submit</button>
    </form> 

    {{-- jika sudah pernah input sebelumnya di semester yang sama atau tidak batal --}}
    @elseif($submissionStatus != Null)
        {{ $submissionStatus }}
        {{-- jika sudah diajukan dan menunggu admin acc --}}
        @if($submissionStatus == 1)
            Harap menunggu, admin sedang memeriksa
            <form action="/cancel-submission" method="POST">
                @csrf
                <button type="submit">batalkan pengajuan</button>
            </form>

        {{-- tampilan saat ketua menunggu semua acc undangan --}}
        @elseif($submissionStatus == 2)
            Menunggu seluruh tim acc/tolak undangan
            <form action="/cancel-submission" method="POST">
                @csrf
                <button type="submit">batalkan pengajuan</button>
            </form>
        {{-- jika mendapat undangan join team --}}
        @elseif($submissionStatus == 3)
            <form action="/accept-invitation" method="POST">
                @csrf
                <button type="submit">Terima</button>
            </form>
            <form action="/decline-invitation" method="POST">
                @csrf
                <button type="submit">tolak</button>
            </form>

        {{-- jika telah menerima undangan tim --}}
        @elseif($submissionStatus == 4)
        Anda menerima undangan, lengkapi berkas
        <form action="/upload-member-submission" method="POST">
            @csrf
            <label for="">input transkrip</label>
            <input name="transcript" type="text">
            <label for="">sertif vaksin</label>
            <input name="vaccine" type="text">
            <label for="">form pengajuan</label>
            <input name="form" type="text">
            <button type="submit">submit</button>
        </form> 
        <form action="/cancel-submission" method="POST">
            @csrf
            <button type="submit">batalkan pengajuan</button>
        </form>

        {{-- menunggu seluruh tim upload berkas --}}
        @elseif($submissionStatus == 6)
        Menunggu seluruh tim upload berkas
        <form action="/cancel-submission" method="POST">
            @csrf
            <button type="submit">batalkan pengajuan</button>
        </form>

        @elseif($submissionStatus == 10 || $submissionStatus == 12)
        @if($submissionStatus == 10)
            Selamat berkas anda diterima, download file di bawah dan ajukan ke jurusan
        @else
            Berkas ditolak, upload ulang
        @endif
        <form action="/upload-letter" method="POST">
            @csrf
            <label for="">Surat dari jurusan</label>
            <input type="text" name="replyFromMajor">
            <label for="">Surat dari instansi</label>
            <input type="text" name="replyFromCompany">
            <button type="submit">Submit</button>
        </form>
        <form action="/cancel-submission" method="POST">
            @csrf
            <button type="submit">batalkan pengajuan</button>
        </form>

        {{-- halaman jika di terima --}}
        @elseif($submissionStatus == 13)
        Pengajuan kamu diterima
        Logbook
        <form action="/input-logbook" method="POST">
            @csrf
            <input type="date" name="date">
            <label for="">Deskripsi kegiatan</label>
            <input type="text" name="description">
            <button type="submit">Submit</button>
        </form>
        Daftar Logbook
        <table>
            @if($logbooks != Null)
                <tr>
                    <th>tanggal</th>
                    <th>Deskripsi</th>
                </tr>
                @foreach($logbooks as $logbook)    
                    <tr>
                    <td>{{ $logbook->date }}</td>
                    <td>{{ $logbook->description }}</td>
                    </tr>
                @endforeach
            @else
            Kau belum isi logbook pra   
            @endif
          </table>
        @endif
    @endif
    {{-- Akhir halaman mahasiswa --}}
</x-app-layout>