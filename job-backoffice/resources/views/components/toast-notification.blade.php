<!-- Success Message -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
            class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded"
            role="alert">
            {{ session('success') }}
        </div>
    @endif
