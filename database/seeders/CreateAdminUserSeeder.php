<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'phone' => '0987654321',
            'password' => bcrypt('password'),
            'role' => "admin",
            'address' => "",
            'cnic' => "",
            'status' => "",
        ]);
        
        $role = Role::create(['name' => 'Admin']);
         
        $permissions = Permission::pluck('id','id')->all();
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);   

        // User::create([
        //     'name' => 'Agent',
        //     'email' => "agent@gmail.com",
        //     'password' => bcrypt('password'),
        //     'phone' => '0987654321',
        //     'role' => "agent"
        // ]);
    }
}
