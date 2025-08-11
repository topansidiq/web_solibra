<?php

if (!function_exists('generateNumericOTP')) {
    function generateNumericOTP(int $length = 6): string
    {
        if ($length <= 0) {
            throw new InvalidArgumentException("OTP length must be a positive integer");
        }

        $otp = "";
        for ($i = 0; $i < $length; $i++) {
            $otp .= random_int(0, 9); // aman tanpa modulo bias
        }

        return $otp;
    }
}

if (!function_exists('formattedPhoneNumberToUs62')) {
    function formattedPhoneNumberToUs62($phone_number)
    {
        $formattedPhoneNumber = preg_replace('/^0/', '62', $phone_number) . '@c.us';

        return $formattedPhoneNumber;
    }
}
