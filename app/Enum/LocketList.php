<?php

namespace App\Enum;

enum LocketList: string
{
    case PENDAFTARAN = 'A';
    case LANSIA = 'B';
    case LABORATE = 'C';
    case FARMASI = 'D';

    // 🔹 Ambil label/title
    public function title(): string
    {
        return match ($this) {
            self::PENDAFTARAN => 'Pendaftaran',
            self::LABORATE => 'Laborate',
            self::LANSIA => 'Lansia',
            self::FARMASI => 'Farmasi',
        };
    }

    // 🔹 Ambil icon emoji
    public function icon(): string
    {
        return match ($this) {
            self::PENDAFTARAN => '📝',
            self::LABORATE => '🔬',
            self::LANSIA => '👵',
            self::FARMASI => '💊',
        };
    }

    // 🔹 Ambil warna utama
    public function color(): string
    {
        return match ($this) {
            self::PENDAFTARAN => 'yellow',
            self::LABORATE => 'blue',
            self::LANSIA => 'pink',
            self::FARMASI => 'green',
        };
    }

    // 🔹 Ambil Tailwind color classes
    public function colorClasses(): string
    {
        return match ($this) {
            self::PENDAFTARAN => 'bg-yellow-400 hover:bg-yellow-300 text-yellow-800',
            self::LABORATE => 'bg-blue-400 hover:bg-blue-300 text-blue-800',
            self::LANSIA => 'bg-pink-400 hover:bg-pink-300 text-pink-800',
            self::FARMASI => 'bg-green-400 hover:bg-green-300 text-green-800',
        };
    }

    // 🔹 Ambil data dalam format array (untuk view)
    public function asMenuList(): array
    {
        return [
            'type' => $this,
            'color' => $this->color(),
            'icon' => $this->icon(),
            'title' => $this->title(),
            'colorClasses' => $this->colorClasses(),
        ];
    }

    // 🔹 Ambil semua menu sekaligus
    public static function menuList(): array
    {
        return array_map(fn($case) => $case->asMenuList(), self::cases());
    }

    public static function toArray()
    {
        $values = [];

        foreach (self::cases() as $props) {
            array_push($values, $props->value);
        }

        return $values;
    }

    public static function allIntoString()
    {
        return implode(',', self::toArray());
    }

    public function soundCategory(): string
    {
        # DIPISAH untuk kebutuhan kedepan sound jika ada penambahan kategori loket
        return match ($this) {
            self::PENDAFTARAN => 'loket',
            self::LANSIA => 'loket',
            self::LABORATE => 'loket',
            self::FARMASI => 'ruang_farmasi',
        };
    }

    public function hasLocketCode(): bool
    {
        return match ($this) {
            self::PENDAFTARAN, self::LANSIA, self::LABORATE => true,
            self::FARMASI => false,
        };
    }
}
