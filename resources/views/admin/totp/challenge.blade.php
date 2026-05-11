<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xác thực hai lớp</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="mx-auto flex min-h-screen w-full max-w-md items-center px-4 py-10">
        <div class="w-full rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h1 class="text-xl font-semibold">Xác thực 2 lớp</h1>
            <p class="mt-2 text-sm text-slate-600">
                Mở ứng dụng Google Authenticator (hoặc app TOTP tương thích) và nhập mã 6 số để tiếp tục vào trang quản trị.
            </p>

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.totp.verify') }}" method="post" class="mt-5 space-y-4">
                @csrf
                <label for="code" class="block text-sm font-medium text-slate-700">Mã xác thực</label>
                <input
                    id="code"
                    name="code"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    maxlength="6"
                    autocomplete="one-time-code"
                    placeholder="123456"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 tracking-[0.2em] outline-none ring-amber-500 focus:ring-2"
                    required
                >
                <label class="flex items-start gap-2 text-sm text-slate-700">
                    <input type="checkbox" name="trust_device" value="1" class="mt-1 rounded border-slate-300" @checked($trustDeviceDefault)>
                    <span>Tin cậy thiết bị này trong {{ $trustedDeviceDays }} ngày.</span>
                </label>
                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-lg bg-amber-500 px-4 py-2 font-medium text-slate-900 transition hover:bg-amber-400"
                >
                    Xác thực và tiếp tục
                </button>
            </form>

            <div class="mt-5 border-t border-slate-200 pt-4">
                <p class="text-sm font-medium text-slate-700">Hoặc dùng mã khôi phục</p>
                <form action="{{ route('admin.totp.recovery') }}" method="post" class="mt-3 space-y-3">
                    @csrf
                    <input
                        id="recovery_code"
                        name="recovery_code"
                        maxlength="32"
                        placeholder="ABCD-EFGH"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 uppercase outline-none ring-amber-500 focus:ring-2"
                    >
                    <label class="flex items-start gap-2 text-sm text-slate-700">
                        <input type="checkbox" name="trust_device" value="1" class="mt-1 rounded border-slate-300" @checked($trustDeviceDefault)>
                        <span>Tin cậy thiết bị này trong {{ $trustedDeviceDays }} ngày.</span>
                    </label>
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 font-medium text-slate-800 transition hover:bg-slate-50"
                    >
                        Dùng mã khôi phục
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
