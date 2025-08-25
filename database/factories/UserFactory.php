<?php

namespace Database\Factories;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = \Faker\Factory::create('id_ID');
        $phone_verified = fake()->randomElement([true, false]);
        $expired_date = Carbon::today()->addDays(89);
        $gender = fake()->randomElement(['female', 'male']);
        $birth_date = $this->faker->dateTimeBetween('-60 years', '-18 years');
        $birth = fake('id_ID')->streetAddress() . $birth_date->format('d-m-Y');
        $id_type = fake()->randomElement(['KTP', 'Passport', 'Kartu Pelajar']);
        $id_number = null;
        $education = $this->faker->randomElement(['SD', 'SMA/SMK', 'SMP', 'S1', 'Diploma III', 'Diploma IV', 'S2', 'S3', 'Magister Terapan', 'Akademisi', 'Sertifikasi']);
        $class_department = null;
        if ($education == "Diploma III" || $education == "S1" || $education == "S2" || $education == "S3" || $education == "Diploma IV") {
            $class_department = $this->faker->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknik Elektro',
                'Manajemen',
                'Akuntansi',
                'Pendidikan Matematika',
                'Hukum',
                'Ilmu Komunikasi',
                'Agroteknologi',
                'Kedokteran',
                'Farmasi',
                'Teknik Sipil',
                'Arsitektur',
                'Bahasa Inggris',
            ]);
        } else {
            $class_department = "";
        }

        switch ($id_type) {
            case "KTP":
                $id_number = $this->faker->unique()->numerify('130############');
                break;
            case "Passport":
                $id_number = fake()->randomElement(['A', 'P', 'C']) . $this->faker->unique()->numerify('########');
                break;
            case "Kartu Pelajar":
                $id_number = fake()->unique()->numerify('##########');
                break;
        }


        return [

            'name' => $faker->name($gender),
            'role' => fake()->randomElement(['admin', 'librarian', 'member']),
            'phone_number' => fake()->unique()->numerify('08#########'),
            'email' => fake()->unique()->safeEmail(),

            'is_phone_verified' => $phone_verified,
            'member_status' => $phone_verified ? 'active' : 'new',
            'status_account' => fake()->randomElement(['active', 'inactive', 'suspended']),
            'expired_date' => $phone_verified ? $expired_date->addDays(276) : $expired_date,

            'gender' => $gender,
            'birth_date' => $birth,
            'age' => Carbon::parse($birth_date)->age,
            'id_type' => $id_type,
            'id_number' => $id_number,
            'address' => $faker->address(),
            'regency' => fake()->streetName(),
            'province' => $faker->randomElement(['Sumatera Barat', 'Sumatera Utara', 'Riau', 'Jambi', 'DKI Jakarta', 'Jawa Barat', 'Banten']),
            'jobs' => $this->faker->jobTitle(),
            'education' => $education,
            'class_department' => $class_department,
            'profile_picture' => 'profile_picture/' . $id_number . '.jpg',

            'email_verified_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
