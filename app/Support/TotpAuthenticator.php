<?php

namespace App\Support;

class TotpAuthenticator
{
    public function generateSecret(int $length = 32): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $bytes = random_bytes($length);
        $secret = '';

        for ($i = 0; $i < $length; $i++) {
            $secret .= $alphabet[ord($bytes[$i]) % strlen($alphabet)];
        }

        return $secret;
    }

    public function verifyCode(string $secret, string $code, int $window = 1, int $period = 30): bool
    {
        if (! preg_match('/^\d{6}$/', $code)) {
            return false;
        }

        $timeSlice = (int) floor(time() / $period);
        for ($i = -$window; $i <= $window; $i++) {
            if (hash_equals($this->at($secret, $timeSlice + $i), $code)) {
                return true;
            }
        }

        return false;
    }

    public function makeOtpAuthUri(string $secret, string $accountName, string $issuer): string
    {
        $label = rawurlencode($issuer.':'.$accountName);
        $issuerParam = rawurlencode($issuer);
        $secretParam = rawurlencode($secret);

        return "otpauth://totp/{$label}?secret={$secretParam}&issuer={$issuerParam}&algorithm=SHA1&digits=6&period=30";
    }

    protected function at(string $secret, int $counter): string
    {
        $binarySecret = $this->base32Decode($secret);
        if ($binarySecret === '') {
            return '000000';
        }

        $binaryCounter = pack('N*', 0).pack('N*', $counter);
        $hash = hash_hmac('sha1', $binaryCounter, $binarySecret, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $truncated =
            ((ord($hash[$offset]) & 0x7F) << 24)
            | ((ord($hash[$offset + 1]) & 0xFF) << 16)
            | ((ord($hash[$offset + 2]) & 0xFF) << 8)
            | (ord($hash[$offset + 3]) & 0xFF);

        return str_pad((string) ($truncated % 1000000), 6, '0', STR_PAD_LEFT);
    }

    protected function base32Decode(string $secret): string
    {
        $secret = strtoupper(preg_replace('/[^A-Z2-7]/', '', $secret) ?? '');
        if ($secret === '') {
            return '';
        }

        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $bits = '';
        $decoded = '';

        foreach (str_split($secret) as $char) {
            $position = strpos($alphabet, $char);
            if ($position === false) {
                return '';
            }

            $bits .= str_pad(decbin($position), 5, '0', STR_PAD_LEFT);
        }

        $chunks = str_split($bits, 8);
        foreach ($chunks as $chunk) {
            if (strlen($chunk) < 8) {
                continue;
            }

            $decoded .= chr(bindec($chunk));
        }

        return $decoded;
    }
}
