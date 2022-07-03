<x-app-layout>
    {{-- Halaman buat Admin --}}
    @if(auth()->user()->role_id == 1)
        Data pengajuan baru
        <table>
            @if($newSubmissions == Null)
                Tidak ada pengajuan baru
            @else
            <tr>
                <th></th>
                <th>Nama</th>
                <th>Tempat</th>
                <th>tanggal</th>
                <th>action</th>
            </tr>
            @foreach($newSubmissions as $submission)
            <tr>
                @if($submission->team_id == 0)
                <td>-</td>
                @else
                <td>group</td>
                @endif
                <td>{{ $submission->user->name }}</td>
                <td>{{ $submission->place }}</td>
                <td>{{ $submission->start }} - {{ $submission->end }}</td>
                <td>
                    <a href="{{ $submission->form }}">Form pengajuan</a>
                    <a href="{{ $submission->transcript }}">Transkrip nilai</a>
                    <a href="{{ $submission->vaccine }}">Vaksin</a>
                </td>
                <td>
                    <form action="/accept-submission/{{ $submission->user->username }}/{{ $submission->id }}" method="POST">
                        @csrf
                        <button type="submit">Terima</button>
                    </form>
                    <form action="/decline-submission/{{ $submission->user->username }}/{{ $submission->id }}" method="POST">
                        @csrf
                        <input type="text" name="description">
                        <button type="submit">Tolak</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @endif
        </table>

        Daftar mahasiswa pengajuan kedua
        <table>
            @if($newLetters == Null)
            tidak ada data
            @else
            <tr>
                <th></th>
                <th>Nama</th>
                <th>Tempat</th>
                <th>tanggal</th>
                <th>action</th>
            </tr>

            @foreach($newLetters as $letter)
                <tr>
                    <td>{{ $letter->user_id }}</td>
                    <td>tempat</td>
                    <td>tanggal</td>
                    <td>
                        <form action="/accept-letter/{{ $letter->user->username }}/{{ $letter->team_id }}" method="POST">
                            @csrf
                            <button type="submit">Terima</button>
                        </form>
                        <form action="/decline-letter/{{ $letter->user->username }}/{{ $letter->team_id }}" method="POST">
                            @csrf
                            <input type="text" name="description">
                            <button type="submit">Tolak</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @endif
        </table>

    {{-- Akhir halaman Admin --}}

    {{-- Halaman buat dosen --}}
    @elseif(auth()->user()->role_id == 2)

    {{-- akhir halaman dosen --}}

    {{-- Halaman buat mahasiswa --}}
    @elseif(auth()->user()->role_id == 3)
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
        @if($submissionStatus == 1 || $submissionStatus == 2 || $submissionStatus == 6 || $submissionStatus == 14)
            
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
        <form action="/decline-invitation" method="POST">
            @csrf
            <button type="submit">batal join grup</button>
        </form>
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
    @endif
</x-app-layout>