<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roleUser = new Role();
        $roleUser->roleName = "user";
        $roleUser->save();

        $roleDriver = new Role();
        $roleDriver->roleName = "driver";
        $roleDriver->save();

        $roleAdmin = new Role();
        $roleAdmin->roleName = "admin";
        $roleAdmin->save();


        $user = new User();
        $user->userName = "karimkayali";
        $user->email = "karimkayali@gmail.com";
        $user->password = "karim";
        $user->phoneNumber = "03521234";
        $user->points = 1000;
        $user->role_id = $roleUser->id;
        $user->save();

        $user = new User();
        $user->userName = "aliibrahim";
        $user->email = "aliibrahim@gmail.com";
        $user->password = "ali";
        $user->phoneNumber = "03621234";
        $user->points = 0;
        $user->role_id = $roleUser->id;
        $user->save();

        $userAdmin = new User();
        $userAdmin->id = 3;
        $userAdmin->userName = "nadimjreich";
        $userAdmin->email = "nj.nadimjreich@gmail.com";
        $userAdmin->password = "nadim";
        $userAdmin->phoneNumber = "03522341";
        $userAdmin->role_id = $roleAdmin->id;
        $userAdmin->save();

        $userDriver = new User();
        $userDriver->userName = "raminsouli";
        $userDriver->email = "raminsouli@gmail.com";
        $userDriver->password = "rami";
        $userDriver->phoneNumber = "035272134";
        $userDriver->vehicleType = "Car";
        $userDriver->vehicleModel = "Kia Picanto";
        $userDriver->plateNumber = "LEB2323567";
        $userDriver->startShift = '08:30:00'; // 8:30 AM;
        $userDriver->endShift = '22:30:00'; // 3:30 PM
        $userDriver->gotRegistered = 'accepted';
        $userDriver->role_id = $roleDriver->id;
        $userDriver->save();


        $userDriver = new User();
        $userDriver->userName = "louisajanbeih";
        $userDriver->email = "louisajanbeih@gmail.com";
        $userDriver->password = "louisa";
        $userDriver->phoneNumber = "01521241";
        $userDriver->vehicleType = "Motorcycle";
        $userDriver->vehicleModel = "Vespa";
        $userDriver->plateNumber = "LEB345674";
        $userDriver->startShift = '09:30:00';
        $userDriver->endShift = '15:30:00';
        $userDriver->gotRegistered = 'accepted';
        $userDriver->role_id = $roleDriver->id;
        $userDriver->save();

        $userDriver = new User();
        $userDriver->userName = "johndoe";
        $userDriver->email = "johndoe@gmail.com";
        $userDriver->password = "john";
        $userDriver->phoneNumber = "03521241";
        $userDriver->vehicleType = "Motorcycle";
        $userDriver->vehicleModel = "Vespa";
        $userDriver->plateNumber = "LEB4345674";
        $userDriver->startShift = '09:30:00';
        $userDriver->endShift = '22:30:00';
        $userDriver->gotRegistered = 'pending';
        $userDriver->role_id = $roleDriver->id;
        $userDriver->save();

        $userDriver = new User();
        $userDriver->userName = "nancyramadan";
        $userDriver->email = "nancyramadan@gmail.com";
        $userDriver->password = "nancy";
        $userDriver->phoneNumber = "02521241";
        $userDriver->vehicleType = "Car";
        $userDriver->vehicleModel = "Vespa";
        $userDriver->plateNumber = "LEB4945674";
        $userDriver->startShift = '09:30:00';
        $userDriver->endShift = '22:30:00';
        $userDriver->gotRegistered = 'rejected';
        $userDriver->role_id = $roleDriver->id;
        $userDriver->save();

        $user = new User();
        $user->userName = "ray";
        $user->email = "ray@gmail.com";
        $user->password = "ray";
        $user->phoneNumber = "03720761";
        $user->points = 0;
        $user->role_id = $roleAdmin->id;
        $user->save();
    }
}
