<x-app-layout>
    {{ session('status') }}

    {{-- Halaman buat Admin --}}
    <div class="admin">
        @if(auth()->user()->role_id == 1)
        <section class="antialiased bg-gray-100 text-gray-600 h-screen px-4">
            {{-- Daftar antri pengajuan awal KP --}}
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">Data pengajuan baru</div>
                    </header>
        
                    @if($queueSubmissions == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tempat</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Kepala Instansi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Alamat instansi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">No telp instansi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tanggal</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Link</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Action</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($queueSubmissions as $submission)
                                <tr>
                                    <td class="p-2">
                                        <div class="font-medium text-gray-800">
                                            {{ $submission->user->name }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->place }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->name_leader }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->address }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->number }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->start }} - {{ $submission->end }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            <a href="{{ $submission->form }}">Form</a>
                                            <a href="{{ $submission->transcript }}"> Transkrip</a>
                                            <a href="{{ $submission->vaccine }}">Vaksin</a>
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="flex justify-center">
                                            <form action="/accept-submission/{{ $submission->user->username }}/{{ $submission->id }}" method="POST">
                                                @csrf
                                                <button type="submit">terima</button>
                                            </form>
                                            <form action="/decline-submission/{{ $submission->user->username }}/{{ $submission->id }}" method="POST">
                                                @csrf
                                                <input type="text" name="description">
                                                <button type="submit">tolak</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            {{-- Akhir Daftar antri pengajuan awal KP --}}

            {{-- history Pengajuan keseluruhan --}}
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">History Pengajuan Baru</div>
                    </header>
                    @if($historyQueueSubmissions == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tempat</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Kepala Instansi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Alamat instansi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">No telp instansi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tanggal</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Link</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Status</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($historyQueueSubmissions as $submission)
                                <tr>
                                    <td class="p-2">
                                        <div class="font-medium text-gray-800">
                                            {{ $submission->user->name }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->place }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->name_leader }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->address }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->number }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $submission->start }} - {{ $submission->end }}
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            <a href="{{ $submission->form }}">Form</a>
                                            <a href="{{ $submission->transcript }}"> Transkrip</a>
                                            <a href="{{ $submission->vaccine }}">Vaksin</a>
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <div class="text-left font-medium text-green-500">
                                            {{ $queueSubmissionStatus[$submission->submission_status_id - 1]->name }}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            {{-- Akhir history Pengajuan keseluruhan --}}

        </section>

        <section class="antialiased bg-gray-100 text-gray-600 h-screen px-4">
            {{-- Daftar Antri pengajuan surat jurusan --}}
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">Data pengajuan surat jurusan</div>
                    </header>
        
                    @if($newLetters == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tempat</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tanggal</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Action</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($newLetters as $letter)
                                <tr>
                                    {{-- jika berupa tim, tampilkan seluruh nama anggota --}}
                                    @if($letter->team_id != 0)
                                    <?php $members = App\Models\SubmissionJobTraining::where('team_id' , $letter->team_id)->get(); ?>
                                    <td class="p-2">
                                    @foreach($members as $member)
                                    {{ $member->user->name }} ||
                                    @endforeach
                                    </td>
                                    <td class="p-2">{{ $members[0]->place }}</td>
                                    <td class="p-2">{{ $members[0]->start }} - {{ $members[0]->end }}</td>
                                    {{-- jika semdiri tampilkan namanya --}}
                                    @else
                                    <?php $member = App\Models\SubmissionJobTraining::where(['user_id' => $letter->user_id, 'submission_status_id'=>12, 'academic_year_id'=>$academicYear])->first(); ?>
                                    <td class="p-2">{{ $member->user->name }}</td>
                                    <td class="p-2">tempat</td>
                                    <td class="p-2">tanggal</td>
                                    @endif
                                    <td class="p-2">
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
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            {{-- Akhir daftar antri pengajuan surat jurusan --}}

            {{-- history Pengajuan surat jurusan --}}
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">History Pengajuan Surat Jurusan</div>
                    </header>
                    @if($historyLetters == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tempat</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tanggal</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Status</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($historyLetters as $letter)
                                <tr>
                                    {{-- jika berupa tim, tampilkan seluruh nama anggota --}}
                                    @if($letter->team_id != 0)
                                    <?php $members = App\Models\SubmissionJobTraining::where('team_id' , $letter->team_id)->get(); ?>
                                    <td class="p-2">
                                    @foreach($members as $member)
                                    {{ $member->user->name }} ||
                                    @endforeach
                                    </td>
                                    <td class="p-2">{{ $members[0]->place }}</td>
                                    <td class="p-2">{{ $members[0]->start }} - {{ $members[0]->end }}</td>
                                    {{-- jika semdiri tampilkan namanya --}}
                                    @else
                                    <?php $member = App\Models\SubmissionJobTraining::where(['id' => $letter->id])->first(); ?>
                                    <td class="p-2">{{ $member->user->name }}</td>
                                    <td class="p-2">{{ $member->place }}</td>
                                    <td class="p-2">{{ $member->start }} - {{ $member->end }}</td>
                                    @endif
                                    <td class="p-2">{{ $historyLettersStatus[$letter->reply_letter_status_id - 1]->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            {{-- Akhir History pengajuan surat jurusan --}}
        </section>

        <section class="antialiased bg-gray-100 text-gray-600 h-screen px-4">
            {{-- Daftar pilih dosen pembimbing untuk mahasiswa --}}
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">Pilih Pembimbing</div>
                    </header>
                    @if($chooseMentor == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Aksi</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($chooseMentor as $student)
                                <tr>
                                    <td class="p-2">{{ $student->user->name }}</td>
                                    <td class="p-2">
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
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            {{-- Daftar pilih dosen pembimbing untuk mahasiswa --}}

            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">History Pilih Pembimbing</div>
                    </header>
                    @if($haveMentor == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Dosen</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Aksi</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach ($haveMentor as $have)
                                <?php $student = App\Models\User::where(['id' => $have->student_id])->first();
                                    $mentor = App\Models\User::where(['id' => $have->lecturer_id])->first();
                                ?>
                                    <tr>
                                        <td class="p-2">{{ $student->name }}</td>
                                        <td class="p-2">{{ $mentor->name }}</td>
                                        <td class="p-2">
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
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="antialiased bg-gray-100 text-gray-600 h-screen px-4">
            {{-- Daftar pilih dosen pembimbing untuk mahasiswa --}}
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">Daftar pengumpulan berkas sebelum seminar</div>
                    </header>
                    @if($beforePresentationQueue == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Link</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Aksi</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($beforePresentationQueue as $queue)
                                <?php $student = App\Models\User::where(['student_id' => $queue->student_id])->first() ?>
                                <tr>
                                    <td class="p-2">{{ $student->name }}</td>
                                    <td class="p-2">
                                    <a href="{{ $queue->form }}">Form</a>
                                    <a href="{{ $queue->company }}">Nilai perusahaan</a>
                                    <a href="{{ $queue->logbook }}">Logbook</a>
                                    </td>
                                    <td class="p-2">
                                        <form action="/accept-before-presentation/{{ $student->id }}/{{ $queue->id }}" method="POST">
                                            @csrf
                                            <button type="submit">Oke</button>
                                        </form>
                                        <form action="/decline-before-presentation/{{ $student->id }}/{{ $queue->id }}" method="POST">
                                            @csrf
                                            <input type="text" name="description">
                                            <button type="submit">tolak</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            {{-- Daftar pilih dosen pembimbing untuk mahasiswa --}}

            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">History Pilih Pembimbing</div>
                    </header>
                    @if($haveMentor == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Dosen</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-center">Aksi</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach ($haveMentor as $have)
                                <?php $student = App\Models\User::where(['id' => $have->student_id])->first();
                                    $mentor = App\Models\User::where(['id' => $have->lecturer_id])->first();
                                ?>
                                    <tr>
                                        <td class="p-2">{{ $student->name }}</td>
                                        <td class="p-2">{{ $mentor->name }}</td>
                                        <td class="p-2">
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
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    {{-- Akhir halaman Admin --}}

    {{-- Halaman buat dosen --}}
    <div class="lecturer">
        @elseif(auth()->user()->role_id == 2)
        {{-- Daftar mahasiswa bimbingan --}}
        <section>
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">Daftar mahasiswa Bimbingan</div>
                    </header>
                    @if($allStudents == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">NIM</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tempat</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Tanggal</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($allStudents as $student)
                                <?php
                                $submission = App\Models\SubmissionJobTraining::where(['user_id'=>$student->student_id, 'academic_year_id'=>$academicYear])->latest()->first();
                                ?>
                                <tr>
                                    <td class="p-2">{{ $submission->user->name }}</td>
                                    <td class="p-2">{{ $submission->user->nim_nidn_nrk_nip }}</td>
                                    <td class="p-2">{{ $submission->place }}</td>
                                    <td class="p-2">{{ $submission->start }} - {{ $submission->end }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        {{-- akhir daftar mahasiswa bimbingan --}}

        {{-- Daftar pengajuan bimbingan --}}
        <section>
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">Daftar mahasiswa pengajuan Bimbingan</div>
                    </header>
                    @if($addMentoring == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Aksi</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach ($addMentoring as $mentoring)
                                <?php $student = App\Models\User::where(['id'=>$mentoring->student_id])->first(); ?>
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            <form action="/accept-mentoring/{{ $student->id }}" method="POST">
                                                @csrf
                                                <input type="datetime-local" name="time">
                                                <input type="text" name="description">
                                                <button type="submit">Terima</button>
                                            </form>
                                            <form action="/decline-mentoring/{{ $student->id }}" method="POST">
                                                @csrf
                                                <button type="submit">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        {{-- Akhir daftar pengajuan bimbingan --}}

        {{-- Daftar Antri bimbingan --}}
        <section>
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">Daftar antri mahasiswa Bimbingan</div>
                    </header>
                    @if($mentoringQueue == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Jadwal</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Deskripsi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Aksi</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($mentoringQueue as $queue)
                                <?php $student = App\Models\User::where('id', $queue->student_id)->first() ?>
                                    <tr>
                                        <td class="p-2">{{ $student->name }}</td>
                                        <td class="p-2">{{ $queue->time }}</td>
                                        <td class="p-2">{{ $queue->description }}</td>
                                        <td class="p-2">
                                            <form action="/finished-mentoring/{{ $queue->id }}" method="POST">
                                                @csrf
                                                <button type="submit">Selesai</button>
                                            </form>
                                            <form action="/cancel-mentoring/{{ $queue->id }}" method="POST">
                                                @csrf
                                                <button type="submit">Batal</button>
                                            </form>
                                            <form action="/update-mentoring/{{ $queue->id }}" method="POST">
                                                @csrf
                                                <input type="datetime-local" name="time" value="{{ $queue->time }}">
                                                <input type="text" name="description" value="{{ $queue->description }}">
                                                <button type="submit">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        {{-- Akhir daftar antri bimbingan --}}

        {{-- History Daftar bimbingan --}}
        <section>
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">History Daftar mahasiswa Bimbingan</div>
                    </header>
                    @if($lecturerMentoringHistory == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Jadwal</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Deskripsi</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Status</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($lecturerMentoringHistory as $history)
                                <?php $student = App\Models\User::where('id', $history->student_id)->first() ?>
                                    <tr>
                                        <td class="p-2">{{ $student->name }}</td>
                                        <td class="p-2">{{ $history->time }}</td>
                                        <td class="p-2">{{ $history->description }}</td>
                                        <td class="p-2">{{ $lecturerMentoringHistoryStatus[$history->mentoring_status_id - 1]->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        {{-- Akhir History daftar bimbingan --}}

        {{-- Daftar pengajuan judul --}}
        <section>
            <div class="flex flex-col justify-center h-full">
                <!-- Table -->
                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="font-semibold text-gray-800">Pengajuan judul</div>
                    </header>
                    @if($jobTrainingTitles == Null)
                    tidak ada
                    
                    @else
                    <div class="overflow-x-auto p-3">
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                <tr>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Nama</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Jadwal</div>
                                    </th>
                                    <th class="p-2">
                                        <div class="font-semibold text-left">Aksi</div>
                                    </th>
                                </tr>
                            </thead>
        
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach($jobTrainingTitles as $title)
                                <?php $student = App\Models\User::where('id', $title->student_id)->first() ?>
                                    <tr>
                                        <td class="p-2">{{ $student->name }}</td>
                                        <td class="p-2">{{ $title->title }}</td>
                                        <td class="p-2">
                                            <form action="/accept-job-training-title/{{ $title->student_id }}/{{ $title->id }}" method="POST">
                                                @csrf
                                                <button type="submit">Terima</button>
                                            </form>
                                            <form action="/decline-job-training-title/{{ $title->student_id }}/{{ $title->id }}" method="POST">
                                                @csrf
                                                <input type="text" name="description">
                                                <button type="submit">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        {{-- Akhir Daftar pengajuan judul --}}

        Daftar antri Revisi Laporan
        <table>
            @if($reportQueue == Null)
            Tidak ada antrian
            @else
            <tr>
                <td>nama</td>
                <td>link</td>
                <td></td>
            </tr>
            @foreach($reportQueue as $queue)
            <?php $student = App\Models\User::where('id', $queue->student_id)->first() ?>
                <tr>
                    <td>{{ $student->name }}</td>
                    <td><a href="{{ $queue->report }}">Laporan</a></td>
                    <td>
                        <form action="/accept-report/{{ $queue->id }}" method="POST">
                            @csrf
                            <input type="text" name="description">
                            <button type="submit">Selesai</button>
                        </form>
                        <form action="/decline-report/{{ $queue->id }}" method="POST">
                            @csrf
                            <input type="text" name="description">
                            <button type="submit">Revisi</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @endif
        </table>
    </div>

    {{-- akhir halaman dosen --}}

    {{-- Halaman buat mahasiswa --}}
    <div class="student">
        @elseif(auth()->user()->role_id == 3)
        
            @if($submissionStatus != Null)
             {{-- menampilkan keterangan status --}}
            {{ $statusSubmission[$submissionStatus-1]->name }}
            @endif
            
            @if($submissionStatus <= 13 || $submissionStatus == Null)
                {{-- Halaman pengajuan --}}
                <div>
                    @if($submissionStatus == Null || $submissionStatus == 3 || $submissionStatus == 6 || $submissionStatus == 7 || $submissionStatus == 8)
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="/upload-submission" method="POST">
                            @csrf
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                    <label for="place" class="block text-sm font-medium text-gray-700">Nama instansi</label>
                                    <input type="text" name="place" id="place" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('place') }}">
                                    </div>
                    
                                    <div class="col-span-6 sm:col-span-3">
                                    <label for="name_leader" class="block text-sm font-medium text-gray-700">Nama Kepala Instansi</label>
                                    <input type="text" name="name_leader" id="name_leader" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('name_leader') }}">
                                    </div>
                    
                                    <div class="col-span-6 sm:col-span-4">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat instansi</label>
                                    <input type="text" name="address" id="address" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('address') }}">
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="number" class="block text-sm font-medium text-gray-700">No telp instansi</label>
                                        <input type="text" name="number" id="number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('number') }}">
                                        </div>
                    
                                    <div class="col-span-6">
                                    <label for="transcript" class="block text-sm font-medium text-gray-700">URL Transkrip</label>
                                    <input type="text" name="transcript" id="transcript" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('transcript') }}">
                                    </div>
                    
                                    <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                    <label for="vaccine" class="block text-sm font-medium text-gray-700">URL Sertif vaksin</label>
                                    <input type="text" name="vaccine" id="vaccine" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('vaccine') }}">
                                    </div>
                    
                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="form" class="block text-sm font-medium text-gray-700">URL Form pengajuan</label>
                                    <input type="text" name="form" id="form" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('form') }}">
                                    </div>
                    
                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                    <label for="start" class="block text-sm font-medium text-gray-700">Mulai</label>
                                    <input type="date" name="start" value="{{ old('start') }}">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                        <label for="end" class="block text-sm font-medium text-gray-700">Selesai</label>
                                        <input type="date" name="end" value="{{ old('end') }}">
                                    </div>

                                    <input type="checkbox" name="addTeam">
                                    <input type="text" name="teamMember">
                                </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Ajukan</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- jika mendapat undangan join team --}}
                    @elseif($submissionStatus == 2)
                    <div>
                        <form action="/accept-invitation" method="POST">
                            @csrf
                            <button type="submit">Terima</button>
                        </form>
                        <form action="/decline-invitation" method="POST">
                            @csrf
                            <button type="submit">tolak</button>
                        </form>
                    </div>

                    {{-- jika telah menerima undangan tim --}}
                    @elseif($submissionStatus == 4)
                    <div>
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
                    </div>

                    
                    @elseif($submissionStatus == 1 || $submissionStatus == 5 || $submissionStatus == 9 || $submissionStatus == 11 || $submissionStatus == 12)
                    <div>
                        <form action="/cancel-submission" method="POST">
                            @csrf
                            <button type="submit">batalkan pengajuan</button>
                        </form>
                    </div>

                    @elseif($submissionStatus == 10 || $submissionStatus == 13)
                    <div>
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
                    </div>
                    @endif

                </div>
                {{-- Akhir halaman pengajuan --}}

            @else
                {{-- Halaman setelah pengajuan --}}
                @if($submissionStatus >= 14)

                    {{-- Logbook --}}
                    <div>
                        <form action="/input-logbook" method="POST">
                            @csrf
                            <input type="date" name="date">
                            <label for="">Deskripsi kegiatan</label>
                            <input type="text" name="description">
                            <button type="submit">Submit</button>
                        </form>
                        Daftar Logbook
                        <section class="antialiased bg-gray-100 text-gray-600 h-screen px-4" x-data="app">
                            <div class="flex flex-col justify-center h-full">
                                <!-- Table -->
                                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                                    <header class="px-5 py-4 border-b border-gray-100">
                                        <div class="font-semibold text-gray-800">Logbook</div>
                                    </header>
                        
                                    @if($logbooks == Null)
                                    tidak ada
                                    
                                    @else
                                    <div class="overflow-x-auto p-3">
                                        <table class="table-auto w-full">
                                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                                <tr>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">Tanggal</div>
                                                    </th>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">Deskripsi</div>
                                                    </th>
                                                </tr>
                                            </thead>
                        
                                            <tbody class="text-sm divide-y divide-gray-100">
                                                @foreach($logbooks as $logbook)
                                                <tr>
                                                    <td class="p-2">
                                                        <div class="font-medium text-gray-800">
                                                            {{ $logbook->date }}
                                                        </div>
                                                    </td>
                                                    <td class="p-2">
                                                        <div class="text-left font-medium text-green-500">
                                                            {{ $logbook->description }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </section>
                    </div>
                    {{-- Akhir logbook --}}

                    {{-- Jika sudah dapat dospem --}}
                    @if($submissionStatus >= 15) 
                        {{-- Awal Bimbingan --}}
                        <section class="antialiased bg-gray-100 text-gray-600 h-screen px-4">
                            <div class="flex flex-col justify-center h-full">
                                <!-- Table -->
                                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                                    <header class="px-5 py-4 border-b border-gray-100">
                                        <div class="font-semibold text-gray-800">Riwayat bimbingan Bimbingan</div>
                                    </header>
                                    @if($studentMentoringHistory == Null)
                                    tidak ada
                                    
                                    @else
                                    <div class="overflow-x-auto p-3">
                                        <table class="table-auto w-full">
                                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                                <tr>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">Waktu</div>
                                                    </th>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">Keterangan</div>
                                                    </th>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">status</div>
                                                    </th>
                                                </tr>
                                            </thead>
                        
                                            <tbody class="text-sm divide-y divide-gray-100">
                                                @foreach ($studentMentoringHistory as $history)
                                                <tr>
                                                    @if($history->time)
                                                    <td class="p-2">{{ $history->time }}</td>
                                                    @else
                                                    <td class="p-2">-</td>
                                                    @endif
                                                    @if($history->time)
                                                    <td class="p-2">{{ $history->description }}</td>
                                                    @else
                                                    <td class="p-2">-</td>
                                                    @endif
                                                    <td class="p-2">{{ $studentMentoringHistoryStatus[$history->mentoring_status_id - 1]->name }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                    <form action="/add-mentoring-job-training" method="POST">
                                        @csrf
                                        <button type="submit">Ajukan bimbingan</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                        {{-- Akhir bimbingan --}}

                        {{-- Tombol ajukan judul --}}
                        @if($submissionStatus == 15 || $submissionStatus == 17)
                        <form action="/add-job-training-title" method="POST">
                            @csrf
                            <input type="text" name="title">
                            <button type="submit">Ajukan</button>
                        </form>
                        @endif
                        {{-- Akhir ajukan judul --}}

                        {{-- History pengajuan judul --}}
                        <section class="antialiased bg-gray-100 text-gray-600 h-screen px-4">
                            <div class="flex flex-col justify-center h-full">
                                <!-- Table -->
                                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                                    <header class="px-5 py-4 border-b border-gray-100">
                                        <div class="font-semibold text-gray-800">Riwayat pengajuan judul</div>
                                    </header>
                                    @if($studentJobTrainingTitleHistory == Null)
                                    tidak ada
                                    
                                    @else
                                    <div class="overflow-x-auto p-3">
                                        <table class="table-auto w-full">
                                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                                <tr>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">Judul</div>
                                                    </th>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">status</div>
                                                    </th>
                                                </tr>
                                            </thead>
                        
                                            <tbody class="text-sm divide-y divide-gray-100">
                                                @foreach ($studentJobTrainingTitleHistory as $history)
                                                <tr>
                                                    <td class="p-2">{{ $history->title }}</td>
                                                    <td class="p-2">{{ $studentJobTrainingTitleHistoryStatus[$history->job_training_title_status_id-1]->name }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </section>
                        {{-- Akhir history pengajuan judul --}}

                        {{-- Awal laporan --}}
                        <section class="antialiased bg-gray-100 text-gray-600 h-screen px-4">
                            <div class="flex flex-col justify-center h-full">
                                <!-- Table -->
                                <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200">
                                    <header class="px-5 py-4 border-b border-gray-100">
                                        <div class="font-semibold text-gray-800">Riwayat pengajuan revisi laporan</div>
                                    </header>
                                    @if($reportHistory == Null)
                                    tidak ada
                                    
                                    @else
                                    <div class="overflow-x-auto p-3">
                                        <table class="table-auto w-full">
                                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                                <tr>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">Laporan</div>
                                                    </th>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">Deskripsi</div>
                                                    </th>
                                                    <th class="p-2">
                                                        <div class="font-semibold text-left">Status</div>
                                                    </th>
                                                </tr>
                                            </thead>
                        
                                            <tbody class="text-sm divide-y divide-gray-100">
                                                @foreach($reportHistory as $history)
                                                    <tr>
                                                        <td class="p">Revisi ke-{{ $loop->iteration }}</td>
                                                        <td class="p-2">{{ $history->description }}</td>
                                                        <td class="p-2">{{ $reportHistoryStatus[$history->submission_report_status_id - 1]->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                Ajukan laporan
                                <form action="/addReport" method="POST">
                                    @csrf
                                    <input type="text" name="report">
                                    <button type="submit">Kirim</button>
                                </form>
                            </div>
                        </section>
                        {{-- Akhir laporan --}}

                        {{-- Pengajuan Berkas Pra seminar --}}
                        <form action="/add-before-presentation" method="POST">
                            Pengajuan berkas sebelum seminar
                            @csrf
                            <input type="text" name="company">
                            <input type="text" name="form">
                            <input type="text" name="logbook">
                            <button type="submit">Submit</button>
                        </form>
                        {{-- Akhir pengajuan berkas pra seminar --}}
                    @endif

                @endif
                {{-- Akhir halaman setelah pengajuan --}}
            @endif
            
        @endif
            {{-- Akhir halaman mahasiswa --}}
    </div>
</x-app-layout>