<?php
namespace Database\Seeders;

use Database\Seeders\App\NotificationChannelTableSeeder;
use Database\Seeders\App\NotificationEventTableSeeder;
use Database\Seeders\App\NotificationSettingsSeeder;
use Database\Seeders\App\NotificationTemplateSeeder;
use Database\Seeders\App\SettingTableSeeder;
use Database\Seeders\Auth\PermissionRoleTableSeeder;
use Database\Seeders\Auth\PermissionTableSeeder;
use Database\Seeders\Auth\TypeSeeder;
use Database\Seeders\Auth\UserRoleTableSeeder;
use Database\Seeders\Auth\UserTableSeeder;
use Database\Seeders\Builder\CustomFieldTypeSeeder;
use Database\Seeders\Status\StatusSeeder;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\CRM\Stage\DefaultStagesTableSeeder;
use Database\Seeders\CRM\Deal\LostReasonsTableSeeder;
use Database\Seeders\CRM\Contact\ContactTypesTableSeeder;
use Database\Seeders\CRM\priorities\PrioritiesTableSeeder;
use Database\Seeders\CRM\Activity\ActivityTypesTableSeeder;
use Database\Seeders\CRM\Contact\PhoneEmailTypeSeeder;
use Database\Seeders\CRM\EmailTemplate\EmailTemplateTableSeed;
use Database\Seeders\CRM\OpportunityCategory\OpportunityCategoryTableSeeder;
use Database\Seeders\CRM\Template\TemplateTableSeeder;
use Database\Seeders\CRM\Companies\CompaniesTableSeeder;
use App\Models\CRM\JobPost\JobPost;
use Database\Seeders\CRM\Country\CountrySeeder;
use Database\Seeders\CRM\GeneralSettings\GeneralSettingTableSeeder;
use Database\Seeders\CRM\HowWorks\HowWorkTableSeeder;
use Database\Seeders\CRM\Services\ServicesTableSeeder;
use Database\Seeders\CRM\Socials\SocialLinkTableSeeder;
use Database\Seeders\CRM\Testimonials\TestimonialsTableSeeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\Post;
use App\Models\Role;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();
        $this->disableForeignKeys();

        JobPost::factory(50)->create();
        $this->call(OpportunityCategoryTableSeeder::class);
        $this->call(EmailTemplateTableSeed::class);
        $this->call(GeneralSettingTableSeeder::class);
        $this->call(TestimonialsTableSeeder::class);
        $this->call(SocialLinkTableSeeder::class);
        $this->call(HowWorkTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(PrioritiesTableSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(CustomFieldTypeSeeder::class);
        $this->call(NotificationChannelTableSeeder::class);
        $this->call(NotificationEventTableSeeder::class);
        $this->call(NotificationSettingsSeeder::class);
        $this->call(NotificationTemplateSeeder::class);

        // /*
        //  * CRM Seeders
        // */
        $this->call(DefaultStagesTableSeeder::class);
        $this->call(LostReasonsTableSeeder::class);
        $this->call(ContactTypesTableSeeder::class);
        $this->call(ActivityTypesTableSeeder::class);
        $this->call(PhoneEmailTypeSeeder::class);
        $this->call(TemplateTableSeeder::class);
        $this->call(CountrySeeder::class);
        $this->enableForeignKeys();
        Model::reguard();
    }

} Category::truncate();

       
        Company::factory(100)->create();
        Job::factory(200)->create();
        Post::factory(50)->create();
        Testimonial::factory(1)->create();

        $categories = [
            'Healthcare',
            'Medical Services',
            'Technology',
            'Software Development',
            'Education',
            'Engineering',
            'Creative and Design',
            'Research and Development',
            'Hospitality and Tourism',
            'Business and Management',
            'Finance and Accounting',
            'Sales and Marketing',
            'Legal Services',
            'Media and Communication',
            'Manufacturing and Production',
            'Transportation and Logistics',
            'Environmental Services',
            'Social Services',
            'Agriculture and Farming',
            'Construction and Skilled Trades'
        ];
        
        
        

        foreach($categories as $category){
            Category::create(
                [
                'name'=> $category, 
                'slug'=> Str::slug($category),
                'status'=> '1'
                ]
            );
        }

        Role::truncate();
        $adminRole = Role::create(['name'=> 'admin']);
        $admin = User::create([
            'name'=> 'admin',
            'email'=> 'nababurdev@gmail.com',
            'user_type'=> 'admin',
            'status'=> '1',
            'password'=> bcrypt('nababurdev123'),
            'email_verified_at'=> NOW()
        ]);

        $admin->roles()->attach($adminRole);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


