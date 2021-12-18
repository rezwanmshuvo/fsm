<?php

use App\Model\Account;
use App\Model\Customer;
use App\Model\Page;
use App\Model\Party;
use App\Model\Purpose;
use App\Model\ItemCategory;
use App\Model\ApiKey;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //MAKING SHURE ALL THESE TABLES ARE EMPTY
        DB::statement("SET foreign_key_checks=0");
        DB::table('pages')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('users')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('accounts')->truncate();
        DB::table('customers')->truncate();
        DB::table('parties')->truncate();
        DB::table('purposes')->truncate();
        DB::table('item_categories')->truncate();
        DB::statement("SET foreign_key_checks=1");

        //CREATING DEFAULT PAGES
        Page::create([
            'title' => 'global'
        ]);
        Page::create([
            'title' => 'role'
        ]);
        Page::create([
            'title' => 'user'
        ]);
        Page::create([
            'title' => 'customer'
        ]);
        Page::create([
            'title' => 'item'
        ]);
        Page::create([
            'title' => 'shift'
        ]);
        Page::create([
            'title' => 'tank'
        ]);
        Page::create([
            'title' => 'machine'
        ]);
        Page::create([
            'title' => 'nozzel'
        ]);
        Page::create([
            'title' => 'purchase'
        ]);
        Page::create([
            'title' => 'sales'
        ]);
        Page::create([
            'title' => 'meter_reading'
        ]);
        Page::create([
            'title' => 'dip_reading'
        ]);
        Page::create([
            'title' => 'bank'
        ]);
        Page::create([
            'title' => 'purpose'
        ]);
        Page::create([
            'title' => 'deposite'
        ]);
        Page::create([
            'title' => 'withdraw'
        ]);
        Page::create([
            'title' => 'transfer'
        ]);
        Page::create([
            'title' => 'bank_statement'
        ]);
        Page::create([
            'title' => 'deposite_report'
        ]);
        Page::create([
            'title' => 'withdraw_report'
        ]);
        Page::create([
            'title' => 'sales_statement'
        ]);
        Page::create([
            'title' => 'purchase_statement'
        ]);
        Page::create([
            'title' => 'customer_ledger'
        ]);
        Page::create([
            'title' => 'supplier_ledger'
        ]);
        Page::create([
            'title' => 'settings'
        ]);
        Page::create([
            'title' => 'permission'
        ]);
        Page::create([
            'title' => 'party'
        ]);

        //CREATING DEFAULT PERMISSION
        $pages = array('global', 'role', 'user', 'customer','item','shift','tank','machine','nozzel','purchase','sales','meter_reading','dip_reading','bank','purpose','deposite','withdraw','transfer','bank_statement','deposite_report','withdraw_report','sales_statement','purchase_statement','customer_ledger','supplier_ledger','settings','permission','party');
        for($i=0; $i<count($pages); $i++)
        {
            if($pages[$i] != "global"){
                $view    = Permission::create(['name' => $pages[$i]." view"]);
                $add     = Permission::create(['name' => $pages[$i]." create"]);
                $edit    = Permission::create(['name' => $pages[$i]." edit"]);
                $delete  = Permission::create(['name' => $pages[$i]." delete"]);
            }else{
                $master    = Permission::create(['name' => "master"]);
                $global    = Permission::create(['name' => "global"]);
            }
        }

        //CREATING DEFAULT ROLE WITH THEIR PERMISSION
        $role_developer = Role::create(['name' => strtolower('developer')]);
        $role_developer->givePermissionTo(1);

        $role_super_admin = Role::create(['name' => strtolower('super admin')]);
        $role_super_admin->givePermissionTo(2);

        //CREATING DEFAULT USER WITH THEIR ROLE
        $user_master_developer = User::create([
            'name'     => 'Master Developer',
            'username' =>  'developer',
            'email' =>  'dev@email.com',
            'password' => Hash::make('password')
        ]);
        $user_master_developer->assignRole('developer');

        $user_super_admin = User::create([
            'name'     => 'Master Super Admin',
            'username' =>  'admin',
            'email'    =>  'admin@email.com',
            'password' => Hash::make('password')
        ]);
        $user_super_admin->assignRole('super admin');

        //CREATING DEFAULT BANKS
        $ar = Account::create([
            'user_id'           => 1,
            'bank_name'         =>  'Account Receivable (AR)',
            'opening_balance'   =>  0
        ]);

        $ap = Account::create([
            'user_id'           => 1,
            'bank_name'         =>  'Account Payable (AP)',
            'opening_balance'   =>  0
        ]);

        //CREATING DEFULT CUSTOMER
        $walking_customer = Customer::create([
            'name'              => 'Walking Customer',
            'user_id'           =>  1,
            'pos_customer_id'   => 1,
            'current_balance'   => 0
        ]);

         //CREATING DEFULT SUPPLIER
        $walking_supplier = Party::create([
            'name'              => 'Walking Supplier',
            'pos_supplier_id'   => 1,
            'user_id'           =>  1,
            'current_balance'   => 0
        ]);

        //CREATING DEFULT PURPOSES
        $si = Purpose::create([
            'name'              => 'Sales Invoice',
            'user_id'           =>  1,
            'purpose_type'      => 'income'
        ]);

        $sp = Purpose::create([
            'name'              => 'Sales Payment',
            'user_id'           =>  1,
            'purpose_type'      => 'income'
        ]);

        $csamp = Purpose::create([
            'name'              => 'Customer Store Account Manual Edit',
            'user_id'           =>  1,
            'purpose_type'      => 'income'
        ]);

        $pi = Purpose::create([
            'name'              => 'Purchase Invoice',
            'user_id'           =>  1,
            'purpose_type'      => 'expanse'
        ]);

        $pp = Purpose::create([
            'name'              => 'Purchase Payment',
            'user_id'           =>  1,
            'purpose_type'      => 'expanse'
        ]);

        $ssame = Purpose::create([
            'name'              => 'Supplier Store Account Manual Edit',
            'user_id'           =>  1,
            'purpose_type'      => 'expanse'
        ]);

        $dt = Purpose::create([
            'name'              => 'Deposit Transfer',
            'user_id'           =>  1,
            'purpose_type'      => 'income'
        ]);

        $wt = Purpose::create([
            'name'              => 'Withdraw Transfer',
            'user_id'           =>  1,
            'purpose_type'      => 'expanse'
        ]);

        //CREATING DEFULT ITEM CATEGORY
        $item_category = ItemCategory::create([
            'name'              => 'POS Category',
            'user_id'           =>  1,
        ]);

        //CREATING DEFULT API KEY
        $item_category = ApiKey::create([
            'name'              => 'Master Api',
            'system_key'        =>  'om59odgEwtkwczpXz5AdefIOy7NyidyE',
        ]);
    }
}
