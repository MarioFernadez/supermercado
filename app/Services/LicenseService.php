<?php

namespace App\Services;

use App\Models\User;
use App\Models\CashRegister;
use App\Models\StoreSetting;

class LicenseService
{
    public static function getMaxUsers(): int
    {
        return (int) StoreSetting::where('key', 'license_max_users')->first()?->value ?: 3;
    }

    public static function getMaxCashRegisters(): int
    {
        return (int) StoreSetting::where('key', 'license_max_cash_registers')->first()?->value ?: 1;
    }

    public static function getTierName(): string
    {
        return StoreSetting::where('key', 'license_tier_name')->first()?->value ?: 'Básico';
    }

    public static function isEcommerceEnabled(): bool
    {
        $setting = StoreSetting::where('key', 'license_ecommerce_enabled')->first();
        return $setting ? $setting->value === '1' : true;
    }

    public static function getCurrentUserCount(): int
    {
        return User::where('email', '!=', config('services.developer.email'))->count();
    }

    public static function getCurrentCashRegisterCount(): int
    {
        return CashRegister::count();
    }

    public static function canAddUser(): bool
    {
        return self::getCurrentUserCount() < self::getMaxUsers();
    }

    public static function canAddCashRegister(): bool
    {
        return self::getCurrentCashRegisterCount() < self::getMaxCashRegisters();
    }

    public static function getUsageStats(): array
    {
        return [
            'tier' => self::getTierName(),
            'users' => [
                'current' => self::getCurrentUserCount(),
                'max' => self::getMaxUsers(),
                'available' => max(0, self::getMaxUsers() - self::getCurrentUserCount()),
            ],
            'cash_registers' => [
                'current' => self::getCurrentCashRegisterCount(),
                'max' => self::getMaxCashRegisters(),
                'available' => max(0, self::getMaxCashRegisters() - self::getCurrentCashRegisterCount()),
            ],
        ];
    }
}
