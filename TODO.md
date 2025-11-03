# TODO: Add NIM to Users Table for Student Registration

## Tasks
- [x] Create migration `add_nim_to_users_table.php` to add string('nim')->nullable()->unique() column
- [x] Update `app/Models/User.php` to add 'nim' to fillable array
- [x] Update `resources/views/auth/register.blade.php` to add NIM input field
- [x] Update `app/Http/Controllers/Auth/RegisteredUserController.php` to add nim validation and creation
- [x] Update `database/factories/UserFactory.php` to include nim in definition
- [x] Update `database/seeders/UserSeeder.php` to add nim for mahasiswa user
- [x] Run `php artisan migrate` to apply the new migration
- [x] Test the registration form to ensure NIM is required and unique
- [x] Verify database constraints work correctly
