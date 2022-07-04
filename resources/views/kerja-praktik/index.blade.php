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
                {{-- jika berupa tim, tampilkan seluruh nama anggota --}}
                    @if($letter->team_id != 0)
                    <?php $members = App\Models\SubmissionJobTraining::where('team_id' , $letter->team_id)->get(); ?>
                    <td>
                    @foreach($members as $member)
                    {{ $member->user->name }} ||
                    @endforeach
                    </td>
                    <td>{{ $members[0]->place }}</td>
                    <td>{{ $members[0]->start }} - {{ $members[0]->end }}</td>
                    {{-- jika semdiri tampilkan namanya --}}
                    @else
                    <?php $member = App\Models\SubmissionJobTraining::where(['user_id' => $letter->user_id, 'submission_status_id'=>11, 'academic_year_id'=>$academicYear])->first(); ?>
                    <td>{{ $member->user->name }}</td>
                    <td>tempat</td>
                    <td>tanggal</td>
                    @endif
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

        Pilih mentor untuk mahasiswa
        <table>
            @if($chooseMentor == Null)
                Tidak ada mahasiswa
            @else
            <tr>
                <td>Nama</td>
                <td>Aksi</td>
            </tr>
            @foreach($chooseMentor as $student)
                <tr>
                    <td>{{ $student->user->name }}</td>
                    <td>
                        <form action="/choose-mentor/{{ $student->user->username }}" method="POST">
                            @csrf
                            <select name="mentor" id="mentor">
                                @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->username }}">{{ $mentor->name }}</option>
                                @endforeach
                              </select>
                              <button type="submit">Oke</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @endif
        </table>

        Daftar yang udah punya pembimbing semester ini
        <table>
            @if($haveMentor == Null)
                Belum ada mahasiswa yg punya mentor
            @else
            <tr>
                <td>mahasiswa</td>
                <td>dosen</td>
                <td>aksi</td>
            </tr>
            @foreach ($haveMentor as $have)
            <?php $student = App\Models\User::where(['id' => $have->student_id])->first();
                $mentor = App\Models\User::where(['id' => $have->lecturer_id])->first();
            ?>
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $mentor->name }}</td>
                    <td>
                        <form action="/choose-mentor/{{ $student->username }}/{{ $have->id }}" method="POST">
                            @csrf
                            @method('put')
                            <select name="mentor" id="mentor">
                                @foreach($mentors as $mentor)
                                @if($have->lecturer_id == $mentor->id)
                                <option value="{{ $mentor->username }}" selected>{{ $mentor->name }}</option>
                                @else
                                <option value="{{ $mentor->username }}">{{ $mentor->name }}</option>
                                @endif
                                @endforeach
                              </select>
                              <button type="submit">ganti</button>
                        </form>
                        <form action="/choose-mentor/{{ $student->username }}/{{ $have->id }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit">hapus</button>
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

        {{-- halaman setelah upload berkas dari jurusan --}}
        @elseif($submissionStatus == 11)
        menunggu admin acc berkas jurusan
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
        @elseif($submissionStatus == 14)
        mengunggu seluruh anggota tim di acc
        @endif
    @endif
    {{-- Akhir halaman mahasiswa --}}
    @endif
</x-app-layout>