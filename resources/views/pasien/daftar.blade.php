<x-layouts.app title="Daftar Poli">

    <div class="flex items-center justify-center px-4">
        <div class="w-full max-w-3xl">
            <div class="card bg-base-100 shadow">
                <div class="card-body">

                    <h2 class="text-2xl font-bold text-center mb-6">
                        🏥 Pendaftaran Poli
                    </h2>

                    {{-- Toast Success --}}
                    @if (session('message'))
                        <div id="toastSuccess" class="toast toast-top toast-end z-50">
                            <div class="alert alert-success shadow-lg">
                                <span> {{ session('message') }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- Error --}}
                    @if ($errors->any())
                        <div class="alert alert-error mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_pasien" value="{{ $user->id }}">

                        {{-- Nomor RM --}}
                        <div class="mb-4">
                            <label class="font-semibold block mb-1">
                                Nomor Rekam Medis
                            </label>

                            <input type="text" value="{{ $user->no_rm }}"
                                class="w-full border-2 rounded-lg p-2 bg-gray-100" disabled>
                        </div>

                        {{-- Pilih Poli --}}
                        <div class="mb-4">
                            <label class="font-semibold block mb-1">
                                Pilih Poli
                            </label>

                            <select name="id_poli" id="poliSelect" class="w-full border-2 rounded-lg p-2">
                                <option value="">-- Pilih Poli --</option>
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}" {{ old('id_poli') == $poli->id ? 'selected' : '' }}>
                                        {{ $poli->nama_poli }}
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        {{-- Pilih Jadwal --}}
                        <div class="mb-4">
                            <label class="font-semibold block mb-1">
                                Pilih Jadwal Periksa
                            </label>

                            <select name="id_jadwal" id="jadwalSelect" class="w-full border-2 rounded-lg p-2" disabled>
                                <option value="">-- Pilih Poli Terlebih Dahulu --</option>
                            </select>
                        </div>

                        {{-- Keluhan --}}
                        <div class="mb-6">
                            <label class="font-semibold block mb-1">
                                Keluhan
                            </label>
                            <textarea name="keluhan" rows="3" class="w-full border-2 rounded-lg p-2" placeholder="Tulis keluhan anda...">{{ old('keluhan') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition">
                                Daftar Poli
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const poliSelect = document.getElementById("poliSelect");
                const jadwalSelect = document.getElementById("jadwalSelect");

                const allJadwals = [
                    @foreach ($jadwals as $jadwal)
                        {
                            id: "{{ $jadwal->id }}",
                            poliId: "{{ $jadwal->dokter->id_poli ?? '' }}",
                            text: "{{ $jadwal->hari }} ({{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}) - Dr. {{ $jadwal->dokter->nama ?? '--' }}"
                        },
                    @endforeach
                ];

                const selectedJadwalOld = "{{ old('id_jadwal') }}";

                function updateJadwalOptions() {
                    const poliId = poliSelect.value;
                    jadwalSelect.innerHTML = "";

                    if (!poliId) {
                        const defaultOpt = document.createElement("option");
                        defaultOpt.value = "";
                        defaultOpt.textContent = "-- Pilih Poli Terlebih Dahulu --";
                        jadwalSelect.appendChild(defaultOpt);
                        jadwalSelect.disabled = true;
                        return;
                    }

                    const filtered = allJadwals.filter(j => String(j.poliId) === String(poliId));

                    if (filtered.length === 0) {
                        const emptyOpt = document.createElement("option");
                        emptyOpt.value = "";
                        emptyOpt.textContent = "-- Tidak ada jadwal tersedia untuk poli ini --";
                        jadwalSelect.appendChild(emptyOpt);
                        jadwalSelect.disabled = true;
                        return;
                    }

                    const defaultOpt = document.createElement("option");
                    defaultOpt.value = "";
                    defaultOpt.textContent = "-- Pilih Jadwal --";
                    jadwalSelect.appendChild(defaultOpt);

                    filtered.forEach(j => {
                        const opt = document.createElement("option");
                        opt.value = j.id;
                        opt.textContent = j.text;
                        if (String(j.id) === String(selectedJadwalOld)) {
                            opt.selected = true;
                        }
                        jadwalSelect.appendChild(opt);
                    });

                    jadwalSelect.disabled = false;
                }

                poliSelect.addEventListener("change", updateJadwalOptions);

                // Run on initial load in case a poli is already selected
                if (poliSelect.value) {
                    updateJadwalOptions();
                }
            });
        </script>
    @endpush
</x-layouts.app>
