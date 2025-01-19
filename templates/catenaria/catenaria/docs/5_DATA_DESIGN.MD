# data structure design

Database design.

## thesis data tables

### model `Candidate`

First I set the model:

```bash
php artisan make:model Candidate --verbose --controller --resource --requests --policy --migration --factory --seed --pest
php artisan livewire:form CandidateForm
```

Then I create the view and controller part:

```bash
php artisan make:livewire UserInterface/Candidate/index
php artisan make:livewire UserInterface/Candidate/create
php artisan make:livewire UserInterface/Candidate/read
php artisan make:livewire UserInterface/Candidate/edit
```

and register:

```bash
php artisan make:livewire UserInterface/Candidate/register
```

### model `Role`

Here too, the model comes first:

```bash
php artisan make:model Role --verbose --controller --resource --requests --policy --migration --factory --seed --pest
php artisan livewire:form RoleForm
```

Then the implementation of the view/controller:

```bash
php artisan make:livewire UserInterface/Role/index
php artisan make:livewire UserInterface/Role/create
php artisan make:livewire UserInterface/Role/read
php artisan make:livewire UserInterface/Role/edit
```

### model `Privilege`

Again, first the model:

```bash
php artisan make:model Privilege --verbose --controller --resource --requests --policy --migration --factory --seed --pest
php artisan livewire:form PrivilegeForm
```

Then the view/controller:

```bash
php artisan make:livewire UserInterface/Privilege/index
php artisan make:livewire UserInterface/Privilege/create
php artisan make:livewire UserInterface/Privilege/read
php artisan make:livewire UserInterface/Privilege/edit
```

### model `Team`

Again, first the model:

```bash
php artisan make:model Team --verbose --controller --resource --requests --policy --migration --factory --seed --pest
php artisan livewire:form TeamForm
```

Then the view/controller:

```bash
php artisan make:livewire UserInterface/Team/index
php artisan make:livewire UserInterface/Team/create
php artisan make:livewire UserInterface/Team/read
php artisan make:livewire UserInterface/Team/edit
```

### model `Employee`

Again, first the model:

```bash
php artisan make:model Employee --verbose --controller --resource --requests --policy --migration --factory --seed --pest
php artisan livewire:form EmployeeForm
```

Then the view/controller:

```bash
php artisan make:livewire UserInterface/Employee/index
php artisan make:livewire UserInterface/Employee/create
php artisan make:livewire UserInterface/Employee/read
php artisan make:livewire UserInterface/Employee/edit
```

and login:

```bash
php artisan make:livewire UserInterface/Employee/login
```

### model `User`

In this case the model is already present, so I go directly to the view/controller:

```bash
php artisan make:livewire UserInterface/User/index
php artisan make:livewire UserInterface/User/create
php artisan make:livewire UserInterface/User/read
php artisan make:livewire UserInterface/User/edit
```

### pivots

```bash
php artisan make:model EmployeeRole --verbose --pivot --migration
php artisan make:model EmployeePrivilege --verbose --pivot --migration
php artisan make:model EmployeeTeam --verbose --pivot --migration
```

### data model definition, factories, seeders and migration

```bash
php artisan migrate:status
php artisan migrate --pretend
php artisan migrate
php artisan migrate:status
php artisan model:show Candidate
php artisan model:show Role
php artisan model:show Privilege
php artisan model:show Employee
php artisan model:show Team
php artisan model:show User
php artisan db:show
php artisan db:show --counts
php artisan db:table -- candidates
php artisan db:table -- roles
php artisan db:table -- privileges
php artisan db:table -- employees
php artisan db:table -- teams
php artisan db:table -- users
```

Check:

```bash
php artisan tinker
```

and now:

```sh
App\Models\Candidate::all()
App\Models\Role::all()
App\Models\Privilege::all()
App\Models\Employee::all()
App\Models\Team::all()
App\Models\User::all()
quit
```

Now type:

```bash
php artisan db:wipe && php artisan migrate:fresh && php artisan migrate:status
```

### only if I need to go back to the previous migration

```bash
php artisan migrate:rollback
```

## seed

Once classes `factories` and `seeders` are ready, you can send the following command:

```bash
php artisan db:seed
```
