<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    use HasFactory;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
    protected $models = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    //for tinker auto random uploading
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'avatar' => 'https://via.placeholder.com/150',
            'email' => $this->faker->unique()->safeEmail,
            'staffname' => '0',
            'vcode' => $this->faker->unique(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_admin' => 0,
            'approvestatus' => 1,

        ];
    }

    public function definitionMessage()
    {
        do{
            $from = rand(1,10);
            $to = rand(1,10);
            $is_read = rand(0,1);
        } while($from==$to);

        return [
            'from' => $from,
            'to' => $to,
            'message' =>$this->faker->sentence,
            'is_read' => $is_read,
        ];
    }

}
