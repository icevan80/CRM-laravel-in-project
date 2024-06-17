<?php

namespace App\Http\Livewire\Other;

//use App\Models\Category;
//use App\Models\Location;
//use App\Models\Master;
//use App\Models\Permission;
//use App\Models\Role;
//use App\Models\Service;
//use App\Models\Subcategory;
//use App\Models\User;
//use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.other.home');
    }

    public function fillBD()
    {

        /*Permission::create([
            'name' => 'Manage Appointment'
        ]);
        Permission::create([
            'name' => 'Create Appointment'
        ]);
        Permission::create([
            'name' => 'Edit Appointment'
        ]);
        Permission::create([
            'name' => 'Edit date Appointment'
        ]);
        Permission::create([
            'name' => 'Edit other Appointment'
        ]);
        Permission::create([
            'name' => 'Delete Appointment'
        ]);
        Permission::create([
            'name' => 'Edit Translations'
        ]);
        Permission::create([
            'name' => 'Edit Roles'
        ]);
        Permission::create([
            'name' => 'Edit Permissions'
        ]);
        Permission::create([
            'name' => 'Manage Users'
        ]);
        Permission::create([
            'name' => 'Manage Locations'
        ]);
        Permission::create([
            'name' => 'Manage Services'
        ]);
        Permission::create([
            'name' => 'Manage Categories'
        ]);
        Permission::create([
            'name' => 'Manage Deals'
        ]);
        Permission::create([
            'name' => 'Edit Users'
        ]);
        Permission::create([
            'name' => 'Edit Locations'
        ]);
        Permission::create([
            'name' => 'Edit Services'
        ]);
        Permission::create([
            'name' => 'Edit categories'
        ]);
        Permission::create([
            'name' => 'Edit deals'
        ]);
        Permission::create([
            'name' => 'New style access'
        ]);

//        Role::create([
//            'name' => 'Admin',
//            'default_permissions' => json_encode(array()),
//        ]);
//        Role::create([
//            'name' => 'Employee',
//            'default_permissions' => json_encode(array()),
//        ]);
//        Role::create([
//            'name' => 'Customer',
//            'default_permissions' => json_encode(array()),
//        ]);
//        Role::create([
//            'name' => 'Partner',
//            'default_permissions' => json_encode(array()),
//        ]);
//        Role::create([
//            'name' => 'Master',
//            'default_permissions' => json_encode(array()),
//        ]);

        $permissions = Permission::all();
        $adminRole = Role::getRole('Admin');

        foreach ($permissions as $permission) {
            $adminRole->addPermission($permission);
        }

        Location::create([
            'name' => 'I.N.Project',
            'address' => 'г. Новосибирск, ул. Бориса Богаткова, д. 208',
            'telephone_number' => '79999999999',
            'operate' => true,
        ]);

        auth()->user()->updateRole(Role::getRole('Admin'));

        $master1 = User::create([
            'name' => 'Master1',
            'email' => 'master1@salonbliss.com',
            'password' => Hash::make('masterpass'),
            'phone_number' => '1234567891',
            'role_id' => Role::getRole('Customer')->id,
        ]);
        $master2 = User::create([
            'name' => 'Master2',
            'email' => 'master2@salonbliss.com',
            'password' => Hash::make('masterpass'),
            'phone_number' => '1234567892',
            'role_id' => Role::getRole('Customer')->id,
        ]);

        $master1->updateRole(Role::getRole('Master'));
        $master2->updateRole(Role::getRole('Master'));

        Category::create([
            'name' => 'Аппаратный массаж для коррекции фигуры',
        ]);

        Category::create([
            'name' => 'Маникюр',
        ]);

        Category::create([
            'name' => 'Педикюр',
        ]);

        Category::create([
            'name' => 'Депиляция',
        ]);

        Category::create([
            'name' => 'Наращивание',
        ]);

        Category::create([
            'name' => 'Подология',
        ]);

        Category::create([
            'name' => 'Ламинирование',
        ]);

        Category::create([
            'name' => 'Ламинирование и ботокс',
        ]);

        Category::create([
            'name' => 'Коррекция',
        ]);

        Subcategory::create([
            'name' => 'женский',
            'category_id' => Category::getCategory('Маникюр')->id,
        ]);

        Subcategory::create([
            'name' => 'женский',
            'category_id' => Category::getCategory('Педикюр')->id,
        ]);

        Subcategory::create([
            'name' => 'женская',
            'category_id' => Category::getCategory('Депиляция')->id,
        ]);

        Subcategory::create([
            'name' => 'Комплексы женской депиляции',
            'presentation_name' => 'Комплексы женской депиляции',
            'category_id' => Category::getCategory('Депиляция')->id,
        ]);

        Subcategory::create([
            'name' => 'Ногти',
            'presentation_name' => 'Наращивание ногтей',
            'category_id' => Category::getCategory('Наращивание')->id,
        ]);

        Subcategory::create([
            'name' => 'мужской',
            'category_id' => Category::getCategory('Маникюр')->id,
        ]);

        Subcategory::create([
            'name' => 'мужской',
            'category_id' => Category::getCategory('Педикюр')->id,
        ]);

        Subcategory::create([
            'name' => 'мужская',
            'category_id' => Category::getCategory('Депиляция')->id,
        ]);

        Subcategory::create([
            'name' => 'Ресницы',
            'presentation_name' => 'Наращивание ресниц',
            'category_id' => Category::getCategory('Наращивание')->id,
        ]);

        Subcategory::create([
            'name' => 'Ресницы',
            'presentation_name' => 'Ламинирование ресниц',
            'category_id' => Category::getCategory('Ламинирование')->id,
        ]);

        Subcategory::create([
            'name' => 'Ресницы',
            'presentation_name' => 'Ламинирование и ботокс ресниц',
            'category_id' => Category::getCategory('Ламинирование и ботокс')->id,
        ]);

        Subcategory::create([
            'name' => 'Брови',
            'presentation_name' => 'Коррекция бровей',
            'category_id' => Category::getCategory('Коррекция')->id,
        ]);

        $service = array();

        $category = Category::getCategory('Аппаратный массаж для коррекции фигуры');
        $service[] = Service::create([
            'name' => 'Массаж LPG',
            'price' => 1000,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 45,
            'category_id' => $category->id,
            'subcategory_id' => null,
        ]);
        $service[] = Service::create([
            'name' => 'Массаж LPG. Пробный сеанс',
            'price' => 799,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 30,
            'category_id' => $category->id,
            'subcategory_id' => null,
        ]);
        $service[] = Service::create([
            'name' => 'Биофотон',
            'price' => 699,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 20,
            'category_id' => $category->id,
            'subcategory_id' => null,
        ]);

        $category = Category::getCategory('Маникюр');
        $subcategory = $category->getSubcategory('женский');
        $service[] = Service::create([
            'name' => 'Дизайн',
            'price' => 50,
            'max_price' => 1000,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Снятие чужого гель-лака',
            'price' => 300,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Маникюр (Топ-мастер)',
            'price' => 900,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Педикюр');
        $subcategory = $category->getSubcategory('женский');
        $service[] = Service::create([
            'name' => 'Обработка пальчиков',
            'price' => 1000,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Педикюр полный',
            'price' => 2000,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Обработка трещин',
            'price' => 500,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Депиляция');
        $subcategory = $category->getSubcategory('женская');
        $service[] = Service::create([
            'name' => 'Руки до локтя',
            'price' => 600,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Подмышки',
            'price' => 400,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Глубокое бикини',
            'price' => 1200,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Депиляция');
        $subcategory = $category->getSubcategory('Комплексы женской депиляции');
        $service[] = Service::create([
            'name' => 'Подмышки + глубокое бикини + ноги до колена',
            'price' => 1900,
            'max_price' => 2100,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Наращивание');
        $subcategory = $category->getSubcategory('Ногти');
        $service[] = Service::create([
            'name' => 'Наращивание ногтей',
            'price' => 2300,
            'max_price' => 4000,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Маникюр');
        $subcategory = $category->getSubcategory('мужской');
        $service[] = Service::create([
            'name' => 'Маникюр (мужской)',
            'price' => 900,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Педикюр');
        $subcategory = $category->getSubcategory('женский');
        $service[] = Service::create([
            'name' => 'Мужской педикюр',
            'price' => 2400,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Обработка трещин',
            'price' => 500,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Вросший ноготь',
            'price' => 500,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Депиляция');
        $subcategory = $category->getSubcategory('мужская');
        $service[] = Service::create([
            'name' => 'Нос',
            'price' => 300,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Шея',
            'price' => 500,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Грудь',
            'price' => 700,
            'max_price' => 900,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Подология');
        $service[] = Service::create([
            'name' => 'Удаление мозолей',
            'price' => 300,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 45,
            'category_id' => $category->id,
            'subcategory_id' => null,
        ]);
        $service[] = Service::create([
            'name' => 'Вросший ноготь',
            'price' => 500,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 30,
            'category_id' => $category->id,
            'subcategory_id' => null,
        ]);

        $category = Category::getCategory('Наращивание');
        $subcategory = $category->getSubcategory('Ресницы');
        $service[] = Service::create([
            'name' => 'Наращивание ресниц. Классика.',
            'price' => 1600,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Наращивание ресниц 2D',
            'price' => 2000,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Цветные лучики',
            'price' => 200,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Ламинирование');
        $subcategory = $category->getSubcategory('Ресницы');
        $service[] = Service::create([
            'name' => 'Ламинирование ресниц',
            'price' => 1600,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Ламинирование и ботокс');
        $subcategory = $category->getSubcategory('Ресницы');
        $service[] = Service::create([
            'name' => 'Ламинирование и ботокс ресниц',
            'price' => 2000,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);

        $category = Category::getCategory('Коррекция');
        $subcategory = $category->getSubcategory('Брови');
        $service[] = Service::create([
            'name' => 'Коррекция бровей',
            'price' => 600,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);
        $service[] = Service::create([
            'name' => 'Коррекция + окрашивание бровей',
            'price' => 1100,
            'max_price' => null,
            'notes' => 'Null notes, need fell',
            'type' => 'personal',
            'duration_minutes' => 60,
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
        ]);*/

//        $masters = Master::all();
//
//        $service = Service::all();
//
//        foreach ($service as $item) {
//            $randNum = rand(0, 2);
//            if ($randNum == 0) {
//                $item->masters()->attach(array(1));
//            } else if ($randNum == 1) {
//                $item->masters()->attach(array(2));
//            } else if ($randNum == 2) {
//                $item->masters()->attach(array(1, 2));
//            }
//        }

    }
}
